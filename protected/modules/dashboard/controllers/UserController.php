<?php

class UserController extends DashboardController
{

    public function accessRules()
    {
        return CMap::mergeArray(parent::accessRules(), [
            [
                'allow',
                'actions'    => ['index', 'save', 'delete'],
                'users'      => ['@'],
                'expression' => 'Yii::app()->user->role==2'
            ],
            [
                'deny',  // deny all users
                'users' => ['*'],
            ]
        ]);
    }

    /**
     * Admin for listing content
     * @return void [type] [description]
     */
    public function actionIndex()
    {
        $model = new User('search');
        $model->unsetAttributes();

        if (isset($_GET['User'])) {
            $model->attributes = $_GET;
        }

        $this->render('index', [
            'model' => $model
        ]);
    }

    /**
     * Created/Update an existing article
     * @param int $id
     * @throws CHttpException
     */
    public function actionSave($id = null)
    {
        if ($id == null) {
            $model = new User;
        } else {
            $model = $this->loadModel($id);
        }

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];

            if ($model->save()) {
                Yii::app()->user->setFlash('info', 'The user was saved');
                $this->redirect($this->createUrl('/dashboard/user'));
            }
        }

        $this->render('save', [
            'model' => $model
        ]);
    }

    /**
     * Delete action
     * @param int $id
     * @throws CDbException
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        $this->redirect($this->createUrl('/dashboard/user'));
    }

    /**
     * Load Model method
     * @param int $id
     * @return Category $model
     * @throws CHttpException
     */
    private function loadModel($id = null)
    {
        if ($id == null) {
            throw new CHttpException(404, 'No category with that ID exists');
        }

        $model = User::model()->findByPk($id);

        if ($model == null) {
            throw new CHttpException(404, 'No category with that ID exists');
        }

        return $model;
    }
}
