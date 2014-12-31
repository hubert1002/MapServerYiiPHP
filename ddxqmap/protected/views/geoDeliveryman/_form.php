<?php
/* @var $this GeoDeliverymanController */
/* @var $model GeoDeliveryman */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'geo-deliveryman-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lat'); ?>
		<?php echo $form->textField($model,'lat'); ?>
		<?php echo $form->error($model,'lat'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lon'); ?>
		<?php echo $form->textField($model,'lon'); ?>
		<?php echo $form->error($model,'lon'); ?>
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
		<?php echo $form->labelEx($model,'acc'); ?>
		<?php echo $form->textField($model,'acc'); ?>
		<?php echo $form->error($model,'acc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time'); ?>
		<?php echo $form->textField($model,'time'); ?>
		<?php echo $form->error($model,'time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->