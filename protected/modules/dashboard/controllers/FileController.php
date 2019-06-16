<?php

class FileController extends DashboardController
{
    public function accessRules()
    {
        return CMap::mergeArray(parent::accessRules(), [
            [
                'allow',
                'actions'    => ['index', 'upload', 'delete'],
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
     */
    public function actionIndex()
    {
        $model = new ContentMetadata('search');
        $model->unsetAttributes();
        $model->key = 'upload';

        if (isset($_GET['ContentMetadata'])) {
            $model->attributes = $_GET;
        }

        $this->render('index', [
            'model' => $model
        ]);
    }

    /**
     * Saves a file
     * @param int $id
     */
    public function actionUpload($id = null)
    {
        if ($id == null) {
            throw new CHttpException(400, 'Missing ID');
        }

        if (isset($_FILES['file'])) {
            $file = new FileUpload($id);

            if ($file->_result['success']) {
                Yii::app()->user->setFlash('info', 'The file uploaded to ' . $file->_result['filepath']);
            } elseif ($file->_result['error']) {
                Yii::app()->user->setFlash('error', 'Error: ' . $file->_result['error']);
            }

        } else {
            Yii::app()->user->setFlash('error', 'No file detected');
        }

        $this->redirect($this->createUrl('/dashboard/default/save?id=' . $id));
    }

    /**
     * Deletes a file
     * @param int $id
     */
    public function actionDelete($id)
    {
        if ($this->loadModel($id)->delete()) {
            Yii::app()->user->setFlash('info', 'File has been deleted');
            $this->redirect($this->createUrl('/dashboard/file/index'));
        }

        throw new CHttpException(500, 'The server failed to delete the requested file from the database. Please retry');
    }

    /**
     * Load model method
     * @param int $id
     * @return ContentUpload
     */
    private function loadModel($id = null)
    {
        if ($id == null) {
            throw new CHttpException(400, 'Missing ID');
        }

        $model = ContentMetadata::model()->findByAttributes(['id' => $id]);
        if ($model == null) {
            throw new CHttpException(400, 'Object not found');
        }

        return $model;
    }
}
