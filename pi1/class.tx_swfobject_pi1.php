<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Bastian Waidelich <waidelich@network-publishing.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * class.tx_swfobject_pi1.php
 *
 * swfObject 2.0 for TYPO3.
 * 
 * $Id$
 */

require_once(PATH_tslib.'class.tslib_pibase.php');
require_once(t3lib_extMgm::extPath('swfobject').'lib/swfobject/class.swfobject.php');


/**
 * Plugin 'Flash movie' for the 'swfobject' extension.
 *
 * @author	Bastian Waidelich <waidelich@network-publishing.de>
 * @package	TYPO3
 * @subpackage	tx_swfobject
 */
class tx_swfobject_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_swfobject_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_swfobject_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'swfobject';	// The extension key.
	var $pi_checkCHash = true;
	var $allowedAttributes = array('name', 'class', 'align');
	var $allowedParameters = array('play', 'loop', 'menu', 'quality', 'scale', 'salign', 'wmode', 'bgcolor', 'devicefont', 'seamlesstabbing', 'swlifeconnect', 'allowfullscreen', 'allowscriptaccess', 'allownetworking', 'base');
	
	/**
	 * the SWFObject 2.0 wrapper
	 * @see http://code.google.com/p/swfobject/
	 *
	 * @var swfobject
	 */
	var $swfobject;
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->mergeConfigurationWithFlexFormValues();
		
			// create instance of swfobject wrapper
		$this->swfobject = t3lib_div::makeInstance('swfobject');
		
			// set standard options (id, swf, size)
		$replaceId = 'swf'.substr(md5(uniqid(rand(), TRUE)), 0, 8);
		$this->swfobject->setReplaceId($replaceId);
		$this->swfobject->setSwf($this->conf['swfFolder'].$this->conf['swf']);
		$this->swfobject->setWidth($this->conf['width']);
		$this->swfobject->setHeight($this->conf['height']);
		$this->swfobject->setUnit($this->conf['unit']);
		
			// flash detection
		list($major, $minor, $release) = t3lib_div::trimExplode('.', $this->conf['requiredVersion']);
		$this->swfobject->setDetectMajor(intval($major));
		$this->swfobject->setDetectMinor(intval($minor));
		$this->swfobject->setDetectRelease(intval($release));
		
			// Adobe Express Installer (@see http://www.adobe.com/cfusion/knowledgebase/index.cfm?id=6a253b75)
		$this->swfobject->setExpressInstallSwf($GLOBALS['TSFE']->tmpl->getFileName($this->conf['expressInstallSwf']));
		$this->swfobject->setExpressInstall($this->conf['expressInstall']);
		
			// attributes
		foreach($this->allowedAttributes as $attribute) {
			if (strlen($this->conf['attribute_'.$attribute])) {
				$this->swfobject->addAttribute($attribute, $this->conf['attribute_'.$attribute]);
			}
		}
		
			// parameters
		foreach($this->allowedParameters as $parameter) {
			if (strlen($this->conf['parameter_'.$parameter])) {
				$this->swfobject->addParam($parameter, $this->conf['parameter_'.$parameter]);
			}
		}
		
			// flashvars
		$flashVars = t3lib_div::trimExplode(chr(10), $this->conf['flashVars'], 1);
		foreach ($flashVars as $flashVar) {
			list($key, $value) = t3lib_div::trimExplode('=', $flashVar);
			$value = $this->cObj->stdWrap($value, $this->conf['flashVarsSetup.']);
			$this->swfobject->addFlashvar($key, $value);
		}

			// deferred Mode
		$this->swfobject->setDeferredMode((boolean)$this->conf['deferredMode']);
		
		$alternativeContent = '';
		if (strlen($this->conf['alternativeContent'])) {
			$alternativeContent = $this->pi_RTEcssText($this->conf['alternativeContent']);
		} else {
			$this->conf['alternativeContentSetup.']['source'] = intval($this->conf['alternativeContentReference']);
			$alternativeContent = $this->cObj->cObjGetSingle($this->conf['alternativeContentSetup'],$this->conf['alternativeContentSetup.']);
		}
		
		$this->swfobject->setAlternativeContent($alternativeContent);

		$GLOBALS['TSFE']->additionalHeaderData[$this->prefixId] = '<script type="text/javascript" src="'.t3lib_extMgm::siteRelPath('swfobject').'lib/swfobject/swfobject.js"></script>';
		$content.= $this->swfobject->htmlCode().chr(10);
		
		if ($this->conf['addScriptToBody']) {
			$content.= $this->swfobject->jsCode().chr(10);
		} else {
			$GLOBALS['TSFE']->additionalHeaderData[$this->prefixId.'_'.$replaceId] = $this->swfobject->jsCode();
		}
		
		return $this->pi_wrapInBaseClass($content);
	}
	
	function mergeConfigurationWithFlexFormValues() {
		 // @todo: retrieve languagePointer via sys_language_uid
		$languagePointer = 'lDEF';
		$valuePointer = 'vDEF';
		
		$this->pi_initPIflexForm();
		
		foreach((array)$this->cObj->data['pi_flexform']['data'] as $languages) {
			foreach((array)$languages[$languagePointer] as $key => $def) {
				$value = $def[$valuePointer];
				if (strlen($value)) {
					$this->conf[$key] = $value;
				}
			}
		}
	}

}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/swfobject/pi1/class.tx_swfobject_pi1.php'])	{
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/swfobject/pi1/class.tx_swfobject_pi1.php']);
}
?>