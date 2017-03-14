<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\MnsTopic;

/* @var $this yii\web\View */
/* @var $model app\models\MnsTopic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mns-topic-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

     <?= $form->field($model, 'component_id')->dropDownList(MnsTopic::getComponentIds()) ?>
    
    <?= $form->field($model, 'maximum_message_size')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'logging_enabled')->dropDownList([0=>'否',1=>'是']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
