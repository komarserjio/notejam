<?php

return yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../config/console.php'),
    require(__DIR__ . '/../_config.php'),
    [
        'components' => [
            'db' => [
                'dsn' => 'sqlite:tests/functional/notejam_test.db',
            ],
        ],
    ]
);
