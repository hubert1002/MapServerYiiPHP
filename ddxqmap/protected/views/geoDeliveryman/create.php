<?php
/* @var $this GeoDeliverymanController */
/* @var $model GeoDeliveryman */

$this->breadcrumbs=array(
	'Geo Deliverymen'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GeoDeliveryman', 'url'=>array('index')),
	array('label'=>'Manage GeoDeliveryman', 'url'=>array('admin')),
);
?>

<h1>Create GeoDeliveryman</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>