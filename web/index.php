<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';


define('PAGESIZE', 20);

define('DELETE_0',       1); //已删除
define('NOT_DELETE_0',   0); //未删除


(new yii\web\Application($config))->run();
