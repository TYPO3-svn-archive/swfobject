<?php
/*
 * $Id$
 */

if (!defined ('TYPO3_MODE')) die ('Access denied.');


t3lib_extMgm::allowTableOnStandardPages('tx_swfobject_movie');

$TCA['tx_swfobject_movie'] = Array (
	'ctrl' => Array (
		'title' => 'LLL:EXT:swfobject/locallang_db.xml:tx_swfobject_movie',		
		'label' => 'title',	
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => Array (		
			'disabled' => 'hidden',	
		),
		'dividers2tabs' => true,
		'useColumnsForDefaultValues' => 'type',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'languageField' => 'sys_language_uid',		
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_swfobject_movie.gif",
	),
	'feInterface' => Array (
		'fe_admin_fieldList' => 'hidden, description, file, width, height',
	)
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_addlist'][$GLOBALS['_EXTKEY'].'_pi1'] = 'pi_flexform';
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$GLOBALS['_EXTKEY'].'_pi1'] = 'layout,select_key,pages,recursive';

t3lib_extMgm::addStaticFile($GLOBALS['_EXTKEY'],'pi1/static/','Flash movie (SWFObject 2.1)');

t3lib_extMgm::addPlugin(array('LLL:EXT:swfobject/locallang_db.xml:tt_content.list_type_pi1', $GLOBALS['_EXTKEY'].'_pi1'), 'list_type');
if (t3lib_extMgm::isLoaded('dam')) {
	t3lib_div::loadTCA('tx_swfobject_movie');
	$tempColumns = array (
    	'file' => txdam_getMediaTCA('media_field', 'swfobject')
	);
	$tempColumns['file']['config']['allowed_types'] = 'swf';
	$tempColumns['file']['config']['disallowed_types'] = '';
	$tempColumns['file']['config']['max_size'] = '500000';
	$tempColumns['file']['config']['size'] = '1';
	$tempColumns['file']['config']['maxitems'] = '1';
	$tempColumns['file']['config']['minitems'] = '1';

  	$TCA['tx_swfobject_movie']['columns']['file']['config'] = $tempColumns['file']['config'];
  	//add flexform with DAM support	
	t3lib_extMgm::addPiFlexFormValue($GLOBALS['_EXTKEY'].'_pi1', 'FILE:EXT:swfobject/flexformdam_ds.xml');
}else {
	//add flexform without DAM
	t3lib_extMgm::addPiFlexFormValue($GLOBALS['_EXTKEY'].'_pi1', 'FILE:EXT:swfobject/flexform_ds.xml');
}

if (TYPO3_MODE=='BE') $TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_swfobject_pi1_wizicon'] = t3lib_extMgm::extPath($GLOBALS['_EXTKEY']).'pi1/class.tx_swfobject_pi1_wizicon.php';
?>