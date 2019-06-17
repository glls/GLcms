<h2>Snippets</h2>
<?php echo CHtml::link('Add snippet', ['add']) ?>
<ol>
    <?php foreach ($models as $model): ?>
        <li>
            <?php echo CHtml::link(
                CHtml::encode($model->title),
                ['view', 'id' => $model->id]
            ) ?>
        </li>
    <?php endforeach ?>
</ol>
