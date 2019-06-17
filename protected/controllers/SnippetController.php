<?php

class SnippetController extends CController
{
    public function actionIndex()
    {
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $models = Snippet::model()->findAll($criteria);
        $this->render('index', [
            'models' => $models,
        ]);
    }

    public function actionView($id)
    {
        $model = Snippet::model()->findByPk($id);
        if (!$model) {
            throw new CException(404);
        }

        $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionAdd()
    {
        $model = new Snippet();
        $data = Yii::app()->request->getPost('Snippet');
        if ($data) {
            $model->setAttributes($data);
            if ($model->save()) {
                $this->redirect(['view', 'id' => $model->id]);
            }
        }
        $this->render('add', [
            'model' => $model,
        ]);
    }

    public function actionEdit($id)
    {
        $model = Snippet::model()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404);
        }

        $data = Yii::app()->request->getPost('Snippet');
        if ($data) {
            $model->setAttributes($data);
            if ($model->save()) {
                $this->redirect(['view', 'id' => $model->id]);
            }
        }
        $this->render('edit', [
            'model' => $model,
        ]);
    }
}
