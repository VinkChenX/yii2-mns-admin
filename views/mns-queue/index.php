<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\MnsQueue;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '消息队列';
$this->params['breadcrumbs'][] = $this->title;
$this->params['wide'] = true;
?>
<div class="mns-queue-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('添加队列', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('发布队列消息', ['create-message'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'component_id',
            'name',
            'description:ntext',
            'delay_seconds',
            'maximum_message_size',
            'message_retention_period',
            'visibility_timeout',
            'logging_enabled',
            [
                'label'=>'状态',
                'value'=>function($model) {return isset(MnsQueue::STATUS_LIST[$model->status]) ? MnsQueue::STATUS_LIST[$model->status] : '未知状态';}
            ],
            [
                'label'=>'创建时间',
                'value'=>function($model) {return date('Y-m-d H:i:s', $model->created_at);}
            ],
            [
                'label'=>'更新时间',
                'value'=>function($model) {return date('Y-m-d H:i:s', $model->created_at);}
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
