<?php

namespace app\models;

use Yii;

class MnsQueueMessageForm extends \yii\base\Model {
    
    /**
     * 队列ID
     * @var type 
     */
    public $queue_id;
    
    /**
     * 发布的消息
     * @var string 
     */
    public $message;
    
    /**
     * 延迟秒数
     * @var integer 
     */
    public $delay_seconds;
    
    public function rules() {
        return [
            [['delay_seconds'],'default','value'=>0],
            [['queue_id','message'],'required'],
            [['queue_id','delay_seconds'],'integer'],
            [['queue_id'],'exist','targetClass'=> '\app\models\MnsQueue','targetAttribute'=>'id'],
        ];
    }
    
    public function attributeLabels() {
        return [
            'queue_id'=>'队列ID',
            'message'=>'消息',
            'delay_seconds'=>'延迟秒数',
        ];
    }
    
    /**
     * 发送消息
     * @return bool
     */
    public function send() {
        $queue = MnsQueue::findOne((int)$this->queue_id);
        $mns = Yii::$app->get($queue->component_id);
        /* @var $mns \yii\mns\Mns */
        try {
            $mns->queueSendMessage($queue->name, $this->message, $this->delay_seconds);
            return true;
        } catch (\Exception $ex) {
            $this->addError('message',"发送失败：{$ex->getFile()} 第{$ex->getLine()}行 {$ex->getMessage()}");
            return false;
        }
    }
    
}

