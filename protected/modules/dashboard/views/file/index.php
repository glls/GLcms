<?php $this->widget('zii.widgets.CListView', [
    'dataProvider' => $model->search(),
    'itemView'     => '_file',
]);
