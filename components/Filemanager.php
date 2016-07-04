<?php
/**
 * *
 *  * @package   yii2-filemanager
 *  * @author    Andrey Scherban <01@3js.name>
 *  * @copyright Copyright &copy; Andrey Scherban, 3js.name, 2014 - 2016
 *  * @version   1.0.1
 *  
 */

namespace evneandreys\filemanager\components;

use Yii;
use yii\helpers\Html;

/**
 * Class Filemanager
 * @package evneandreys\filemanager\components
 */
class Filemanager {

    /**
     *
     */
    const TYPE_FULL_PAGE = 1; // upload from filemanager module
    /**
     *
     */
    const TYPE_MODAL = 2; // upload from pop-up modal

    /**
     * @param $fileId
     * @param $objectUrl
     * @param $filename
     * @param $fileType
     * @return mixed
     */
    public static function renderEditUploadedBar($fileId, $objectUrl, $filename, $fileType) {
        $src = $objectUrl . $filename;
        $file = static::getThumbnail($fileType, $src, "20px", "30px");
        $content_1 = Html::tag('h6', $filename, ['class' => 'separator-box-title']);
        $content_2 = Html::tag('div', Html::a(Yii::t('filemanager', 'Edit'), ['/filemanager/files/update', 'id' => $fileId], ['target' => '_blank']), ['class' => 'separator-box-toolbar']);
        $content_3 = Html::tag('div', $file . $content_1 . $content_2, ['class' => 'separator-box-header']);
        $html = Html::tag('div', $content_3, ['class' => 'separator-box']);

        return $html;
    }

    /**
     * @param $fileType
     * @param $src
     * @param string $height
     * @param string $width
     * @return mixed
     */
    public static function getThumbnail($fileType, $src, $height = '', $width = '') {
        $thumbnailSize = \Yii::$app->getModule('filemanager')->thumbnailSize;
        
        if ($fileType == 'image') {
            $options = (!empty($height) && !empty($width)) ? ['height' => $height, 'width' => $width] : ['height' => "{$thumbnailSize[1]}px", 'width' => "{$thumbnailSize[0]}px"];
            return Html::img($src, $options);
        }

        $availableThumbnail = ['archive', 'audio', 'code', 'excel', 'movie', 'pdf', 'powerpoint', 'text', 'video', 'word', 'zip'];
        $type = explode('/', $fileType);
        $faClass = 'fa-file-o';
        $fontSize = !empty($height) ? $height : "{$thumbnailSize[1]}px";        

        if (in_array($type[0], $availableThumbnail)) {
            $faClass = "fa-file-{$type[0]}-o";
        } else if (in_array($type[1], $availableThumbnail)) {
            $faClass = "fa-file-{$type[1]}-o";
        }

        return Html::tag('div', Html::tag('i', '', ['class' => "fa {$faClass}", 'style' => "font-size: $fontSize"]), ['class' => 'fm-thumb', 'style' => "height: $height; width: $width"]);
    }

}
