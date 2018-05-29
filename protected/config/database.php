<?php
include_once 'info.php';

// This is the database connection configuration.
return array(
//	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	'connectionString' => 'mysql:host=localhost;dbname=' . DATABASE_NAME,
	'emulatePrepare' => true,
	'username' => DATABASE_USERNAME,
	'password' => DATABASE_PASSWORD,
	'charset' => 'utf8',
);