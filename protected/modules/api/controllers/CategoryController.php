<?php

class CategoryController extends ApiController
{
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return [
            [
                'allow',
                'actions' => ['index'],
            ],
            [
                'allow',
                'actions'    => ['indexDelete', 'indexPost'],
                'expression' => '$user!=NULL&&$user->role->id==2'
            ],
            ['deny']
        ];
    }

    /**
     * [GET] [/category/<id>]
     * @return array    List of Category
     */
    public function actionIndex($id = null)
    {
        if ($id !== null) {
            $category = $this->loadModel($id);
            if ($category == null) {
                throw new CHttpException(404, 'A category with the id was not found.');
            }

            return $category->getAPIAttributes();
        }

        $model = new Category('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Category'])) {
            $model->attributes = $_GET['Category'];
        }

        // Modify the pagination variable to use page instead of Category page
        $dataProvider = $model->search();
        $dataProvider->pagination = [
            'pageVar' => 'page'
        ];

        // Throw a 404 if we exceed the number of available results
        if ($dataProvider->totalItemCount == 0 || ($dataProvider->totalItemCount / ($dataProvider->itemCount * Yii::app()->request->getParam('page',
                        1))) < 1) {
            throw new CHttpException(404, 'No results found');
        }

        $response = [];

        foreach ($dataProvider->getData() as $category) {
            $response[] = $category->getAPIAttributes();
        }

        return $response;
    }

    /**
     * [POST] [/category/<id>]
     * @return array    Category
     */
    public function actionIndexPost($id = null)
    {
        if ($id === null) {
            $category = new Category;
        } else {
            $category = $this->loadModel($id);
            if ($category == null) {
                throw new CHttpException(404, 'A category with the id of was not found.');
            }
        }

        $category->attributes = $_POST;

        if ($category->save()) {
            return $category->getAPIAttributes();
        }

        return $this->returnError(400, null, $category->getErrors());
    }

    /**
     * [DELETE] [/category/<id>]
     * @return boolean
     */
    public function actionIndexDelete($id = null)
    {
        if ($id == null) {
            throw new CHttpException(400, 'A category id must be specified to delete.');
        }

        $category = $this->loadModel($id);
        if ($category == null) {
            throw new CHttpException(404, 'A category with the id of was not found.');
        }

        if ($category->id == 1) {
            throw new CHttpException(400, 'The root category cannot be deleted.');
        }

        // Update all content entries with this ID to the default category
        Yii::app()->db->createCommand('UPDATE content SET category_id = 1 WHERE category_id = :id')->bindParam(':id',
            $id)->execute();
        return $category->delete();
    }

    /**
     * Load Model method
     * @param int $id
     * @return Category $model
     */
    private function loadModel($id = null)
    {
        if ($id == null) {
            throw new CHttpException(404, 'No category with that ID exists');
        }

        $model = Category::model()->findByPk($id);

        if ($model == null) {
            throw new CHttpException(404, 'No category with that ID exists');
        }

        return $model;
    }
}
