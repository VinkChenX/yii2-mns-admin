<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MnsTopicMessageForm */
/* @var $form ActiveForm */
$this->title = '发布主题消息';
$this->params['breadcrumbs'][] = ['label' => '主题', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mns-topic-create-message">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'topic_id')->dropDownList([0=>'请选择']+ \app\models\MnsTopic::getMap()) ?>
    
        <?= $form->field($model, 'message')->textarea() ?>
    
        <div class="form-group">
            <?= Html::submitButton('发布', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- mns-topic-create-message -->
