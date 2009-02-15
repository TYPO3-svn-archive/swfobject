#
# Table structure for table 'tx_swfobject_movie'
#
CREATE TABLE tx_swfobject_movie (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) unsigned DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	title tinytext NOT NULL,
	file blob NOT NULL,
	width tinytext NOT NULL,
	height tinytext NOT NULL,
	requiredVersion tinytext NOT NULL,
	expressInstall tinyint(3) unsigned DEFAULT '0' NOT NULL,
	
	alternativeContentReference blob NOT NULL,
	alternativeContentText mediumtext NOT NULL,
	
	attribute_name tinytext NOT NULL,
	attribute_class tinytext NOT NULL,
	attribute_id tinytext NOT NULL,
	attribute_align tinytext NOT NULL,
	
	parameter_play varchar(50) DEFAULT '' NOT NULL,
	parameter_loop varchar(50) DEFAULT '' NOT NULL,
	parameter_menu varchar(50) DEFAULT '' NOT NULL,
	parameter_quality varchar(50) DEFAULT '' NOT NULL,
	parameter_scale varchar(50) DEFAULT '' NOT NULL,
	parameter_salign varchar(50) DEFAULT '' NOT NULL,
	parameter_wmode varchar(50) DEFAULT '' NOT NULL,
	parameter_devicefont varchar(50) DEFAULT '' NOT NULL,
	parameter_seamlesstabbing varchar(50) DEFAULT '' NOT NULL,
	parameter_swliveconnect varchar(50) DEFAULT '' NOT NULL,
	parameter_allowfullscreen varchar(50) DEFAULT '' NOT NULL,
	parameter_allowscriptaccess varchar(50) DEFAULT '' NOT NULL,
	parameter_allownetworking varchar(50) DEFAULT '' NOT NULL,
	parameter_base tinytext NOT NULL,
	parameter_bgcolor tinytext NOT NULL,

	flashVars text NOT NULL,
  	
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
  	l18n_parent int(11) DEFAULT '0' NOT NULL,
  	l18n_diffsource mediumblob NOT NULL,	
	PRIMARY KEY (uid),
	KEY parent (pid)
);