<?php

class DashboardController extends CMSController
{
    /**
     * @return string[] action filters
     */
    public function filters()
    {
        return [
            'accessControl'
        ];
    }

    /**
     * Retrieve assetManager from anywhere without having to instatiate this code
     * @return CAssetManager
     */
    public function getAsset()
    {
        return Yii::app()->assetManager->publish(YiiBase::getPathOfAlias('application.modules.dashboard.assets'), true,
            -1, YII_DEBUG);
    }

    /**
     * Handles errors
     */
    public function actionError()
    {
        if (Yii::app()->user->isGuest) {
            return $this->redirect($this->createUrl('/site/login?next=' . Yii::app()->request->requestUri));
        }

        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', ['error' => $error]);
            }
        }
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return [
            [
                'allow',  // allow authenticated admins to perform any action
                'users' => ['@'],
            ],
            [
                'deny',  // deny all users
                'users'          => ['*'],
                'deniedCallback' => [$this, 'actionError']
            ],
        ];
    }

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = 'default';
}
