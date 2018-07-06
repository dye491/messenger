<?php

namespace frontend\controllers;

use common\models\User;
use frontend\filters\ClearNewMessageFlagFilter;
use frontend\filters\ContactAccessRule;
use Yii;
use common\models\Message;
use common\models\MessageSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends Controller
{
    public $defaultAction = 'inbox';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['inbox', 'sent'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'accessDialog' => [
                'class' => AccessControl::class,
                'only' => ['dialog'],
                'rules' => [
                    [
                        'roles' => ['@'],
                        'class' => ContactAccessRule::class,
                        'actions' => ['dialog'],
                        'denyCallback' => function ($rule, $action) {
                            $contact_id = Yii::$app->request->queryParams['contact_id'];
                            $contact = User::findOne(['id' => $contact_id]);
                            $username = $contact ? $contact->username : null;
                            throw new ForbiddenHttpException(
                                Yii::t('app_user',
                                    "Before write to {username} first add him or her to your contact list",
                                    ['username' => $username]
                                )
                            );
                        },
                    ],
                ],
            ],
            'clearNewMessageFlag' => [
                'class' => ClearNewMessageFlagFilter::class,
                'dataProvider' => [
                    'class' => ActiveDataProvider::class,
                    'pagination' => [
                        'pageSize' => 10,
                    ],
                ],
                'only' => ['dialog'],
            ],
        ];
    }

    /**
     * Lists all received Message models.
     * @return mixed
     */
    public function actionInbox()
    {
        $searchModel = new MessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['to' => Yii::$app->user->id]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'attr' => 'from',
        ]);
    }

    /**
     * Lists all sent Message models.
     * @return mixed
     */
    public function actionSent()
    {
        $searchModel = new MessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['from' => Yii::$app->user->id]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'attr' => 'to',
        ]);
    }

    /**
     * Displays a single Message model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Message();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Message model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Message model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app_message', 'The requested page does not exist.'));
    }

    public function actionDialog($contact_id)
    {
        $model = new Message(['from' => Yii::$app->user->id, 'to' => $contact_id]);

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $model = new Message(['from' => Yii::$app->user->id, 'to' => $contact_id]);
        }

        $this->dataProvider->query = Message::find()->where(['or',
            [
                'from' => Yii::$app->user->id,
                'to' => $contact_id,
            ],
            [
                'to' => Yii::$app->user->id,
                'from' => $contact_id,
            ],
        ])->orderBy(['id' => SORT_DESC]);

        return $this->render('dialog', [
            'model' => $model,
            'dataProvider' => $this->dataProvider,
            'contactName' => User::findOne(['id' => $contact_id])->username,
        ]);
    }
}
