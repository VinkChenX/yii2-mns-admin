<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\MnsTopicSubscription;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '主题订阅';
$this->params['breadcrumbs'][] = $this->title;
$this->params['wide'] = true;
?>
<div class="mns-topic-subscription-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('添加主题订阅', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'topic_id',
            'description:ntext',
            'endpoint',
            'notify_strategy',
            'notify_content_format',
            [
                'label'=>'状态',
                'value'=>function($model) {return isset(MnsTopicSubscription::STATUS_LIST[$model->status]) ? MnsTopicSubscription::STATUS_LIST[$model->status] : '未知状态';}
            ],
            [
                'label'=>'创建时间',
                'value'=>function($model) {return date('Y-m-d H:i:s', $model->created_at);}
            ],
            [
                'label'=>'更新时间',
                'value'=>function($model) {return date('Y-m-d H:i:s', $model->created_at);}
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}'
            ],
        ],
    ]); ?>
</div>
