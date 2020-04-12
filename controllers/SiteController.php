<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use app\models\User;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' => ['login'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'login' => ['GET', 'POST'],
                ],
            ],
        ];
    }


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // $identity = Yii::$app->user->identity;var_dump($identity);exit();
        return $this->render('index');
    }

    /**
     * 用户登陆
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (Yii::$app->request->getIsPost()) {
            $username = trim(Yii::$app->request->post('username', ''));
            $password = trim(Yii::$app->request->post('password', ''));
            $rememberMe = intval(Yii::$app->request->post('rememberMe', 0));
            if ($username === '' || $password === '') {
                Yii::$app->session->setFlash('error', '请输入用户名或密码');
                return $this->refresh();
            }

            $_user = User::findByUsername($username);
            if ($_user === null) {
                Yii::$app->session->setFlash('error', '不存在这个用户');
                return $this->refresh();
            }

            if ($_user->password === md5($password)) {
                Yii::$app->user->login($_user, $rememberMe !== 0 ? 3600*12 : 0);
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', '密码错误');
                return $this->refresh();
            }
        }

        return $this->renderAjax('login');
    }

    /**
     * 用户登出
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
