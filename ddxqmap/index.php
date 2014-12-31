<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../framework/yii.php';
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);

$config=dirname(__FILE__).'/protected/config/main.php';
switch ( $_SERVER['SERVER_NAME'] )
{
    case 'map.ddxq.mobi' :          //发布环境
        $config=dirname(__FILE__).'/protected/config/release.php';
        break;
    default:                            // 开发环境
        $config=dirname(__FILE__).'/protected/config/develop.php';
}
Yii::createWebApplication($config)->run();
