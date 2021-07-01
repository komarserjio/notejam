<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Pad;

class PadController extends BaseController
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
                    'edit' => ['get', 'post'],
                    'delete' => ['get', 'post'],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $pad = new Pad();

        if ($pad->load(Yii::$app->request->post()) && $pad->validate()) {
            /** @var User $user */
            $user = Yii::$app->user->identity;
            $user->link('pads', $pad);
            Yii::$app->session->setFlash(
                'success', 'Pad is successfully created.'
            );
            return $this->redirect('note/list');
        }
        return $this->render('create', [
            'pad' => $pad,
        ]);
    }

    public function actionEdit($id)
    {
        $pad = $this->getPad($id);

        if ($pad->load(Yii::$app->request->post()) && $pad->validate()) {
            $pad->save();
            Yii::$app->session->setFlash(
                'success', 'Pad is successfully updated.'
            );
            return $this->redirect('note/list');
        }
        return $this->render('edit', [
            'pad' => $pad,
        ]);
    }

    public function actionDelete($id)
    {
        $pad = $this->getPad($id);

        if (Yii::$app->request->getIsPost()) {
            $pad->delete();
            Yii::$app->session->setFlash(
                'success', 'Pad is successfully deleted.'
            );
            return $this->redirect('note/list');
        }
        return $this->render('delete', [
            'pad' => $pad,
        ]);
    }

    public function actionView($id)
    {
        $pad = $this->getPad($id);
        $notes = $pad->getNotes()->orderBy($this->getOrderParam())->all();
        return $this->render('view', ['pad' => $pad, 'notes' => $notes]);
    }

    /**
     * Get pad or raise 404
     *
     * @param integer $id pad id
     * @return Pad
     * @throws \yii\web\HttpException
     */
    private function getPad($id)
    {
        $pad = Pad::findOne([
            'id' => $id,
            'user_id' => Yii::$app->user->identity->getId(),
        ]);
        if (!$pad) {
            throw new \yii\web\HttpException(404, 'Not Found');
        }
        return $pad;
    }
}


