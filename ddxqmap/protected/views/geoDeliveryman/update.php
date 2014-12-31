<?php
/* @var $this GeoDeliverymanController */
/* @var $model GeoDeliveryman */

$this->breadcrumbs=array(
	'Geo Deliverymen'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GeoDeliveryman', 'url'=>array('index')),
	array('label'=>'Create GeoDeliveryman', 'url'=>array('create')),
	array('label'=>'View GeoDeliveryman', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GeoDeliveryman', 'url'=>array('admin')),
);
?>

<h1>Update GeoDeliveryman <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>