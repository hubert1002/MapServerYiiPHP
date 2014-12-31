<?php
/**
* 历史订单     
*取消或者完成的订单 53cd4eb321bc3e2e64c70341
*status:-1取消 0待分派 1派送中 2已完成
*/
class DeliveryOrder extends ZAction
{
	public $userinfo = '';
    public $uidinfo ;
	public function run(){
		$user = $this->userinfo;
        $uid = $this->uidinfo;
		$userId = Yii::app()->request->getParam('userid');
		$page = Yii::app()->request->getParam('page');
		$pagesize = Yii::app()->request->getParam('pagesize');
		$status = Yii::app()->request->getParam('status');
		if (empty($userId)) {
			CommonFn::requestAjax(false, 'userid is null', "");
		}
		$mongo_config = Yii::app()->params['remote_mongodb_delivery'];
		$res = new MongoClient($mongo_config);
		$db = $res->selectDB('delivery');
		$coll = $db->selectCollection('delivery_order');
		$hasmore = 0;
		$total = $coll->count();
		// $query = array('user'=>new MongoId($userId),'$or'=>array(array('status'=>-1),array('status'=>2)));
		$query = array('user'=>new MongoId($userId));
		 if(is_numeric($status)){
		 	$query['status'] = (int)$status;
		 }
		if (empty($page)) {
			$tasks = $coll->find($query);
		} else {
			if (empty($pagesize) || $pagesize < 5) {
				$pagesize = 10;
			}
			$skip = ($page - 1) * $pagesize;
			$skip = $skip<0 ? 0 : $skip;
			if (($skip + $pagesize) > $total) {
				$hasmore = 0;
			} else {
				$hasmore = 1;
			}
			$tasks = $coll->find($query)->skip($skip)->limit($pagesize);
		}
		if (empty($tasks)) {
			CommonFn::requestAjax(true, 'ok', '');
		}
		$data = array();
		$data['hasMore'] = $hasmore;
		$coll = $db->selectCollection('delivery_address');
		foreach($tasks as $task)
		{
			$task['_id'] = (string)$task['_id'];
			$task['service_station'] = (string)$task['service_station'];
			$task['user'] = (string)$task['user'];
			$task['deliverer']= (string)$task['deliverer'];

			$addressId = (string)$task['address'];
			if (!empty($addressId)) {
				$query = array('_id'=>new MongoId($addressId));
				$result = $coll->findOne($query);
			
				$task['mobile'] = $result['mobile'];
                $task['village'] = $result['village_name'];
                $task['village_period'] = $result['village_period'];
                $task['build_number'] = $result['build_number'];
                $task['room_number'] = $result['room_number'];
			}
		    $data['list'][] = $task;
		}

		CommonFn::requestAjax(true, 'ok', $data);
	}
}
?>