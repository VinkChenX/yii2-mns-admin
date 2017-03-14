<?php

namespace app\controllers;

use Yii;
use app\models\MnsTopicSubscription;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * MnsTopicSubscriptionController implements the CRUD actions for MnsTopicSubscription model.
 */
class MnsTopicSubscriptionController extends Controller
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
     * Lists all MnsTopicSubscription models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MnsTopicSubscription::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MnsTopicSubscription model.
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
     * Creates a new MnsTopicSubscription model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MnsTopicSubscription();
        $mns = Yii::$app->get('mns');
        /* @var $mns \yii\mns\Mns */
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $db = MnsTopicSubscription::getDb();
            $transaction = $db->beginTransaction();
            $model->status = MnsTopicSubscription::STATUS_CREATED_SUCCESS;
            $model->user_id = (int)Yii::$app->user->id;
            try {
                if($model->save(false)) {
                    $res = $mns->topicSubscribe($model->topic->name, $model->name, $model->endpoint);
                } else {
                    throw new \Exception('保存数据失败');
                }
                $model->topic->active_subscription_count++;
                $model->topic->updateAttributes(['active_subscription_count']);
                $transaction->commit();
            } catch (\Exception $ex) {
                $transaction->rollBack();
                $model->addError('name',"保存出错：{$ex->getFile()} 第{$ex->getLine()}行错误：{$ex->getMessage()}");
                $res = false;
            }
            
            if($res) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        
        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing MnsTopicSubscription model.
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
     * Deletes an existing MnsTopicSubscription model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id, $trueDelete=true)
    {
        $model = $this->findModel($id);
        $mns = Yii::$app->get('mns');
        /* @var $mns \yii\mns\Mns */
        if($model->status== MnsTopicSubscription::STATUS_CREATED_SUCCESS) {
            $model->status = MnsTopicSubscription::STATUS_REMOVED;
            $db = MnsTopicSubscription::getDb();
            $transaction = $db->beginTransaction();
            try {
                $model->updateAttributes(['status']);
                $mns->topicUnsubscribe($model->topic->name, $model->name);
                if($model->topic->active_subscription_count>0 ) {
                    $model->topic->active_subscription_count--;
                    $model->topic->updateAttributes(['active_subscription_count']);
                }
                $transaction->commit();
            } catch (\Exception $ex) {
                $transaction->rollBack();
                Yii::$app->getSession()->setFlash('msg',"删除出错： {$ex->getFile()} 第 {$ex->getLine()} 行错误 {$ex->getMessage()}");
            }
        }
        
        if($trueDelete) {
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the MnsTopicSubscription model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MnsTopicSubscription the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MnsTopicSubscription::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
