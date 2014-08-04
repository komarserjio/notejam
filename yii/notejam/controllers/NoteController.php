<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Note;
use app\controllers\BaseController;

class NoteController extends BaseController
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
                    'edit' => ['get', 'post'],
                    'delete' => ['get', 'post'],
                    'view' => ['get'],
                    'error' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionList()
    {
        $notes = Yii::$app->user->identity
            ->getNotes()->orderBy($this->getOrderParam())->all();
        return $this->render('list', ['notes' => $notes]);
    }

    public function actionCreate()
    {
        $note = new Note();
        # to make value in dropdown selected, strange yii2 behavior
        $note->pad_id = Yii::$app->request->get('pad');

        if ($note->load(Yii::$app->request->post()) && $note->validate()) {
            Yii::$app->user->identity->link('notes', $note);
            Yii::$app->session->setFlash(
                'success', 'Note is successfully created.'
            );
            return $this->redirect('note/list');
        }
        return $this->render('create', [
            'note' => $note,
        ]);
    }

    public function actionEdit()
    {
        $note = $this->getNote(Yii::$app->request->get('id'));

        if ($note->load(Yii::$app->request->post()) && $note->validate()) {
            Yii::$app->user->identity->link('notes', $note);
            Yii::$app->session->setFlash(
                'success', 'Note is successfully updated.'
            );
            return $this->redirect('note/list');
        }
        return $this->render('edit', [
            'note' => $note,
        ]);
    }

    public function actionView()
    {
        $note = $this->getNote(Yii::$app->request->get('id'));

        return $this->render('view', [
            'note' => $note,
        ]);
    }

    public function actionDelete()
    {
        $note = $this->getNote(Yii::$app->request->get('id'));

        if (Yii::$app->request->getIsPost()) {
            $note->delete();
            Yii::$app->session->setFlash(
                'success', 'Note is successfully deleted.'
            );
            return $this->redirect('note/list');
        }
        return $this->render('delete', [
            'note' => $note,
        ]);
    }

    /**
     * Get note or raise 404
     *
     * @return app\models\Note
     */
    private function getNote($id)
    {
        $user = Yii::$app->user->identity;
        $note = $user->getNotes()->where(['id' => $id])->one();
        if (!$note) {
            throw new \yii\web\HttpException(404, 'Not Found');
        }
        return $note;
    }
}

