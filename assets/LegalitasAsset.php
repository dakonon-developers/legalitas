<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LegalitasAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/style.css',
       'plugins/bootstrap-toogle/css/bootstrap-toggle.min.css',
       'plugins/bootstrap-fileinput/css/fileinput.min.css',
    ];
    public $js = [
        'js/ready.js',
        'js/functions.js',
        'plugins/bootstrap-toogle/js/bootstrap-toggle.min.js',
        'plugins/bootstrap-fileinput/js/fileinput.min.js',
        'plugins/bootstrap-fileinput/js/locales/es.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}