<?php
/**
 * *
 *  * @package   yii2-filemanager
 *  * @author    Andrey Scherban <01@3js.name>
 *  * @copyright Copyright &copy; Andrey Scherban, 3js.name, 2014 - 2016
 *  * @version   1.0.1
 *  
 */

namespace evneandreys\filemanager;

use yii\web\AssetBundle;

/**
 * Class FilemanagerAsset
 * @package evneandreys\filemanager
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
