<?php
/**
 * *
 *  * @package   yii2-filemanager
 *  * @author    Andrey Scherban <01@3js.name>
 *  * @copyright Copyright &copy; Andrey Scherban, 3js.name, 2014 - 2016
 *  * @version   1.0.1
 *  
 */

/* @var $this yii\web\View */
/* @var $model evneandreys\filemanager\models\Folders */

$this->title = Yii::t('filemanager', 'Create Folder');
$this->params['breadcrumbs'][] = ['label' => Yii::t('filemanager', 'Media Folder'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
    <h1><?php echo $this->title; ?></h1>
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
