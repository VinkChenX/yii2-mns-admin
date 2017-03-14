<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MnsTopicSubscription */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mns-topic-subscription-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'topic_id')->dropDownList([0=>'请选择']+\app\models\MnsTopic::getMap()) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'endpoint')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'notify_strategy')->dropDownList(['EXPONENTIAL_DECAY_RETRY'=>'指数衰减重试（默认）','BACKOFF_RETRY'=>'退避重试策略']) ?>

    <?= $form->field($model, 'filter_tag')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'notify_content_format')->dropDownList([
        'XML' => 'XML(默认)',
        'JSON' => 'JSON',
        'SIMPLIFIED' => 'SIMPLIFIED',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
