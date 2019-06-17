<?php $this->widget('zii.widgets.CListView', [
    'dataProvider' => $dataprovider,
    'itemView'     => '//content/list',
    'summaryText'  => '',
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
