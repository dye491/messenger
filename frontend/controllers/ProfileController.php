<?php

namespace frontend\controllers;

use common\models\Contact;
use frontend\models\ChangePasswordForm;
use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProfileController implements the CRUD actions for User model.
 */
class ProfileController extends Controller
{
    /**
     * {@inheritdoc}
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
            'access' => [
                'class' => AccessControl::class,
                'only' => ['add', 'update', 'change-password'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException
     */
    public function actionUpdate($id)
    {
        if ($id != Yii::$app->user->id) {
            throw new ForbiddenHttpException(Yii::t('app_user', 'You can edit only your own profile'));
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app_user', 'The requested page does not exist.'));
    }

    /**
     * Adds a user with the given id to contact list of a current user
     * If addition is successful, the browser will be redirected to the 'index'
     * @param $id
     * @return \yii\web\Response
     */
    public function actionAdd($id)
    {
        if (!Yii::$app->user->isGuest) {
            $model = $this->findModel($id);
            ($contact = new Contact([
                'user_id' => Yii::$app->user->id,
                'contact_id' => $model->id,
            ]))->save();
        }

        return $this->redirect(['index']);
    }

    /**
     * Changes user's password
     * @param $id
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Exception if the model cannot be saved
     */
    public function actionChangePassword($id)
    {
        if ($id != Yii::$app->user->id) {
            throw new ForbiddenHttpException(Yii::t('app_user', 'You can edit only your own profile'));
        }

        $arModel = $this->findModel($id);
        $model = new ChangePasswordForm(['oldPasswordHash' => $arModel->password_hash]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $arModel->setPassword($model->password);
            if ($arModel->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app_user','New password saved.'));
                return $this->redirect(['view', 'id' => $arModel->id]);
            } else {
                throw new \Exception();
            }
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }
}
