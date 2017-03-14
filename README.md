Yii2 Mns 服务管理平台

##主要实现功能
消息队列添加 ， 发布消息
主题添加 发布消息
添加主题订阅

##安装 
```
composer require vinkchen/yii2-mns-admin
```
运行config下init.sql

##配置
修改config/web下面以下配置：
```
'components' => [
    'request' => [
        // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
        'cookieValidationKey' => 'MjWtStooZHzIXeczatR2NIWo6qJFwy4Y',//需要修改 替换一个随机字符串
    ],
    'mns'=>[
        'class'=>'yii\mns\Mns',
        'accessKeyId'=>'从阿里云获取的accessKeyId',//需要修改
        'AccessKeySecret'=>'从阿里云获取的accessKeySecret',//需要修改
        'endpoint'=>'http://*****.mns.cn-hangzhou.aliyuncs.com/'//需要修改
    ],
]
```
##打开首页 会自动跳转到 site/register 注册初始管理员


