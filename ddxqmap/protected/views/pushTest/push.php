<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Push';
$this->breadcrumbs=array(
	'Push',
);
?>

<h1>Push</h1>

<?php if(Yii::app()->user->hasFlash('push')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('push'); ?>
</div>

<?php else: ?>

<p>
push something !!!
</p>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'push-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_name'); ?>
		<?php echo $form->textField($model,'contact_name'); ?>
		<?php echo $form->error($model,'contact_name'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'contact_mobile'); ?>
        <?php echo $form->textField($model,'contact_mobile'); ?>
        <?php echo $form->error($model,'contact_mobile'); ?>
    </div>

<!--    <div class="row">
        <?php /*echo $form->labelEx($model,'lat'); */?>
        <?php /*echo $form->textField($model,'lat'); */?>
        <?php /*echo $form->error($model,'lat'); */?>
    </div>

    <div class="row">
        <?php /*echo $form->labelEx($model,'lon'); */?>
        <?php /*echo $form->textField($model,'lon'); */?>
        <?php /*echo $form->error($model,'lon'); */?>
    </div>-->

<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'contact_mobile'); ?>
<!--		--><?php //echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128)); ?>
<!--		--><?php //echo $form->error($model,'subject'); ?>
<!--	</div>-->
<!---->
<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'body'); ?>
<!--		--><?php //echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
<!--		--><?php //echo $form->error($model,'body'); ?>
<!--	</div>-->

<!--	<?php /*if(CCaptcha::checkRequirements()): */?>
	<div class="row">
		<?php /*echo $form->labelEx($model,'verifyCode'); */?>
		<div>
		<?php /*$this->widget('CCaptcha'); */?>
		<?php /*echo $form->textField($model,'verifyCode'); */?>
		</div>
		<div class="hint">Please enter the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
		<?php /*echo $form->error($model,'verifyCode'); */?>
	</div>
	--><?php /*endif; */?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Push'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>