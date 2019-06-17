<h3>Manage Categories</h3>
<?php echo CHtml::link('Create New Category', $this->createUrl('category/save'), ['class' => 'btn btn-primary']); ?>
<?php $this->widget('zii.widgets.grid.CGridView', [
    'dataProvider' => $model->search(),
    'columns'      => [
        'id',
        'name',
        [
            'class'           => 'CButtonColumn',
            'viewButtonUrl'   => 'Yii::app()->createUrl("/".$data["slug"])',
            'deleteButtonUrl' => 'Yii::app()->createUrl("/category/delete", array("id" =>  $data["id"]))',
            'updateButtonUrl' => 'Yii::app()->createUrl("/category/save", array("id" =>  $data["id"]))',
        ],
    ],
    'pager'        => [
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
