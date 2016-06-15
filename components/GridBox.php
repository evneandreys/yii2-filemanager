<?php
/**
 * Copyright (c) 2016.
 * @Author: Scherban Andrey
 */

namespace evneandreys\filemanager\components;

use yii\base\Object;
use yii\helpers\Html;

/**
 * Class GridBox
 * @package evneandreys\filemanager\components
 */
class GridBox extends Object {

    /**
     * @var object 
     * Where the gridbox owned by, either FileBrowse or Gallery widgets
     */
    public $owner;

    /**
     * @var string 
     * File source, object_url . thumbnail_name
     */
    public $src;

    /**
     * @var string|null 
     * Either "image" or null
     * null refers a file type other than image
     */
    public $fileType;

    /**
     * @var array
     * Example: $toolArray = [
     *      [
     *          'tagType' => 'i', 
     *          'options' => [
     *              'class' => 'fa-icon fa fa-link fm-use',
     *              'data-url' => \yii\helpers\Url::to(['/filemanager/files/use']),
     *              'data-id' => $model->file_id,
     *              'title' => \Yii::t('filemanager', 'Use'),
     *          ]
     *      ],
     *      [
     *          'tagType' => 'label', 
     *          'content' => $input . $view
     *      ],
     *      [
     *          'tagType' => 'i', 
     *          'options' => [
     *              'class' => 'fa-icon fa fa-times fm-remove', 
     *              'title' => \Yii::t('filemanager', 'Remove')
     *          ]
     *      ],
     * ];
     */
    public $toolArray;
    /**
     * @var array
     */
    public $thumbnailSize = [120, 120];

    /**
     *
     */
    public function init() {
        parent::init();

        if (isset($this->owner->containerOptions)) {
            $id = $this->owner->containerOptions['id'];
        } else if (isset($this->owner->options)) {
            $id = $this->owner->options['id'];
        }

        if (isset($id)) {
            $view = $this->owner->getView();
            $view->registerJs("gridBox();");
        }
    }

    /**
     * @return mixed
     */
    public function renderGridBox() {
        $fileThumb = Filemanager::getThumbnail($this->fileType, $this->src, "{$this->thumbnailSize[0]}px", "{$this->thumbnailSize[1]}px");
        $toolbox = $this->renderToolbox();
        $hoverWrapper = Html::tag('div', '', ['class' => 'hover-wrapper']);

        return Html::tag('div', $fileThumb . $hoverWrapper . $toolbox, ['class' => 'fm-section-item']);
    }

    /**
     * @return mixed
     */
    protected function renderToolbox() {
        $tools = '';
        foreach ($this->toolArray as $tool) {
            $options = isset($tool['options']) ? $tool['options'] : [];
            $content = isset($tool['content']) ? $tool['content'] : '';
            $tools .= Html::tag($tool['tagType'], $content, $options) . '&nbsp;';
        }

        return Html::tag('div', $tools, ['class' => 'tool-box hidden-xs']);
    }

}
