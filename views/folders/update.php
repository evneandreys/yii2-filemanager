<?php
/**
 * *
 *  * @package   yii2-filemanager
 *  * @author    Andrey Scherban <01@3js.name>
 *  * @copyright Copyright &copy; Andrey Scherban, 3js.name, 2014 - 2016
 *  * @version   1.0.1
 *  
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model evneandreys\filemanager\models\Folders */

$this->title = 'Update Folder: ' . ' ' . $model->category;
$this->params['breadcrumbs'][] = ['label' => Yii::t('filemanager', 'Media Folder'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->category, 'url' => ['view', 'id' => $model->folder_id]];
$this->params['breadcrumbs'][] = Yii::t('filemanager', 'Update');
?>
<div class="page-header clearfix">
    <h1><?php echo Html::encode($this->title); ?></h1>
</div>
<div class="row">
    <div class="col-lg-5">
        <?php
        echo $this->render('_form', [
            'model' => $model,
        ]);
        ?>
    </div>
</div>
