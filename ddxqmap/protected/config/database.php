<?php

// This is the database connection configuration.
return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	/*
	'connectionString' => 'mysql:host=localhost;dbname=testdrive',
	'emulatePrepare' => true,
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8',
	*/
       'connectionString' => 'mysql:host=localhost;dbname=mapmgr',
        //'connectionString' => 'mysql:host=10.192.10.155;dbname=Test',
        'emulatePrepare' => true,
        'username' => 'root',
        'password' => 'password',
        'charset' => 'utf8',





);
