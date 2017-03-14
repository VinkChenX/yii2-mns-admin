<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MnsQueueMessageForm */
/* @var $form ActiveForm */

$this->title = '发布队列消息';
$this->params['breadcrumbs'][] = ['label' => '消息队列', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mns-topic-create-message">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'queue_id')->dropDownList([0=>'请选择']+\app\models\MnsQueue::getMap()) ?>
    
        <?= $form->field($model, 'message')->textarea() ?>
    
        <?= $form->field($model, 'delay_seconds') ?>
    
        <div class="form-group">
            <?= Html::submitButton('发布', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- mns-topic-create-message -->
