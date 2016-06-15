<?php
/**
 * Copyright (c) 2016.
 * @Author: Scherban Andrey
 */

namespace common\modules\manager;

use Yii;
use yii\helpers\BaseFileHelper;

class Module extends \yii\base\Module {

    public $directory = '@webroot';

    /**
     * @var array 
     * 
     * 1. Upload files to local directory (files will be store in @common in order to let backend/frontend application to access):
     * $storage = ['local'];
     *      
     * 2. Upload files to AWS S3:
     * $storage = [
     *      's3' => [
     *          'host' => '',
     *          'key' => '',
     *          'secret' => '',
     *          'bucket' => ''      
     *      ]
     * ];
     */
    public $storage = ['local'];
    public $cache = 'cache';

    /**
     * @var array 
     * Configure to use own models function
     */
    public $models = [
        'files' => 'evneandreys\yii2_filemanager\models\Files',
        'filesSearch' => 'evneandreys\yii2_filemanager\models\FilesSearch',
        'filesRelationship' => 'evneandreys\yii2_filemanager\models\FilesRelationship',
        'filesTag' => 'evneandreys\yii2_filemanager\models\FilesTag',
        'folders' => 'evneandreys\yii2_filemanager\models\Folders',
    ];
    public $acceptedFilesType = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'application/pdf'
    ];
    public $maxFileSize = 8; // MB
    public $thumbnailSize = [120, 120]; // width, height
    /**
     * This configuration will be used in 'filemanager/files/upload'
     * To support dynamic multiple upload
     * Default multiple upload is true, max file to upload is 10
     * @var type 
     */
    public $filesUpload = [
        'multiple' => true,
        'maxFileCount' => 10
    ];

    public function init() {
        Yii::$app->i18n->translations['filemanager*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => "@evneandreys/filemanager/messages"
        ];
        parent::init();
    }

    public function getMimeType() {
        $extensions = $result = [];
        foreach ($this->acceptedFilesType as $mimeType) {
            $extensions[] = BaseFileHelper::getExtensionsByMimeType($mimeType);
        }

        foreach ($extensions as $ext) {
            $result = \yii\helpers\ArrayHelper::merge($result, $ext);
        }

        return $result;
    }

}
