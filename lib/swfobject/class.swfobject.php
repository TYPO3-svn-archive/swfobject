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
 * Wrapper class for the SWFObject 2.0
 * 
 * @see http://code.google.com/p/swfobject/
 * 
 * @author	Bastian Waidelich <waidelich@network-publishing.de>
 * @package	TYPO3
 * @subpackage	tx_swfobject
 */
class swfobject {
	
	// ### fields ###
	
	/**
	 * publishing method (dynamic/static)
	 *
	 * @var string
	 */
	var $publishingMethod = 'dynamic';

	/**
	 * Required Flash version (major)
	 *
	 * @var integer
	 */
	var $detectMajor = 9;
	
	/**
	 * Required Flash version (minor)
	 *
	 * @var integer
	 */
	var $detectMinor = 0;
	
	/**
	 * Required Flash version (release)
	 *
	 * @var integer
	 */
	var $detectRelease = 0;
	
	/**
	 * Use Adobe Express Install
	 *
	 * @var boolean
	 */
	var $expressInstall = FALSE;
	
	/**
	 * expressInstall.swf file
	 * @see http://kb.adobe.com/selfservice/viewContent.do?externalId=6a253b75
	 *
	 * @var string
	 */
	var $expressInstallSwf = 'expressInstall.swf';
	
	/**
	 * Specifies the id attribute of the HTML container element that will be replaced with Flash content
	 *
	 * @var string
	 */
	var $replaceId = 'flashmovie';
	
	/**
	 * The relative or absolute path to your Flash content .swf file
	 *
	 * @var string
	 */
	var $swf;
	
	/**
	 * Width of the Flash content
	 *
	 * @var integer
	 */
	var $width = 800;
	
	/**
	 * Height of the Flash content
	 *
	 * @var integer
	 */
	var $height = 600;
	
	/**
	 * Unit of above Flash content dimensions above (pixels/percentage)
	 *
	 * @var string
	 */
	var $unit = 'pixels';
	
	/**
	 * Uniquely identifies the Flash movie so that it can be referenced using a scripting language or by CSS
	 *
	 * @var string
	 */
	var $attId;
	
	/**
	 * HTML object element attributes
	 *
	 * @var array
	 */
	var $attributes = array();
	
	/**
	 * HTML object element nested param elements
	 *
	 * @var array
	 */
	var $params = array();
	
	/**
	 * Method to pass variables to a Flash movie.
	 *
	 * @var array
	 */
	var $flashvars = array();
	
	/**
	 * The object element allows you to nest alternative content inside of it,
	 * which will be displayed if Flash is not installed or supported.
	 * This content will also be picked up by search engines, making it a great tool for creating search-engine-friendly content.
	 * 
	 * Summarized, you should use alternative content for the following:
	 * - When you like to create content that is accessible for people who browse the Web without plugins
	 * - When you like to create search-engine-friendly content
	 * - To tell visitors that they can have a richer user experience by downloading the Flash plugin
	 *
	 * @var string
	 */
	var $alternativeContent = '<em>no flash plugin available</em>';
	
	/**
	 * Adds defer="defer" to the script-tag of the javascript code which
	 * indicates that the script is not going to generate any document content.
	 * So the browser can continue parsing and drawing the page
	 * 
	 * @var boolean
	 */
	var $deferredMode = TRUE;
	
	// ### properties ###
	

	/**
	 * @return string
	 */
	function getAlternativeContent() {
		return $this->alternativeContent;
	}
	
	/**
	 * @param string $alternativeContent
	 */
	function setAlternativeContent($alternativeContent) {
		$this->alternativeContent = $alternativeContent;
	}
	
	/**
	 * @return string
	 */
	function getAttId() {
		return $this->attId;
	}
	
	/**
	 * @param string $attId
	 */
	function setAttId($attId) {
		$this->attId = $attId;
	}
	
	/**
	 * @return integer
	 */
	function getDetectMajor() {
		return $this->detectMajor;
	}
	
	/**
	 * @param integer $detectMajor
	 */
	function setDetectMajor($detectMajor) {
		$this->detectMajor = $detectMajor;
	}
	
	/**
	 * @return integer
	 */
	function getDetectMinor() {
		return $this->detectMinor;
	}
	
	/**
	 * @param integer $detectMinor
	 */
	function setDetectMinor($detectMinor) {
		$this->detectMinor = $detectMinor;
	}
	
	/**
	 * @return integer
	 */
	function getDetectRelease() {
		return $this->detectRelease;
	}
	
	/**
	 * @param integer $detectRelease
	 */
	function setDetectRelease($detectRelease) {
		$this->detectRelease = $detectRelease;
	}
	
	/**
	 * @return boolean
	 */
	function getExpressInstall() {
		return $this->expressInstall;
	}
	
	/**
	 * @param boolean $expressInstall
	 */
	function setExpressInstall($expressInstall) {
		$this->expressInstall = $expressInstall;
	}
	
	/**
	 * @return string
	 */
	function getExpressInstallSwf() {
		return $this->expressInstallSwf;
	}
	
	/**
	 * @param string $expressInstallSwf
	 */
	function setExpressInstallSwf($expressInstallSwf) {
		$this->expressInstallSwf = $expressInstallSwf;
	}
	
	/**
	 * @return integer
	 */
	function getHeight() {
		return $this->height;
	}
	
	/**
	 * @param integer $height
	 */
	function setHeight($height) {
		$this->height = $height;
	}
	
	/**
	 * @return string
	 */
	function getPublishingMethod() {
		return $this->publishingMethod;
	}
	
	/**
	 * @param string $publishingMethod
	 */
	function setPublishingMethod($publishingMethod) {
		$this->publishingMethod = $publishingMethod;
	}
	
	/**
	 * @return string
	 */
	function getReplaceId() {
		return $this->replaceId;
	}
	
	/**
	 * @param string $replaceId
	 */
	function setReplaceId($replaceId) {
		$this->replaceId = $replaceId;
	}
	
	/**
	 * @return string
	 */
	function getSwf() {
		return $this->swf;
	}
	
	/**
	 * @param string $swf
	 */
	function setSwf($swf) {
		$this->swf = $swf;
	}
	
	/**
	 * @return string
	 */
	function getUnit() {
		return $this->unit;
	}
	
	/**
	 * @param string $unit
	 */
	function setUnit($unit) {
		$this->unit = $unit;
	}
	
	/**
	 * @return integer
	 */
	function getWidth() {
		return $this->width;
	}
	
	/**
	 * @param integer $width
	 */
	function setWidth($width) {
		$this->width = $width;
	}
	/**
	 * @return boolean
	 */
	function getDeferredMode() {
		return $this->deferredMode;
	}
	
	/**
	 * @param boolean $deferredMode
	 */
	function setDeferredMode($deferedExecution) {
		$this->deferredMode = $deferedExecution;
	}


	
	// ### constructor ###
	
	// ### methods ###
	
	function jsCode()  {
		$content = '';
		
			// flashvars
		$content.= 'var flashvars = {};'.chr(10);
		foreach($this->flashvars as $key => $value) {
			$content.= 'flashvars.'.$key.' = "'.$value.'";'.chr(10);
		}
		
			// params
		$content.= 'var params = {};'.chr(10);
		foreach($this->params as $key => $value) {
			$content.= 'params.'.$key.' = "'.$value.'";'.chr(10);
		}
		
			// attributes
		$content.= 'var attributes = {};'.chr(10);
		foreach($this->attributes as $key => $value) {
			$content.= 'attributes.'.$key.' = "'.$value.'";'.chr(10);
		}
		
		$width = $this->width;
		$height = $this->height;
		if ($this->unit == 'percentage') {
			$width.= '%';
			$height.= '%';
		}
		
		$version = $this->detectMajor.'.'.$this->detectMinor.'.'.$this->detectRelease;
		$expressInstallSwf = $this->expressInstall ? '"'.$this->expressInstallSwf.'"' : 'false';
		
		$content.= sprintf(
			'swfobject.embedSWF("%s", "%s", "%s", "%s", "%s", %s, %s, %s, %s);',
			$this->swf,
			$this->replaceId,
			$width,
			$height,
			$version,
			$expressInstallSwf,
			'flashvars',
			'params',
			'attributes'
		);
		
			// enclose in javascript tags
		$content = '<script type="text/javascript"'.($this->deferredMode ? ' defer="defer"' : '').'>'.chr(10).$content.chr(10).'</script>';
		
		return $content;
	}
	
	/**
	 * Returns the container for the flash object
	 *
	 * @return	string	div-container and JavaScript
	 */
	function htmlCode() {
		$content = '';
		
			// container containing content to be replaced with flash content
		$content.= '<div id="'.$this->replaceId.'">'.$this->alternativeContent.'</div>';
		
		return $content;
	}

	/**
	 * adds a FlashVar to pass on to the flash object.
	 * Example: addFlashvar('variable1', 'value1');
	 *
	 * @param	string	FlashVar key
	 * @param	string	FlashVar value
	 */
	function addFlashvar($key, $value) {
		$this->flashvars[$key] = htmlspecialchars($value);
	}
	
	/**
	 * adds a parameter to set on the flash object.
	 * Example: addParam('wmode', 'transparent');
	 *
	 * @param	string	parameter key
	 * @param	string	parameter value
	 */
	function addParam($key, $value) {
		$this->params[$key] = htmlspecialchars($value);
	}
	
	/**
	 * adds an attribute to be passed to the SWFObject
	 * Example: addAttribute('align', 'right');
	 *
	 * @param	string	attribute key
	 * @param	string	attribute value
	 */
	function addAttribute($key, $value) {
		$this->attributes[$key] = htmlspecialchars($value);
	}

}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/swfobject/lib/class.swfobject.php'])	{
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/swfobject/lib/class.swfobject.php']);
}

?>