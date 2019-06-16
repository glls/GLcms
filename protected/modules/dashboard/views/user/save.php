<h1 class="page-header"><?php echo $model->isNewRecord ? 'Create New User' : 'Update User'; ?></h1>
<?php $form = $this->beginWidget('CActiveForm', [
    'id'          => 'content-form',
    'htmlOptions' => [
        'class' => 'form-horizontal',
        'role'  => 'form'
    ]
]); ?>
<?php echo $form->errorSummary($model); ?>
<div class="form-group">
    <?php echo $form->labelEx($model, 'username', ['class' => 'col-sm-2 control-label']); ?>
    <div class="col-sm-10">
        <?php echo $form->textField($model, 'username',
            ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('username')]); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'email', ['class' => 'col-sm-2 control-label']); ?>
    <div class="col-sm-10">
        <?php echo $form->textField($model, 'email',
            ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('email')]); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'password', ['class' => 'col-sm-2 control-label']); ?>
    <div class="col-sm-10">
        <?php echo $form->passwordField($model, 'password',
            ['class' => 'form-control', 'value' => '', 'placeholder' => $model->getAttributeLabel('password')]); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'name', ['class' => 'col-sm-2 control-label']); ?>
    <div class="col-sm-10">
        <?php echo $form->textField($model, 'name',
            ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('name')]); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'activated', ['class' => 'col-sm-2 control-label']); ?>
    <div class="col-sm-10">
        <?php echo $form->checkbox($model, 'activated',
            ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('activated')]); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'role_id', ['class' => 'col-sm-2 control-label']); ?>
    <div class="col-sm-10">
        <?php echo $form->dropDownList($model, 'role_id',
            CHtml::listData(Role::model()->findAll(), 'role_id', 'name')); ?>
    </div>
</div>


<div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',
        ['class' => 'btn btn-primary pull-right col-md-offset-1']); ?>
</div>
<?php $this->endWidget(); ?>
