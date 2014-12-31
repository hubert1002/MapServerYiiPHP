<?php
/* @var $this GeoAddController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Geo Adds',
);

$this->menu=array(
	array('label'=>'Create GeoAdd', 'url'=>array('create')),
	array('label'=>'Manage GeoAdd', 'url'=>array('admin')),
);
?>

<h1>Geo Adds</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
