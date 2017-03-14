<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MnsTopicSubscription */

$this->title = '添加主题订阅';
$this->params['breadcrumbs'][] = ['label' => '主题订阅列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mns-topic-subscription-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
