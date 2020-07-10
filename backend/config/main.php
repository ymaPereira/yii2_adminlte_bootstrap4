<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1']
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'rest' => [
            'class' => 'backend\components\rest_api\RestAPI'
        ],
        'message' => [
            'class' => 'backend\components\Message'
        ],
        'number' => [
            'class' => 'backend\components\NumberHelper'
        ],
        'datetime' => [
            'class' => 'backend\components\DateTimeHelper'
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['site/login'], 
            'identityCookie' => ['name' => '_identity-app', 'httpOnly' => true],
            'authTimeout' => 1000,
            'on afterLogin'=>function($event){
                $role = \Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->id);
                foreach ($role as $key => $value) {
                   $role = $key;
                   break;
                }
                $session = new \yii\web\Session;
                $session->open();
                $session->set('role',$role);
                $session->close();
            }
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'gwt_app',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        'assetManager' => [
            'bundles' => [
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
                ],
            ],
        ],
    ]
    'params' => $params,
];
