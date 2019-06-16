<?php

class ApiModule extends CWebModule
{
    public function init()
    {
        // import the module-level models and components
        $this->setImport([
            'api.components.*',
        ]);

        Yii::app()->log->routes[0]->enabled = false;

        Yii::app()->setComponents([
            'errorHandler' => [
                'errorAction' => 'api/default/error',
            ]
        ]);
    }
}
