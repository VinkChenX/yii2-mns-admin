<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\MnsQueue;

/* @var $this yii\web\View */
/* @var $model app\models\MnsQueue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mns-queue-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'component_id')->dropDownList(MnsQueue::getComponentIds()) ?>
    
    <?= $form->field($model, 'delay_seconds')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'maximum_message_size')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'message_retention_period')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visibility_timeout')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logging_enabled')->dropDownList([0=>'否',1=>'是']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
