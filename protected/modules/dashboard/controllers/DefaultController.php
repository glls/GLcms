<?php

class DefaultController extends DashboardController
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
     * @return [type] [description]
     */
    public function actionIndex()
    {
        $model = new Content('search');
        $model->unsetAttributes();

        if (isset($_GET['Content'])) {
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
            $model = new Content;
        } else {
            $model = $this->loadModel($id);
        }

        if (isset($_POST['Content'])) {
            $model->attributes = $_POST['Content'];
            $model->author_id = Yii::app()->user->id;

            if ($model->save()) {
                Yii::app()->user->setFlash('info', 'The articles was saved');
                $this->redirect($this->createUrl('/dashboard'));
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

        $this->redirect($this->createUrl('/dashboard'));
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

        $model = Content::model()->findByPk($id);

        if ($model == null) {
            throw new CHttpException(404, 'No category with that ID exists');
        }

        return $model;
    }
}
