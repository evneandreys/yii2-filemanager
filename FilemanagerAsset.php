<?php

namespace evneandreys\yii2_filemanager;

use yii\web\AssetBundle;

/**
 * Class FilemanagerAsset
 * @package evneandreys\yii2_filemanager
 */
class FilemanagerAsset extends AssetBundle {

    /**
     * @var string
     */
    public $sourcePath = '@evneandreys/filemanager/assets';
    /**
     * @var array
     */
    public $css = [
        'css/filemanager.css',
    ];
    /**
     * @var array
     */
    public $js = [
        'js/filemanager.js',
    ];
    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    /**
     * uncomment in localhost for debug purpose
     */
//    public $publishOptions = [
//        'forceCopy' => true
//    ];
}
