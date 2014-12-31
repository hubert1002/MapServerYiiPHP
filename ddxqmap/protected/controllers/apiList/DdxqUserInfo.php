<?php
/**
* 下单用户信息
*/
class DdxqUserInfo extends ZAction
{
    public $userinfo = '';
    public $uidinfo ;
    public function run(){
        $user = $this->userinfo;
        $uid = $this->uidinfo;
        $userId = Yii::app()->request->getParam('userid');

        if (empty($userId)) {
            CommonFn::requestAjax(false, 'userid is null', "");
        }
        $mongo_config = Yii::app()->params['remote_mongodb_delivery'];
        $data = array();
        $res = new MongoClient($mongo_config);
        $db = $res->selectDB('area');
        $coll = $db->selectCollection('user');
        $query = array('_id'=>new MongoId($userId));
        $task = $coll->findOne($query);
        if (empty($task)) {
             $db = $res->selectDB('delivery');
             $coll = $db->selectCollection('delivery_weixin_user');
             $task = $coll->findOne($query);
             if (empty($task)) {
                 CommonFn::requestAjax(false, 'user is not  exit', "");
             }
        }
        $task['_id'] = (string)$task['_id'];
        $task['village'] = (string)$task['village'];

        $sql = "select * from tbl_user_append where userid = '$userId'";
        $append = UserAppend::model()->findBySql($sql);
        if (!empty($append)) {
            $append_arr =  $append->attributes;

            $task['tag'] =  $append_arr['tag'];
            $task['gate_lock'] = $append_arr['gatelock'];
            $task['description'] = $append_arr['description'];

        }else{
             $task['tag'] =  '';
             $task['gate_lock'] = '';
             $task['description'] = '';
        }
        $data['userinfo'] = $task;

        $client = new MongoClient($mongo_config);
        $delivery = $client->selectDB('delivery');
        $table = $delivery->selectCollection('delivery_order');
        $search = array('user'=>new MongoId($userId));
        $response = $table->find($search)->limit(4);
        if (!empty($response)) {
            foreach ($response as $value) {
                $value['_id'] = (string)$value['_id'];
                $value['service_station'] = (string)$value['service_station'];
                $value['user'] = (string)$value['user'];
                $value['address'] = (string)$value['address'];
                $value['deliverer'] = (string)$value['deliverer'];
                $data['delivery'][] = $value;
            }
        }else{
            $data['delivery'] = '';
        }
        

        $criteria=new CDbCriteria;
        $criteria->limit=4;
        $criteria->order='id ASC';
        $lists=Score::model()->findAll($criteria);
        if (!empty($lists)) {
            foreach ($lists as $list) {
                $value = array();
                $value['id'] = $list->id;
                $value['name'] = $list->name;
                $value['title'] = $list->title;
                $value['time'] = $list->time;
                $value['content'] = $list->content;
                $value['score'] = $list->score;
                $data['score'][]=$value;
            }
        }else {
            $data['score'] = '';
        }

        CommonFn::requestAjax(true, 'ok', $data);
    }
}