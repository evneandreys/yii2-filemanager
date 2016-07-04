<?php
/**
 * *
 *  * @package   yii2-filemanager
 *  * @author    Andrey Scherban <01@3js.name>
 *  * @copyright Copyright &copy; Andrey Scherban, 3js.name, 2014 - 2016
 *  * @version   1.0.1
 *  
 */

namespace evneandreys\filemanager\widgets;

use yii\helpers\Html;
use yii\widgets\BaseListView;
use evneandreys\filemanager\FilemanagerAsset;
use evneandreys\filemanager\components\GridBox;


/**
 * Class Gallery
 * @package evneandreys\filemanager\widgets
 */
class Gallery extends BaseListView {

    /**
     * @var array
     */
    public $options = ['id' => 'fm-section', 'class' => 'fm-section'];
    /**
     * @var string
     */
    public $layout = "{items}\n{pager}";
    /**
     * @var string
     */
    public $viewFrom = 'full-page';
    /**
     * @var array
     */
    public $gridBox = [];
    /**
     * @var string
     */
    protected $_galleryClientFunc = '';

    /**
     * Initializes the grid view.
     * This method will initialize required property values and instantiate [[columns]] objects.
     */
    public function init() {
        parent::init();

        $script = '';
        $view = $this->getView();

        if (empty($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        $opts = \yii\helpers\Json::encode([
                    'viewFrom' => $this->viewFrom
        ]);
        $script .= "$('#{$this->options['id']}').filemanagerGallery({$opts});";
        $this->_galleryClientFunc = 'fmGalleryInit_' . hash('crc32', $script);
        $view->registerJs("var {$this->_galleryClientFunc}=function(){\n{$script}\n};\n{$this->_galleryClientFunc}();");
    }

    /**
     * Runs the widget.
     */
    public function run() {
        $view = $this->getView();
        FilemanagerAsset::register($view);
        parent::run();
    }

    /**
     * @return string
     */
    public function renderItems() {
        if (empty($this->dataProvider)) {
            return 'No images in the library.';
        }

        $items = '';
        foreach ($this->dataProvider->getModels() as $model) {
            $src = '';
            $fileType = $model->mime_type;
            if ($model->dimension) {
                $src = $model->object_url . $model->thumbnail_name;
                $fileType = 'image';
            } else {
                $src = $model->object_url . $model->src_file_name;
            }

            $toolArray = $this->_getToolArray($model->file_id);
            $items .= $this->renderGridBox($src, $fileType, $toolArray, $model->alt_text);
        }

        return $items;
    }

    /**
     *
     */
    public function renderPager() {
        $pagination = $this->dataProvider->getPagination();
        $links = $pagination->getLinks();

        if (isset($links[\yii\data\Pagination::LINK_NEXT])) {
            $link = Html::a('', $links[\yii\data\Pagination::LINK_NEXT]);
            return Html::tag('div', $link, ['id' => 'fm-next-page']);
        }

        return;
    }

    /**
     * @param $src
     * @param $fileType
     * @param $toolArray
     * @param $alt_text
     * @return mixed
     */
    public function renderGridBox($src, $fileType, $toolArray, $alt_text) {
        $gridBox = new GridBox([
            'owner' => $this,
            'src' => $src,
            'fileType' => $fileType,
            'toolArray' => $toolArray,
            'alt_text' => $alt_text
        ]);

        return $gridBox->renderGridBox();
    }

    /**
     * @param $fileId
     * @return array
     */
    private function _getToolArray($fileId) {
        $input = Html::input('radio', 'fm-gallery-group', $fileId, ['data-url' => \yii\helpers\Url::to(['/filemanager/files/update', 'id' => $fileId])]);
        $view = Html::tag('i', '', ['class' => 'fa-icon fa fa-eye fm-view', 'title' => \Yii::t('filemanager', 'View')]);

        $toolArray = [
            [
                'tagType' => 'label',
                'content' => $input . $view
            ]
        ];

        if ($this->viewFrom == 'modal') {
            $toolArray[] = [
                'tagType' => 'i',
                'options' => [
                    'class' => 'fa-icon fa fa-link fm-use',
                    'title' => \Yii::t('filemanager', 'Use'),
                    'data-url' => \yii\helpers\Url::to(['/filemanager/files/use']),
                    'data-id' => $fileId
                ]
            ];
            $toolArray[] = [
                'tagType' => 'i',
                'options' => [
                    'class' => 'fa-icon fa fa-trash fm-delete',
                    'title' => \Yii::t('filemanager', 'Delete Permanently'),
                    'data-url' => \yii\helpers\Url::to(['/filemanager/files/delete', 'id' => $fileId]),
                    'onclick' => 'confirmDelete = confirm("Confirm delete this file?");'
                ]
            ];
        }
        
        return $toolArray;
    }

}
