<?php
/*
 * $Id$
 */

if (!defined ('TYPO3_MODE')) die ('Access denied.');

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_addlist'][$GLOBALS['_EXTKEY'].'_pi1'] = 'pi_flexform';
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$GLOBALS['_EXTKEY'].'_pi1'] = 'layout,select_key,pages,recursive';

t3lib_extMgm::addStaticFile($GLOBALS['_EXTKEY'],'pi1/static/','Flash movie (SWFObject 2.0)');

t3lib_extMgm::addPlugin(array('LLL:EXT:swfobject/locallang_db.xml:tt_content.list_type_pi1', $GLOBALS['_EXTKEY'].'_pi1'), 'list_type');
t3lib_extMgm::addPiFlexFormValue($GLOBALS['_EXTKEY'].'_pi1', 'FILE:EXT:swfobject/flexform_ds.xml');


if (TYPO3_MODE=='BE') $TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_swfobject_pi1_wizicon'] = t3lib_extMgm::extPath($GLOBALS['_EXTKEY']).'pi1/class.tx_swfobject_pi1_wizicon.php';
?>