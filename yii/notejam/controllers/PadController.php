<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class PadController extends Controller
{
    public $layout = 'app';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                    'create' => ['get', 'post'],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $pad = new \app\models\Pad();

        if ($pad->load(Yii::$app->request->post()) && $pad->validate()) {
            Yii::$app->user->identity->link('pads', $pad);
            Yii::$app->session->setFlash(
                'success', 'Pad is successfully created.'
            );
            return $this->redirect('note/list');
        }
        return $this->render('create', [
            'model' => $pad,
        ]);
    }
}


