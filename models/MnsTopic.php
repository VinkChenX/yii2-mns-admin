<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tb_mns_topic}}".
 *
 * @property integer $id
 * @property integer $user_id 用户ID
 * @property string $name 名称
 * @property string $description 描述 
 * @property integer $maximum_message_size 消息最长保留时间
 * @property integer $logging_enabled 是否开启日志
 * @property integer $active_subscription_count 激活订阅数量
 * @property integer $created_at 创建时间
 * @property integer $updated_at 更新时间
 */
class MnsTopic extends \yii\db\ActiveRecord
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
        return '{{%mns_topic}}';
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
            [['maximum_message_size'],'default', 'value'=>65536],
            [[ 'logging_enabled'],'default', 'value'=>0],
            [['description'],'default', 'value'=>''],
            [['active_subscription_count'],'default', 'value'=>0],
            
            [['name'], 'required'],
            [['name','component_id'], 'match', 'pattern' => '/^[a-z0-9][a-z0-9\-]*/i'],
            [['maximum_message_size', 'logging_enabled', 'active_subscription_count'], 'integer'],
            [['description'], 'string'],
            [['component_id'],'in','range'=> self::getComponentIds()],
            [['name'], 'string', 'max' => 64, 'encoding'=>'utf-8'],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'name' => '名称',
            'description' => '描述',
            'maximum_message_size' => '消息体的最大长度（1024 ~ 65536Byte）',
            'logging_enabled' => '是否开启日志',
            'active_subscription_count' => '已激活订阅数量',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
    
    public function attributeHints() {
        return [
            'name'=>'唯一名称 64个字以内 以字母或数字开头，后面可包含-',
            'maximum_message_size'=>'默认为2048（2KB）',
            'logging_enabled'=>'是否记录消息日志到阿里云日志系统，默认为否',
            'component_id'=>'在配置中定义的MNS组件名称（例如 mns，系统将通过Yii::$app->mns->xxx在阿里云创建队列）'
        ];
    }
    
    /**
     * 获取组件ID数组
     * @return []
     */
    public static function getComponentIds() {
        return [
            'mns'=>'mns'
        ];
    }
    
    /**
     * 获取 [id=>name] 数组
     * @param integer $status 状态
     * @return []
     */
    public static function getMap($status=self::STATUS_CREATED_SUCCESS) {
        $arr = [];
        $rows = static::find()->where('`status`='.(int)$status)->all();
        foreach($rows as $row) {
            $arr[$row['id']] = $row['name'];
        }
        return $arr;
    }
}
