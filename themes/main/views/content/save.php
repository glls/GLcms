</h3><?php echo $model->isNewRecord ? 'Create New Post' : 'Update Post'; ?></h3>
<?php $form = $this->beginWidget('CActiveForm', [
    'id'          => 'content-form',
    'htmlOptions' => [
        'class' => 'form-horizontal',
        'role'  => 'form'
    ]
]); ?>
<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'title', ['class' => 'col-sm-2 control-label']); ?>
    <div class="col-sm-10">
        <?php echo $form->textField($model, 'title',
            ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('title')]); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'slug', ['class' => 'col-sm-2 control-label']); ?>
    <div class="col-sm-10">
        <?php echo $form->textField($model, 'slug',
            ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('slug')]); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'category_id', ['class' => 'col-sm-2 control-label']); ?>
    <div class="col-sm-10">
        <?php echo $form->dropDownList($model, 'category_id',
            CHtml::listData(Category::model()->findAll(), 'id', 'name')); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'body', ['class' => 'col-sm-2 control-label']); ?>
    <div class="col-sm-10">
        <?php echo $form->textArea($model, 'body',
            ['class' => 'form-control', 'rows' => 25, 'placeholder' => $model->getAttributeLabel('body')]); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'published', ['class' => 'col-sm-2 control-label']); ?>
    <div class="col-sm-10">
        <?php echo $form->checkBox($model, 'published', ['class' => 'form-control']); ?>
    </div>
</div>

<div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',
        ['class' => 'btn btn-primary pull-right col-md-offset-1']); ?>
</div>
<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerCss('hide-banner', '.blog-header { display: none; }');
