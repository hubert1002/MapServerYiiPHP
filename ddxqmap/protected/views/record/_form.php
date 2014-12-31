<?php
/* @var $this RecordController */
/* @var $model Record */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'record-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'imgpath'); ?>
		<?php echo $form->textField($model,'imgpath',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'imgpath'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'amend_lat'); ?>
		<?php echo $form->textField($model,'amend_lat'); ?>
		<?php echo $form->error($model,'amend_lat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'amend_lon'); ?>
		<?php echo $form->textField($model,'amend_lon'); ?>
		<?php echo $form->error($model,'amend_lon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'imgname'); ?>
		<?php echo $form->textField($model,'imgname',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'imgname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->