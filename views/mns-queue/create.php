<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MnsQueue */

$this->title = 'Create Mns Queue';
$this->params['breadcrumbs'][] = ['label' => 'Mns Queues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mns-queue-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
