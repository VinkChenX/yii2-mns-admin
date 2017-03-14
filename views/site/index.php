<?php

/* @var $this \yii\web\View */

$this->title =  'MNS管理';
use yii\helpers\Url;
?>

<div class="mns-index container">
    <div class="jumbotron">
        <h1>MNS 服务管理系统</h1>
        <p>详细说明 见 <a href="https://help.aliyun.com/document_detail/27414.html?spm=5176.doc27480.6.539.9arFBQ" target="_blank">https://help.aliyun.com/document_detail/27414.html?spm=5176.doc27480.6.539.9arFBQ</a></p>
    </div>
    
    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>消息队列</h2>

                <p>消息队列查看及管理</p>

                <p>
                    <a class="btn btn-default" href="<?=Url::to(['/mns-queue/index'])?>" target="_blank">列表 &raquo;</a>
                    <a class="btn btn-default" href="<?=Url::to(['/mns-queue/create'])?>" target="_blank">添加 &raquo;</a>
                </p>
            </div>
            <div class="col-lg-4">
                <h2>主题</h2>

                <p>主题查看及管理</p>

                <p>
                    <a class="btn btn-default" href="<?=Url::to(['/mns-topic/index'])?>" target="_blank">列表 &raquo;</a>
                    <a class="btn btn-default" href="<?=Url::to(['/mns-topic/create'])?>" target="_blank">添加 &raquo;</a>
                </p>
            </div>
            <div class="col-lg-4">
                <h2>主题订阅</h2>

                <p>主题订阅 查看及管理</p>

                <p>
                    <a class="btn btn-default" href="<?=Url::to(['/mns-topic-subscription/index'])?>" target="_blank">列表 &raquo;</a>
                    <a class="btn btn-default" href="<?=Url::to(['/mns-topic-subscription/create'])?>" target="_blank">添加 &raquo;</a>
                </p>
            </div>
        </div>

    </div>
</div>