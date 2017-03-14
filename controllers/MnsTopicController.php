<?php

namespace app\controllers;

use Yii;
use app\models\MnsTopic;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use AliyunMNS\Model\TopicAttributes;
use AliyunMNS\Requests\CreateTopicRequest;

/**
 * MnsTopicController implements the CRUD actions for MnsTopic model.
 */
class MnsTopicController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','create','create-message','delete','update','view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MnsTopic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MnsTopic::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MnsTopic model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MnsTopic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MnsTopic();
        $mns = Yii::$app->get('mns');
        /* @var $mns \yii\mns\Mns */
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $db = Yii::$app->getDb();
            $transaction = $db->beginTransaction();
            try {
                $model->status = MnsTopic::STATUS_CREATED_SUCCESS;
                $model->user_id = (int)Yii::$app->user->id;
                if($model->save(false)) {
                    $topicAttributes = new TopicAttributes($model->maximum_message_size, null, null, null, null, $model->logging_enabled);
                    $topic = new CreateTopicRequest($model->name, $topicAttributes);
                    $res = $mns->topicCreate($topic, $topicAttributes);
                    $transaction->commit();
                } else {
                    throw new \Exception('保存数据失败');
                }
            } catch (\Exception $ex) {
                $res = false;
                $transaction->rollBack();
                $model->addError('name', "异常：{$ex->getFile()} 第{$ex->getLine()}行错误： {$ex->getMessage()}");
            }
            if($res) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MnsTopic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MnsTopic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionCreateMessage()
    {
        $model = new \app\models\MnsTopicMessageForm();

        if ($model->load(Yii::$app->request->post())) {
             if ($model->validate() && $model->send()) {
                Yii::$app->getSession()->setFlash('msg',"发送消息成功");
                return $this->redirect(['index']);
            }
        }

        return $this->render('create-message', [
            'model' => $model,
        ]);
    }
    
    /**
     * Finds the MnsTopic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MnsTopic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MnsTopic::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
