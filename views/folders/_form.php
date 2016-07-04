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
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model evneandreys\filemanager\models\Folders */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="folders-form">

    <?php
    $form = ActiveForm::begin();

    echo $form->field($model, 'category')->textInput(['maxlength' => true]);

    echo $form->field($model, 'path')->textInput(['maxlength' => true]);
    ?>
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
