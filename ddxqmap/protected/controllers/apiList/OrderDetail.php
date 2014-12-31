<?php
class OrderDetail extends ZAction
{
	public $userinfo = '';
    public $uidinfo ;
	public function run(){
		$user = $this->userinfo;
        $uid = $this->uidinfo;
        $orderId = Yii::app()->request->getParam('orderid');
        if (empty($orderId)) {
        	CommonFn::requestAjax(false, 'orderid is null', "");
        }
        $mongo_config = Yii::app()->params['remote_mongodb_delivery'];
		$res = new MongoClient($mongo_config);
		$db = $res->selectDB('delivery');
		$coll = $db->selectCollection('delivery_order_item');
		$query = array('order'=>new MongoId($orderId));
		$tasks = $coll->find($query);
		$data = array();
		foreach ($tasks as $task) {
			$task['user'] = (string)$task['user'];
			$task['order'] = (string)$task['order'];
			$task['product'] = (string)$task['product'];
			$data['list'][]=$task;
		}
		CommonFn::requestAjax(true, 'ok', $data);
    }
}
?>