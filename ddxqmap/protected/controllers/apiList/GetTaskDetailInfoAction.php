<?php
class GetTaskDetailInfoAction extends ZAction
{
    public $userinfo = '';
    public $uidinfo ;
    public $typeinfo;
    public function run(){
        $user = $this->userinfo;
        $uid = $this->uidinfo;
        $type = $this->typeinfo;
        $task_id = Yii::app()->request->getParam('task_id', '');
        $mongo_config = Yii::app()->params['remote_mongodb_delivery'];
        $dbConnection = new MongoClient($mongo_config);
        $db = $dbConnection->selectDB('delivery');
        $taskColl = $db->selectCollection('delivery_order_task');
        $query = array('_id' => new MongoId($task_id));
        $tasks = $taskColl->find($query);
        $data=iterator_to_array($tasks);
       CommonFn::requestAjax(true,'ok',$data);

    }
}
?>

