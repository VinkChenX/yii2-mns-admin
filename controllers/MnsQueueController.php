<?php

namespace app\controllers;

use Yii;
use app\models\MnsQueue;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use AliyunMNS\Model\QueueAttributes;
use AliyunMNS\Requests\CreateQueueRequest;

/**
 * MnsQueueController implements the CRUD actions for MnsQueue model.
 */
class MnsQueueController extends Controller
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
     * Lists all MnsQueue models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MnsQueue::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MnsQueue model.
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
     * Creates a new MnsQueue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MnsQueue();
        $mns = Yii::$app->get('mns');
        /* @var $mns \yii\mns\Mns */
        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {
            $db = Yii::$app->getDb();
            $transaction = $db->beginTransaction();
            try {
                $model->status = MnsQueue::STATUS_CREATED_SUCCESS;
                $model->user_id = (int)Yii::$app->user->id;
                if($model->save(false)) {
                    $queueAttributes = new QueueAttributes($model->delay_seconds, $model->maximum_message_size, $model->message_retention_period, $model->visibility_timeout, null, null, null, null, null, null, null, $model->logging_enabled);
                    $queue = new CreateQueueRequest($model->name, $queueAttributes);
                    $res = $mns->queueCreate($queue, $queueAttributes);
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
     * Updates an existing MnsQueue model.
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
     * Deletes an existing MnsQueue model.
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
        $model = new \app\models\MnsQueueMessageForm();

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
     * Finds the MnsQueue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MnsQueue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MnsQueue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
