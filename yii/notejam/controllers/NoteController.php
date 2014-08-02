<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Note;

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
                    'create' => ['get', 'post'],
                ],
            ],
        ];
    }

    public function actionList()
    {
        return $this->render('list');
    }

    public function actionCreate()
    {
        $note = new Note();

        if ($note->load(Yii::$app->request->post()) && $note->validate()) {
            Yii::$app->user->identity->link('notes', $note);
            Yii::$app->session->setFlash(
                'success', 'Note is successfully created.'
            );
            return $this->redirect('note/list');
        }
        return $this->render('create', [
            'model' => $note,
        ]);
    }
}

