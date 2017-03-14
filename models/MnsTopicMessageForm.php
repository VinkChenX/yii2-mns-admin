<?php

namespace app\models;

use Yii;

class MnsTopicMessageForm extends \yii\base\Model {
     
    /**
     * 队列ID
     * @var type 
     */
    public $topic_id;
    
    /**
     * 发布的消息
     * @var string 
     */
    public $message;
    
    public function rules() {
        return [
            [['topic_id','message'],'required'],
            [['topic_id'],'integer'],
            [['topic_id'],'exist','targetClass'=> '\app\models\MnsTopic','targetAttribute'=>'id'],
        ];
    }
    
    public function attributeLabels() {
        return [
            'topic_id'=>'队列ID',
            'message'=>'消息',
        ];
    }
    
    /**
     * 发送消息
     * @return bool
     */
    public function send() {
        $queue = MnsTopic::findOne((int)$this->topic_id);
        $mns = Yii::$app->get($queue->component_id);
        /* @var $mns \yii\mns\Mns */
        try {
            $mns->topicPublishMessage($queue->name, $this->message);
            return true;
        } catch (\Exception $ex) {
            $this->addError('message',"发送失败：{$ex->getFile()} 第{$ex->getLine()}行 {$ex->getMessage()}");
            return false;
        }
    }
}

