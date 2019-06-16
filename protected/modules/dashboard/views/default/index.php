<h1 class="page-header">Manage Posts</h1>

<?php echo CHtml::link('Create New Post', $this->createUrl('default/save'), ['class' => 'btn btn-primary']); ?>
<?php $this->widget('zii.widgets.grid.CGridView', [
    'dataProvider'  => $model->search(),
    'htmlOptions'   => [
        'class' => 'table-responsive'
    ],
    'itemsCssClass' => 'table table-striped',
    'columns'       => [
        'id',
        'title',
        'published' => [
            'name'  => 'Published',
            'value' => '$data->published==1?"Yes":"No"'
        ],
        'author.username',
        [
            'class'           => 'CButtonColumn',
            'viewButtonUrl'   => 'Yii::app()->createUrl("/".$data["slug"])',
            'deleteButtonUrl' => 'Yii::app()->createUrl("/dashboard/default/delete", array("id" =>  $data["id"]))',
            'updateButtonUrl' => 'Yii::app()->createUrl("/dashboard/default/save", array("id" =>  $data["id"]))',
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
