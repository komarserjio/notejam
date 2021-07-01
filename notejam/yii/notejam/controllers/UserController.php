<?php

namespace app\controllers;

use app\models\ChangePassword;
use app\models\ForgotPassword;
use app\models\SigninForm;
use app\models\SignupForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

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
        $model = new ChangePassword();
        if ($model->load(Yii::$app->request->post()) &&
            $model->changePassword(Yii::$app->user->identity)
        ) {
            Yii::$app->session->setFlash(
                'success', 'Password is successfully changed.'
            );
            return $this->goHome();
        } else {
            return $this->render('settings', [
                'model' => $model,
            ]);
        }
    }

    public function actionForgotPassword()
    {
        $model = new ForgotPassword();
        if ($model->load(Yii::$app->request->post()) &&
            $model->resetPassword()
        ) {
            Yii::$app->session->setFlash(
                'success', 'New password sent. Check your inbox.'
            );
            return $this->redirect('signin');
        } else {
            return $this->render('forgot-password', [
                'model' => $model,
            ]);
        }
    }


    public function actionSignin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SigninForm();
        if ($model->load(Yii::$app->request->post()) && $model->signin()) {
            return $this->goHome();
        } else {
            return $this->render('signin', [
                'model' => $model,
            ]);
        }
    }

    public function actionSignup()
    {
        $model = new SignupForm();
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

