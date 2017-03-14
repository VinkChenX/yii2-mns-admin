<?php

namespace app\controllers;

use Yii;
use app\models\MnsQueue;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\mns\Mns;

/**
 * 阿里云 MNS管理
 */
class MnsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * 首页
     */
    public function actionIndex()
    {
        $mns = new Mns();
        return $this->render('index');
    }
}
