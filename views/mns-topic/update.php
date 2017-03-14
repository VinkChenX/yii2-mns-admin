<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MnsTopic */

$this->title = 'Update Mns Topic: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Mns Topics', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mns-topic-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
