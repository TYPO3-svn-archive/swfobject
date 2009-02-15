<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_swfobject_movie'] = Array (
	'ctrl' => $TCA['tx_swfobject_movie']['ctrl'],
	'interface' => Array (
		'showRecordFieldList' => 'hidden,description,file,width,height,requiredVersion'
	),
	'feInterface' => $TCA['tx_swfobject_movie']['feInterface'],
	'columns' => Array (
		'title' => Array (
			'l10n_mode' => 'prefixLangTitle',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.title',		
			'config' => Array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required',
			)
		),
		'file' => Array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.file',		
			'config' => Array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => 'swf',	
				'max_size' => 500000,	
				'uploadfolder' => 'uploads/tx_swfobject',
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'width' => Array (
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.width',		
			'config' => Array (
				'type' => 'input',	
				'size' => '10',	
				//'eval' => 'required',
			)
		),
		'height' => Array (
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.height',		
			'config' => Array (
				'type' => 'input',	
				'size' => '10',	
				//'eval' => 'required',
			)
		),
		'requiredVersion' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.requiredVersion',		
			'config' => Array (
				'type' => 'input',	
				'size' => '5',
			)
		),

		'expressInstall' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.expressInstall',		
			'config' => Array (
				'type' => 'check',
			)
		),		
		
		'alternativeContentReference' => Array (
			'l10n_mode' => 'mergeIfNotBlank',	
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.alternativeContentReference',		
			'config' => Array (
				'type' => 'group',	
				'internal_type' => 'db',	
				'allowed' => 'tt_content',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		
		'alternativeContentText' => Array (
		    'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.alternativeContentText',
		    'l10n_mode' => $l10n_mode,
		    'config' => Array (
		        'type' => 'text',
		        'cols' => '48',
		        'rows' => '5',
		        'softref' => 'typolink_tag,images,email[subst],url',
		        'wizards' => Array(
		            '_PADDING' => 4,
		            'RTE' => Array(
		                'notNewRecords' => 1,
		                'RTEonly' => 1,
		                'type' => 'script',
		                'title' => 'LLL:EXT:cms/locallang_ttc.php:bodytext.W.RTE',
		                'icon' => 'wizard_rte2.gif',
		                'script' => 'wizard_rte.php',
		            ),
		        )
		    )
		),		

		'attribute_name' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.attribute_name',		
			'config' => Array (
				'type' => 'input',	
				'size' => '30',	
			)
		),

		'attribute_class' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.attribute_class',		
			'config' => Array (
				'type' => 'input',	
				'size' => '30',	
			)
		),	

		'attribute_id' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.attribute_id',		
			'config' => Array (
				'type' => 'input',	
				'size' => '30',	
			)
		),			
		
		'attribute_align' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.attribute_align',		
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('Choose...', ''),
					Array('middle', 'middle'),
					Array('left', 'left'),
					Array('right', 'right'),
					Array('top', 'top'),
					Array('bottom', 'bottom'),
					),
				'size' => 1,	
				'maxitems' => 1,
			)
		),
		'parameter_play' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.parameter_play',		
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('Choose...', ''),
					Array('true', 'true'),
					Array('false', 'false'),
					),
				'size' => 1,	
				'maxitems' => 1,
			)
		),
		'parameter_loop' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.parameter_loop',		
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('Choose...', ''),
					Array('true', 'true'),
					Array('false', 'false'),
					),
				'size' => 1,	
				'maxitems' => 1,
			)
		),		
		'parameter_menu' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.parameter_menu',		
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('Choose...', ''),
					Array('true', 'true'),
					Array('false', 'false'),
					),
				'size' => 1,	
				'maxitems' => 1,
			)
		),
		'parameter_quality' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.parameter_quality',		
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('Choose...', ''),
					Array('best', 'best'),
					Array('high', 'high'),
					Array('medium', 'medium'),
					Array('autohigh', 'autohigh'),
					Array('autolow', 'autolow'),
					Array('low', 'low'),
					),
				'size' => 1,	
				'maxitems' => 1,
			)
		),
		'parameter_scale' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.parameter_scale',		
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('Choose...', ''),
					Array('showall', 'showall'),
					Array('noborder', 'noborder'),
					Array('exactfit', 'exactfit'),
					Array('noscale', 'noscale'),
					),
				'size' => 1,	
				'maxitems' => 1,
			)
		),
		'parameter_salign' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.parameter_salign',		
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('Choose...', ''),
					Array('tl', 'tl'),
					Array('tr', 'tr'),
					Array('bl', 'bl'),
					Array('br', 'br'),
					Array('l', 'l'),
					Array('t', 't'),
					Array('r', 'br'),
					Array('b', 'b'),
				),
				'size' => 1,	
				'maxitems' => 1,
			)
		),		
		'parameter_wmode' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.parameter_wmode',		
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('Choose...', ''),
					Array('window', 'window'),
					Array('opaque', 'opaque'),
					Array('transparent', 'transparent'),
				),
				'size' => 1,	
				'maxitems' => 1,
			)
		),			
		'parameter_bgcolor' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.parameter_bgcolor',		
			'config' => Array (
				'type' => 'input',	
				'size' => '6',	
				'wizards' => Array(
					'_PADDING' => 2,
					'color' => Array(
						'title' => 'Color:',
						'type' => 'colorbox',
						'dim' => '10x10',
						'tableStyle' => 'border:solid 1px black;',
						'script' => 'wizard_colorpicker.php',
						'JSopenParams' => 'height=300,width=360,status=0,menubar=0,scrollbars=1',
					),
				),
			)
		),
		'parameter_devicefont' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.parameter_devicefont',		
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('Choose...', ''),
					Array('true', 'true'),
					Array('false', 'false'),
				),
				'size' => 1,	
				'maxitems' => 1,
			)
		),	
		'parameter_seamlesstabbing' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.parameter_seamlesstabbing',		
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('Choose...', ''),
					Array('true', 'true'),
					Array('false', 'false'),
				),
				'size' => 1,	
				'maxitems' => 1,
			)
		),	
		'parameter_swliveconnect' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.parameter_swliveconnect',		
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('Choose...', ''),
					Array('true', 'true'),
					Array('false', 'false'),
				),
				'size' => 1,	
				'maxitems' => 1,
			)
		),		
		'parameter_allowfullscreen' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.parameter_allowfullscreen',		
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('Choose...', ''),
					Array('true', 'true'),
					Array('false', 'false'),
				),
				'size' => 1,	
				'maxitems' => 1,
			)
		),			
		'parameter_allowscriptaccess' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.parameter_allowscriptaccess',		
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('Choose...', ''),
					Array('always', 'always'),
					Array('sameDomain', 'sameDomain'),
					Array('never', 'never'),
				),
				'size' => 1,	
				'maxitems' => 1,
			)
		),			
		'parameter_allownetworking' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.parameter_allownetworking',		
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('Choose...', ''),
					Array('all', 'all'),
					Array('internal', 'internal'),
					Array('none', 'none'),
				),
				'size' => 1,	
				'maxitems' => 1,
			)
		),		
		'parameter_base' => Array (
			'l10n_mode' => 'mergeIfNotBlank',		
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.parameter_base',		
			'config' => Array (
				'type' => 'input',	
				'size' => '30',	
			)
		),		
		'flashVars' => Array (
			'l10n_mode' => 'mergeIfNotBlank',	
			'exclude' => 1,		
			'label' => 'LLL:EXT:swfobject/locallang_tca.xml:tx_swfobject_movie.flashVars',		
	        'config' => Array (
	            'type' => 'text',
	            'wrap' => 'OFF',
	            'cols' => '30',    
	            'rows' => '8',
	        )
		),
		'sys_language_uid' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => Array (
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => Array(
					Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => Array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', 0),
				),
				'foreign_table' => 'tx_swfobject_movie',
				'foreign_table_where' => 'AND tx_swfobject_movie.uid=###REC_FIELD_l18n_parent### AND tx_swfobject_movie.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => Array(
			'config'=>array(
				'type'=>'passthrough')
		),		
	),
	'types' => Array (
		'0' => Array('showitem' => 'hidden;;;;1-1-1, title;;;;1-1-1, file, width, height,requiredVersion,expressInstall,'.
					'--div--;LLL:EXT:swfobject/locallang_tca.xml:tt_content.pi_flexform.sheet_alternativeContent,alternativeContentReference;;;;1-1-1,alternativeContentText;;;richtext:rte_transform[flag=rte_enabled|mode=ts];2-2-2,'.
					'--div--;LLL:EXT:swfobject/locallang_tca.xml:tt_content.pi_flexform.sheet_advancedOptions,attribute_name, attribute_class, attribute_id, attribute_align;;;;1-1-1, parameter_play, parameter_loop, parameter_menu, parameter_quality, parameter_scale, parameter_salign, parameter_wmode, parameter_bgcolor, parameter_devicefont, parameter_seamlesstabbing, parameter_swliveconnect, parameter_allowfullscreen, parameter_allowscriptaccess, parameter_allownetworking, parameter_base,'.
					'--div--;LLL:EXT:swfobject/locallang_tca.xml:tt_content.pi_flexform.sheet_flashVars,flashVars'
		)
	),
	'palettes' => Array (
	)
);
?>