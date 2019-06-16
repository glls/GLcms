<?php

class DefaultController extends ApiController
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
                'actions' => ['index', 'error']
            ],
            ['deny']
        ];
    }

    public function actionIndex()
    {
        return "test";
    }
}
