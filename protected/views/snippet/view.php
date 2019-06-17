<h2><?php echo CHtml::link('Snippets', ['index']) ?> → <?php
    echo CHtml::encode($model->title) ?>
</h2>
<?php echo CHtml::link('Edit', ['edit', 'id' => $model->id]) ?>
<div>
    <?php echo $model->html ?>
</div>
