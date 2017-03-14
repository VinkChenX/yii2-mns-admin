<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MnsQueue */

$this->title = '更新消息队列: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '消息队列', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mns-queue-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
