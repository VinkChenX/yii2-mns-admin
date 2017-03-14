<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MnsTopic */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Mns Topics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mns-topic-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'name',
            'description:ntext',
            'maximum_message_size',
            'logging_enabled',
            'active_subscription_count',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
