<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MnsTopic */

$this->title = 'Create Mns Topic';
$this->params['breadcrumbs'][] = ['label' => 'Mns Topics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mns-topic-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
