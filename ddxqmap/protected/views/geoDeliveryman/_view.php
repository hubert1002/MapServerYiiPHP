<?php
/* @var $this GeoDeliverymanController */
/* @var $data GeoDeliveryman */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lat')); ?>:</b>
	<?php echo CHtml::encode($data->lat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lon')); ?>:</b>
	<?php echo CHtml::encode($data->lon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amend_lat')); ?>:</b>
	<?php echo CHtml::encode($data->amend_lat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amend_lon')); ?>:</b>
	<?php echo CHtml::encode($data->amend_lon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('acc')); ?>:</b>
	<?php echo CHtml::encode($data->acc); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
	<?php echo CHtml::encode($data->time); ?>
	<br />

	*/ ?>

</div>