<?php

require_once 'godb.php';

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	$config = array (
|                     'host',
|                     'username',
|                     'passwd',
|                     'dbname',
|                     'port',
|                     'socket',
|                     'charset',
|                     'debug',
|                     'prefix',
|                     'postmake',
|                     'link',
|                                 );
   --------------------------------- */
/* ---------------------------------
            LOCALHOST-BEGIN
                                     */
$config = array ('host' => 'localhost', 'username' => 'kabinet1usr', 'passwd' => 'inversion', 'dbname' => 'kabinet1db', 'charset' => 'utf8');
/*
            LOCALHOST-END
   --------------------------------- */


/* ---------------------------------
            PRODUCTION-BEGIN
                                     */
#$config = array ('host' => 'localhost', 'username' => 'imngru_cabus', 'passwd' => '7jzFnL38KJZF', 'dbname' => 'imngru_cabdb', 'charset' => 'utf8');
/*
            PRODUCTION-END
   --------------------------------- */

$db = new goDB($config);
