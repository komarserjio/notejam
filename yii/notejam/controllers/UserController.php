<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class UserController extends Controller
{
    public $layout = 'user';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'settings'],
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
                    'logout' => ['get'],
                    'settings' => ['get', 'post'],
                    'signin' => ['get', 'post'],
                    'signup' => ['get', 'post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionSettings()
    {
        $pad = new \app\models\Pad();
        return $this->render('settings');
    }

    public function actionSignin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new \app\models\SigninForm();
        if ($model->load(Yii::$app->request->post()) && $model->signin()) {
            return $this->goBack();
        } else {
            return $this->render('signin', [
                'model' => $model,
            ]);
        }
    }

    public function actionSignup()
    {
        $model = new \app\models\SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                Yii::$app->session->setFlash(
                    'success', 'Account is created. Now you can sign in.'
                );
                return $this->goHome();
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionSignout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}

