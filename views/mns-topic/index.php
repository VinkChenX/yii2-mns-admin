<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\MnsTopic;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '主题';
$this->params['breadcrumbs'][] = $this->title;
$this->params['wide'] = true;
?>
<div class="mns-topic-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('添加主题', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('发布主题消息', ['create-message'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'name',
            'description:ntext',
            'maximum_message_size',
            'logging_enabled',
            'active_subscription_count',
            [
                'label'=>'状态',
                'value'=>function($model) {return isset(MnsTopic::STATUS_LIST[$model->status]) ? MnsTopic::STATUS_LIST[$model->status] : '未知状态';}
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
