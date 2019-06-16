<h1 class="page-header">Manage Categories</h1>
<?php echo CHtml::link('Create New Category', $this->createUrl('category/save'), ['class' => 'btn btn-primary']); ?>
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
            'viewButtonUrl'   => 'Yii::app()->createUrl("/".$data["slug"])',
            'deleteButtonUrl' => 'Yii::app()->createUrl("/dashboard/category/delete", array("id" =>  $data["id"]))',
            'updateButtonUrl' => 'Yii::app()->createUrl("/dashboard/category/save", array("id" =>  $data["id"]))',
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
