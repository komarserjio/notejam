<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class NoteController extends Controller
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
                    'list' => ['get'],
                ],
            ],
        ];
    }

    public function actionList()
    {
        $pad = new \app\models\Pad();
        //$pad->user_id = 1;
        ////$pad->save();
        //var_dump($pad->validate());
        //var_dump($pad->errors);
        return $this->render('list');
    }
}

