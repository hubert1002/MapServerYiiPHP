<?php
/* @var $this GeoAddController */
/* @var $model GeoAdd */

$this->breadcrumbs=array(
	'Geo Adds'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List GeoAdd', 'url'=>array('index')),
	array('label'=>'Create GeoAdd', 'url'=>array('create')),
	array('label'=>'Update GeoAdd', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GeoAdd', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GeoAdd', 'url'=>array('admin')),
);
?>

<h1>View GeoAdd #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'type',
		'lat',
		'lon',
		'amend_lat',
		'amend_lon',
		'city',
		'station',
		'name',
		'address',
		'build_number',
		'description',
	),
)); ?>
