<?php
/* @var $this GeoDeliverymanController */
/* @var $model GeoDeliveryman */

$this->breadcrumbs=array(
	'Geo Deliverymen'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List GeoDeliveryman', 'url'=>array('index')),
	array('label'=>'Create GeoDeliveryman', 'url'=>array('create')),
	array('label'=>'Update GeoDeliveryman', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GeoDeliveryman', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GeoDeliveryman', 'url'=>array('admin')),
);
?>

<h1>View GeoDeliveryman #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'lat',
		'lon',
		'amend_lat',
		'amend_lon',
		'acc',
		'time',
	),
)); ?>
