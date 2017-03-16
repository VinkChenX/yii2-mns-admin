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
创建config/private.php 并添加以下内容 
```
<?php
/**
 * 私有文件配置 不传到代码仓库里
 */
return [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'aaWtStooZHzIXeczatR2NIWo6qJFwy4Y',//需要修改 替换成一个随机字符串
        ],
        'mns'=>[
            'class'=>'yii\mns\Mns',
            'accessKeyId'=>'从阿里云获取的accessKeyId',//需要修改 替换成从阿里云获取的accessKeyId
            'AccessKeySecret'=>'从阿里云获取的accessKeySecret',//需要修改 替换成从阿里云获取的accessKeySecret
            'endpoint'=>'http://*****.mns.cn-hangzhou.aliyuncs.com/'//需要修改 替换成从阿里云获取的enpoint
        ],
    ]
];
```
##打开首页 会自动跳转到 site/register 注册初始管理员


