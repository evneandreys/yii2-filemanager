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

use Yii;
use yii\helpers\BaseFileHelper;

/**
 * Class Module
 * @package evneandreys\filemanager
 */
class Module extends \yii\base\Module {

    /**
     * @var string
     */
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
    /**
     * @var string
     */
    public $cache = 'cache';

    /**
     * @var array 
     * Configure to use own models function
     */
    public $models = [
        'files' => 'evneandreys\filemanager\models\Files',
        'filesSearch' => 'evneandreys\filemanager\models\FilesSearch',
        'filesRelationship' => 'evneandreys\filemanager\models\FilesRelationship',
        'filesTag' => 'evneandreys\filemanager\models\FilesTag',
        'folders' => 'evneandreys\filemanager\models\Folders',
    ];
    /**
     * @var array
     */
    public $acceptedFilesType = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'application/pdf'
    ];
    /**
     * @var int
     */
    public $maxFileSize = 8; // MB
    /**
     * @var array
     */
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

    /**
     *
     */
    public function init() {
        Yii::$app->i18n->translations['filemanager*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => "@evneandreys/filemanager/messages"
        ];
        parent::init();
    }

    /**
     * @return array
     */
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
