<?php

namespace app\controllers;

use app\models\User;
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
        $notes = Note::find()
            ->where(['user_id' => Yii::$app->user->identity->getId()])
            ->orderBy($this->getOrderParam())
            ->all();

        return $this->render('list', ['notes' => $notes]);
    }

    public function actionCreate($pad)
    {
        $note = new Note();
        $note->pad_id = $pad;

        if ($note->load(Yii::$app->request->post()) && $note->validate()) {
            /** @var User $user */
            $user = Yii::$app->user->identity;
            $user->link('notes', $note);
            Yii::$app->session->setFlash(
                'success', 'Note is successfully created.'
            );
            return $this->redirect('note/list');
        }
        return $this->render('create', [
            'note' => $note,
        ]);
    }

    public function actionEdit($id)
    {
        $note = $this->getNote($id);

        if ($note->load(Yii::$app->request->post()) && $note->validate()) {
            /** @var User $user */
            $user = Yii::$app->user->identity;
            $user->link('notes', $note);
            Yii::$app->session->setFlash(
                'success', 'Note is successfully updated.'
            );
            return $this->redirect(['note/edit', 'id' => $note->id]);
        }
        return $this->render('edit', [
            'note' => $note,
        ]);
    }

    public function actionView($id)
    {
        $note = $this->getNote($id);

        return $this->render('view', [
            'note' => $note,
        ]);
    }

    public function actionDelete($id)
    {
        $note = $this->getNote($id);

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
     * @param integer $id note id
     * @return Note
     * @throws \yii\web\HttpException
     */
    private function getNote($id)
    {
        $note = Note::findOne([
            'id' => $id,
            'user_id' => Yii::$app->user->identity->getId(),
        ]);
        if (!$note) {
            throw new \yii\web\HttpException(404, 'Not Found');
        }
        return $note;
    }
}

