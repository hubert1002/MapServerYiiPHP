<?php
/* @var $this GeoAddController */
/* @var $model GeoAdd */

$this->breadcrumbs=array(
	'Geo Adds'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GeoAdd', 'url'=>array('index')),
	array('label'=>'Manage GeoAdd', 'url'=>array('admin')),
);
?>

<h1>Create GeoAdd</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>