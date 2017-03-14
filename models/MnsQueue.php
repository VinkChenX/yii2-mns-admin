<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%mns_queue}}".
 *
 * @property integer $id
 * @property string $component_id 组件ID
 * @property integer $user_id 创建用户ID
 * @property string $name 队列名称
 * @property string $description 描述 
 * @property integer $delay_seconds 延迟秒数 默认为0
 * @property integer $maximum_message_size 消息最大size
 * @property integer $message_retention_period 消息最长保留时间
 * @property integer $visibility_timeout 消息被receive后的隐藏时长
 * @property integer $logging_enabled 是否开启日志
 * @property integer $status 状态
 * @property integer $created_at 创建时间
 * @property integer $updated_at 更新时间
 */
class MnsQueue extends \yii\db\ActiveRecord
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
        return '{{%mns_queue}}';
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
            [['visibility_timeout'],'default', 'value'=>600],
            [['message_retention_period'],'default', 'value'=>1296000],
            [['maximum_message_size'],'default', 'value'=>2048],
            [['delay_seconds', 'logging_enabled'],'default', 'value'=>0],
            [['description'],'default', 'value'=>''],
            
            
            [['name','component_id'], 'required'],
            [['name','component_id'], 'match', 'pattern' => '/^[a-z0-9][a-z0-9\-]*/i'],
            [['delay_seconds', 'maximum_message_size', 'message_retention_period', 'visibility_timeout', 'logging_enabled'], 'integer'],
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
            'user_id' => '创建用户ID',
            'name' => '名称',
            'description' => '描述',
            'component_id' => '组件ID',
            'delay_seconds' => '延迟时间（秒）',
            'maximum_message_size' => '消息体最大长度（1024 ~ 65536Byte）',
            'message_retention_period' => '消息最长保留时间（60 ~ 1296000秒）',
            'visibility_timeout' => '消息被receive后的隐藏时长（1 ~ 43200秒）',
            'logging_enabled' => '是否启用日志',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
    
    public function attributeHints() {
        return [
            'name'=>'唯一名称 64个字以内 以字母或数字开头，后面可包含-',
            'delay_seconds'=>'默认为0',
            'maximum_message_size'=>'默认为2048（2KB）',
            'message_retention_period'=>'默认为1296000秒',
            'visibility_timeout'=>'默认为600秒',
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
