<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    /**
     * Get order param
     *
     * @return string
     */
    protected function getOrderParam()
    {
        $config = [
            'name' => 'name ASC',
            '-name' => 'name DESC',
            'updated_at' => 'updated_at ASC',
            '-updated_at' => 'updated_at DESC',
        ];
        return $config[Yii::$app->request->get('order', '-updated_at')];
    }
}

