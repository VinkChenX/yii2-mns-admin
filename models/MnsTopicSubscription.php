<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%mns_topic_subscription}}".
 *
 * @property string $id
 * @property string $name
 * @property string $topic_id
 * @property string $description
 * @property string $endpoint
 * @property string $notify_strategy
 * @property string $notify_content_format
 * @property string $created_at
 * @property string $updated_at
 * 
 * @property \app\models\MnsTopic $topic 主题
 */
class MnsTopicSubscription extends \yii\db\ActiveRecord
{
    const STATUS_REMOVED = -1;//已删除
    const STATUS_DEFAULT = 0;//等待阿里云创建队列
    const STATUS_CREATED_SUCCESS = 1;//创建成功
    
    const STATUS_LIST = [
        self::STATUS_REMOVED=>'已删除',
        self::STATUS_DEFAULT=>'等待阿里云创建队列',
        self::STATUS_CREATED_SUCCESS=>'创建成功',
    ];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mns_topic_subscription}}';
    }
    
    public function behaviors() {
        return [
            \yii\behaviors\TimestampBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'],'default', 'value'=>''],
            [['name', 'topic_id', 'endpoint', 'notify_strategy', 'notify_content_format'], 'required'],
            [['topic_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 64, 'encoding'=>'utf-8'],
            [['name'], 'match', 'pattern' => '/^[a-z0-9][a-z0-9\-]*/i'],
            [['notify_strategy'], 'in', 'range' => ['EXPONENTIAL_DECAY_RETRY','BACKOFF_RETRY']],
            [['endpoint', 'notify_strategy', 'notify_content_format'], 'string', 'max' => 255, 'encoding'=>'utf-8'],
            [['filter_tag'], 'string', 'max' => 16, 'encoding'=>'utf-8'],
            [['topic_id', 'name'], 'unique', 'targetAttribute' => ['topic_id', 'name'], 'message' => 'The combination of 名称 and 主题ID has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'topic_id' => '主题ID',
            'description' => '描述',
            'endpoint' => '终端',
            'notify_strategy' => '消息推送出现错误时的重试策略',
            'notify_content_format' => '消息格式',
            'filter_tag'=>'过滤标签',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
    
    public function attributeHints() {
        return [
            'name'=>'唯一名称 64个字以内 以字母或数字开头，后面可包含-',
            'notify_strategy'=>'EXPONENTIAL_DECAY_RETRY: 指数衰减重试 , 重试 176 次，每次重试的间隔时间指数递增至 512秒，总计重试时间为1天；每次重试的具体间隔为：1, 2, 4, 8, 16, 32, 64, 128, 256, 512, 512 ... 512 秒 (共167个512)'
            . '<br/>BACKOFF_RETRY:退避重试策略 , 重试 3 次，每次重试的间隔时间是 10秒 到 20秒 之间的随机值',
            'filter_tag'=>'描述了该订阅中消息过滤的标签（仅标签一致的消息才会被推送）',
            'endpoint'=>'详细说明见 <a href="https://help.aliyun.com/document_detail/27480.html?spm=5176.doc27481.6.672.eCF0Xi" target="_blank">https://help.aliyun.com/document_detail/27480.html?spm=5176.doc27481.6.672.eCF0Xi</a>'
        ];
    }
    
    public function getTopic() {
        return $this->hasOne(MnsTopic::className(), ['id'=>'topic_id']);
    }
}
