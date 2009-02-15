<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_swfobject_movie=1
');

t3lib_extMgm::addPItoST43($GLOBALS['_EXTKEY'],'pi1/class.tx_swfobject_pi1.php','_pi1','list_type',1);

//###########################################################
//set TCA for DAM fields which load visual assets into flash
//###########################################################

$GLOBALS['T3_VAR']['ext']['dam']['TCA']['flashmedia_config'] =
		array (
				'form_type' => 'user',
				'userFunc' => 'EXT:dam/lib/class.tx_dam_tcefunc.php:&tx_dam_tceFunc->getSingleField_typeMedia',

				'userProcessClass' => 'EXT:mmforeign/class.tx_mmforeign_tce.php:tx_mmforeign_tce',
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_dam',
				'prepend_tname' => 1,
				'MM' => 'tx_dam_mm_ref',
				'MM_foreign_select' => 1, // obsolete in 4.1
				'MM_opposite_field' => 'file_usage',
				'MM_match_fields' => array('ident' => 'relation_field_or_other_ident'), #### has to be changed in table

				'allowed_types' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'].',swf',

				'max_size' => '1000',
				'show_thumbs' => 1,
				'size' => 5,
				'maxitems' => 200,
				'minitems' => 0,
				'autoSizeMax' => 30,
		);


if (t3lib_div::int_from_ver(TYPO3_branch)>=t3lib_div::int_from_ver('4.1')) {
	unset($GLOBALS['T3_VAR']['ext']['dam']['TCA']['flashmedia_config']['userProcessClass']);
}


$GLOBALS['T3_VAR']['ext']['dam']['TCA']['flashmedia_field'] =
		array (
			'label' => 'LLL:EXT:cms/locallang_ttc.php:media',
			'config' => $GLOBALS['T3_VAR']['ext']['dam']['TCA']['flashmedia_config'],
);
?>