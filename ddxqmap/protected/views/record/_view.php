<?php
/* @var $this RecordController */
/* @var $data Record */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('imgpath')); ?>:</b>
	<?php echo CHtml::encode($data->imgpath); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</b>
	<?php echo CHtml::encode($data->content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amend_lat')); ?>:</b>
	<?php echo CHtml::encode($data->amend_lat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amend_lon')); ?>:</b>
	<?php echo CHtml::encode($data->amend_lon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('imgname')); ?>:</b>
	<?php echo CHtml::encode($data->imgname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />


</div>