<?php

class CategoryController extends CMSController
{
    /**
     * Layout
     * @var string $layout
     */
    public $layout = 'default';

    /**
     * AccessControl filter
     * @return array
     */
    public function filters()
    {
        return [
            'accessControl',
        ];
    }

    /**
     * AccessRules
     * @return array
     */
    public function accessRules()
    {
        return [
            [
                'allow',
                'actions' => ['index', 'view'],
                'users'   => ['*']
            ],
            [
                'deny',  // deny all users
                'users' => ['*'],
            ],
        ];
    }

    /**
     * Displays all posts within a given category provided by $id
     * @param int $id
     * @param int $page
     * @throws CHttpException
     */
    public function actionIndex($id = 1, $page = 1)
    {
        $category = $this->loadModel($id);
        $this->setPageTitle('All Posts in ' . $category->name);

        // Model Search without $_GET params
        $model = new Content('search');
        $model->unsetAttributes();
        $model->attributes = [
            'published'   => 1,
            'category_id' => $id
        ];

        $_GET['page'] = $page;

        $this->render('//content/all', [
            'dataprovider' => $model->search()
        ]);
    }

    /**
     * Displays either all posts or all posts for a particular category_id if an $id is set in RSS Format
     * So that RSS Readers can access the website
     * @param int $id
     * @throws CException
     */
    public function actionRss($id = null)
    {
        Yii::app()->log->routes[0]->enabled = false;

        ob_end_clean();
        header('Content-type: text/xml; charset=utf-8');

        $this->layout = false;
        $criteria = new CDbCriteria;
        if ($id != null) {
            $criteria->addCondition("category_id = " . $id);
        }

        $criteria->order = 'created DESC';
        $data = Content::model()->findAll($criteria);

        $this->renderPartial('rss', [
            'data' => $data,
            'url'  => 'http://' . Yii::app()->request->serverName . Yii::app()->baseUrl
        ]);
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

        $model = Category::model()->findByPk($id);

        if ($model == null) {
            throw new CHttpException(404, 'No category with that ID exists');
        }

        return $model;
    }
}
