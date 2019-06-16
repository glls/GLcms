<h1 class="page-header">Manage Users</h1>
<?php echo CHtml::link('Create New User', $this->createUrl('user/save'), ['class' => 'btn btn-primary']); ?>
<?php $this->widget('zii.widgets.grid.CGridView', [
    'dataProvider'  => $model->search(),
    'htmlOptions'   => [
        'class' => 'table-responsive'
    ],
    'itemsCssClass' => 'table table-striped',
    'columns'       => [
        'id',
        'name',
        [
            'class'           => 'CButtonColumn',
            'template'        => '{update}{delete}',
            'deleteButtonUrl' => 'Yii::app()->createUrl("/dashboard/user/delete", array("id" =>  $data["id"]))',
            'updateButtonUrl' => 'Yii::app()->createUrl("/dashboard/user/save", array("id" =>  $data["id"]))',
        ],
    ],
    'pager'         => [
        'htmlOptions'       => [
            'class' => 'pager'
        ],
        'header'            => '',
        'firstPageCssClass' => 'hide',
        'lastPageCssClass'  => 'hide',
        'maxButtonCount'    => 0
    ]
]);
Yii::app()->clientScript->registerCss('hide-banner', '.blog-header { display: none; }');
