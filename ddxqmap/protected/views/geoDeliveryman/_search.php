<?php
/* @var $this GeoDeliverymanController */
/* @var $model GeoDeliveryman */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id',array('size'=>60,'maxlength'=>128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lat'); ?>
		<?php echo $form->textField($model,'lat'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lon'); ?>
		<?php echo $form->textField($model,'lon'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'amend_lat'); ?>
		<?php echo $form->textField($model,'amend_lat'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'amend_lon'); ?>
		<?php echo $form->textField($model,'amend_lon'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'acc'); ?>
		<?php echo $form->textField($model,'acc'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'time'); ?>
		<?php echo $form->textField($model,'time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->