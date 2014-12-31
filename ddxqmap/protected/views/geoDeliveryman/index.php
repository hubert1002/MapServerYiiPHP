<?php
/* @var $this GeoDeliverymanController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Geo Deliverymen',
);

$this->menu=array(
	array('label'=>'Create GeoDeliveryman', 'url'=>array('create')),
	array('label'=>'Manage GeoDeliveryman', 'url'=>array('admin')),
);
?>

<h1>Geo Deliverymen</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
