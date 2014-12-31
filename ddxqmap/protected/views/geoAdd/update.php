<?php
/* @var $this GeoAddController */
/* @var $model GeoAdd */

$this->breadcrumbs=array(
	'Geo Adds'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GeoAdd', 'url'=>array('index')),
	array('label'=>'Create GeoAdd', 'url'=>array('create')),
	array('label'=>'View GeoAdd', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GeoAdd', 'url'=>array('admin')),
);
?>

<h1>Update GeoAdd <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>