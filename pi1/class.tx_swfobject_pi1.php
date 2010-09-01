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
	var $sys_language_mode;	
	var $allowedAttributes = array('name', 'class', 'align', 'id');
	var $allowedParameters = array('play', 'loop', 'menu', 'quality', 'scale', 'salign', 'wmode', 'bgcolor', 'devicefont', 'seamlesstabbing', 'swlifeconnect', 'allowfullscreen', 'allowscriptaccess', 'allownetworking', 'base');
	var $getID3;
	var $useGetid3;	
	var $movieFolder = 'uploads/tx_swfobject/';
	var $recordConf;
	var $flexformConf;
	var $dbTable = 'tx_swfobject_movie';
	var $renderMode;
	var $damEnabled;
	
	
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
		$this->init($conf);
		// set standard options (id, swf, size)
		$replaceId = strlen($this->conf['attributes.']['id']) ? $this->conf['attributes.']['id'] : 'swf'.substr(md5(uniqid(rand(), TRUE)), 0, 8);
		$this->swfobject->setReplaceId($replaceId);
		
		$file = $this->getFile();
		$this->swfobject->setSwf($file);
		
		$size = $this->getFileDimensions($file);
		$this->swfobject->setWidth($size['width']);
		$this->swfobject->setHeight($size['height']);
		//$this->swfobject->setUnit($this->conf['unit']);
		
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
			if (strlen($this->conf['attributes.'][$attribute])) {
				$this->swfobject->addAttribute($attribute, $this->conf['attributes.'][$attribute]);
			}
		}
		
			// parameters
		foreach($this->allowedParameters as $parameter) {
			if (strlen($this->conf['parameter.'][$parameter])) {
				$this->swfobject->addParam($parameter, $this->conf['parameter.'][$parameter]);
			}
		}
		
			// flashvars
		$flashVars = t3lib_div::trimExplode(chr(10), $this->conf['flashVars'], 1);
		foreach ($flashVars as $flashVar) {
			list($key, $value) = t3lib_div::trimExplode('=', $flashVar);
			$value = $this->cObj->stdWrap($value, $this->conf['flashVars_stdWrap.']);
			$this->swfobject->addFlashvar($key, $value);
		}

			// deferred Mode
		$this->swfobject->setDeferredMode((boolean)$this->conf['deferredMode']);
		
		$alternativeContent = '';
		if (strlen($this->conf['alternativeContentText'])) {
			$alternativeContent = $this->pi_RTEcssText($this->conf['alternativeContentText']);
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
		
		return $this->pi_wrapInBaseClass($this->cObj->stdWrap($content, $this->conf['alternativeContentStdWrap.']));
	}

	
	
	function init($conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_initPIflexForm();
		$this->flexformConf = $this->cObj->data['pi_flexform']['data'];
		//check if DAM is enabled
		$this->damEnabled = t3lib_extMgm::isLoaded('dam');
		//if no flexform is available then the movie is inserted by typoscript
		if(!is_array($this->flexformConf)){
			$this->renderMode = 'TS';
		} else {
			$this->renderMode = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'mode', 'sDEF');
			if($this->renderMode == 'FILE') {
      			$this->mergeConfigurationWithFlexFormValues();
				//use flexform configuration
				if($this->damEnabled) {
					//get dam reference
      				$arr = tx_dam_db::getReferencedFiles('tt_content',$this->cObj->data['uid'],'swfobject','tx_dam_mm_ref');
      				
      				if ($arr['files']) {
      					$this->conf['file'] = array_shift(array_slice($arr['files'],0,1));
      				}
				} else {
					$this->conf['file'] = $this->movieFolder.$this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'file', 'sDEF');;
				}
      			
			} else {
				//use record configuration			
				$recordUid = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'record', 'sDEF');
				//load the movie data
	  			$singleWhere = $this->dbTable.'.uid=' . intval($recordUid);
	  			$singleWhere .= $this->cObj->enableFields($this->dbTable);
	  			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', $this->dbTable, $singleWhere);
	  			$this->recordConf = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
			    
	  			if ($GLOBALS['TSFE']->sys_language_content) {
					$OLmode = ($this->sys_language_mode == 'strict'?'hideNonTranslated':'');
					$this->recordConf = $GLOBALS['TSFE']->sys_page->getRecordOverlay($this->dbTable, $this->recordConf, $GLOBALS['TSFE']->sys_language_content, $OLmode);
				}
				
				if($this->damEnabled) {
					if ($GLOBALS['TSFE']->sys_language_content  && isset($this->recordConf['_LOCALIZED_UID'])) {
						$contentUid = $this->recordConf['_LOCALIZED_UID'];
					} else{
						$contentUid = $this->recordConf['uid'];
					}					
					$arr = tx_dam_db::getReferencedFiles($this->dbTable,$contentUid,'swfobject','tx_dam_mm_ref');
      				if ($arr['files']) {
      					$this->conf['file'] = $this->recordConf['file'] = array_shift(array_slice($arr['files'],0,1));
      				}
				} else {
					$this->conf['file'] = $this->recordConf['file'] = $this->movieFolder.$this->recordConf['file'];
				}
				//merge configuration with Typoscript
				$this->mergeConfigurationWithRecordValues();
				//merge configuration with Flexform
      			$this->mergeConfigurationWithFlexFormValues();
      			//reset file to the file from the record as it gets overridden with wrong value
      			$this->conf['file'] = $this->recordConf['file'];
      			//debug($this->conf, 'merged flexform conf');
			}
			
		}		
		
		// create instance of swfobject wrapper
		$this->swfobject = t3lib_div::makeInstance('swfobject');		
		
		//check if getID3 is installed	
		$this->useGetid3 = false;
		if (t3lib_extMgm::isLoaded('t3getid3')) {
			require_once(t3lib_extMgm::extPath('t3getid3').'getid3/getid3.php');
			$this->useGetid3 = true;
			$this->conf['getid3Version17'] = true;
		} elseif (t3lib_extMgm::isLoaded('getid3')) {
			require_once(t3lib_extMgm::extPath('getid3').'classes/getid3.php');
			$this->conf['getid3Version17'] = true;
			$this->useGetid3 = true;
		} elseif (isset($this->conf['getid3Path'])) {
			require_once($this->conf['getid3Path'].'getid3.php');
			$this->useGetid3 = true;
		}
		if ($this->conf['getid3Version17'] ) {
			$this->getID3 = new getID3;
		}	
	}
	

	
	
	function getFile() {
		$file = $this->conf['file'];
		//@TODO: add hook to override file fetching		
		return $file;
	}
	
	
	/**
	 * tries to fetch movie dimensions with getID3
	 * 
	 * @param file	String 	path to swf file
	 * 
	 * @return Associative Array with the keys "width" an "height"
	 */	
	function getFileDimensions($file) {
		//get width of movie
 		if (trim($this->conf['width'])) {
				$width = trim($this->conf['width']);
		} else {
			if ($this->useGetid3) {
				if (is_object($this->getID3)) {
					$movieInfo = $this->getID3->analyze($file);
				} else {
					$movieInfo = GetAllFileInfo($file);
				}
				
				$width = $movieInfo['video']['resolution_x'];
				//fallback if no with is found
				if (!$width) $width = $this->conf['default.']['width'];
			} 
		}
		//get height of movie
		if (trim($this->conf['height'])) {
			$height = trim($this->conf['height']);
		} else {
			if ($this->useGetid3 && !$movieInfo) {
				if (is_object($this->getID3)) {
					$movieInfo = $this->getID3->analyze($contentConf['flashmovie']);
				} else {
					$movieInfo = GetAllFileInfo($contentConf['flashmovie']);
				}
			}
			$height = $movieInfo['video']['resolution_y'];
			if (!$height) $height = $this->conf['default.']['height'];
		}
    	
    	$contentConf['width'] = $width;
    	$contentConf['height'] = $height;
    	//empty getID3 object to save memory
    	$this->getID3 = null;
    	return array('width' => $width, 'height' => $height);
	}

	
	
	
	
	function mergeConfigurationWithRecordValues() {
		$excludeFields = array('uid', 'pid', 'deleted', 'hidden','tstamp', 'crdate','cruser_id', 'title', 'sys_language_uid', 'l18n_parent', 'l18n_diffsource');
		
		foreach($this->recordConf as $key => $value) {
			if (strlen($value) && !in_array($key, $excludeFields)) {
				//its an attribute, merge with attributes array
				if(strpos($key, "attribute_") !== false) {
					$attrKey = str_replace('attribute_','',$key);
					$this->conf['attributes.'][$attrKey] = $value;
				} elseif (strpos($key, "parameter_") !== false) {
					$paramKey = str_replace('parameter_','',$key);
					$this->conf['parameter.'][$paramKey] = $value;
				} else {	
					$this->conf[$key] = $value;
				}
			}
		}
	}
	
	
	
	function mergeConfigurationWithFlexFormValues() {
		 // @todo: retrieve languagePointer via sys_language_uid
		$languagePointer = 'lDEF';
		$valuePointer = 'vDEF';

		foreach((array)$this->cObj->data['pi_flexform']['data'] as $languages) {
			foreach((array)$languages[$languagePointer] as $key => $def) {
				$value = $def[$valuePointer];
				if (strlen($value)) {
					//its an attribute, merge with attributes array
					if(strpos($key, "attribute_") !== false) {
						$attrKey = str_replace('attribute_','',$key);
						$this->conf['attributes.'][$attrKey] = $value;
					} elseif (strpos($key, "parameter_") !== false) {
						$paramKey = str_replace('parameter_','',$key);
						$this->conf['parameter.'][$paramKey] = $value;
					} else {	
						$this->conf[$key] = $value;
					}
				}
			}
		}
	}

}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/swfobject/pi1/class.tx_swfobject_pi1.php'])	{
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/swfobject/pi1/class.tx_swfobject_pi1.php']);
}
?>