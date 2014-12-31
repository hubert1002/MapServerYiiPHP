<?php

class LinkInfo extends ZAction
{
    public $userinfo = '';
    public $uidinfo ;
    public $typeinfo;
    public function run()
    {
        $user = $this->userinfo;
        $uid = $this->uidinfo;
        $type = $this->typeinfo;


        if($type=="post"){
            $lat = Yii::app()->request->getParam('lat');
            $lon = Yii::app()->request->getParam('lon');

            $amend_lat = Yii::app()->request->getParam('amend_lat');
            $amend_lon = Yii::app()->request->getParam('amend_lon');

            $acc = Yii::app()->request->getParam('acc');
            $time =time();
            $user_id =$uid;

            $model=new GeoDeliveryman;
            $model->user_id = $user_id;
            $model->lat = $lat;
            $model->lon = $lon;
            $model->amend_lat = $amend_lat;
            $model->amend_lon = $amend_lon;
            $model->acc = $acc;
            $model->time = $time;
            if($model->save()){
                CommonFn::requestAjax(true, 'ok', "");
            }else{
                CommonFn::requestAjax(false, 'error', "");
            }

        }else if($type=="get"){
            $command = Yii::app()->getDb()->createCommand();
            $command->select('id, user_id, max(time) as mtime')->from('tbl_geo_deliveryman');
            $command->order('user_id ASC');
            $command->group('user_id');
            $results = $command->queryAll();

            $cons = array();
            foreach ($results as $row)
            {
                $cons[] = GeoUserLocAction::test2($row['user_id'],$row['mtime']);
            }
            $conditions= join(' OR ', $cons);
            $command = Yii::app()->getDb()->createCommand();
            $command->select('*')->from('tbl_geo_deliveryman');
            $command->where($conditions);
            $command->order('user_id ASC');
            $list = $command->queryAll();
            $data='';
            foreach ($list as $row)
            {
                $data['list'][] = array(
                    'id' => (string)$row['id'],
                    'user_id' =>$row['user_id'],
                    'lat' => $row['lat'],
                    'lon' => $row['lon'],
                    'amend_lat' => $row['amend_lat'],
                    'amend_lon' => $row['amend_lon'],
                    'acc' => $row['acc'],
                    'time' => $row['time']
                );
            }
            CommonFn::requestAjax(true, 'ok', $data);
        }

    }

    public static  function test2($user_id,$time){
        $cons = array();
        if ($user_id)
        {
            $cons[] = sprintf('user_id = "%s"', $user_id);
        }
        if ($time)
        {
            $cons[] = sprintf('time = "%s"', $time);
        }
        return join(' AND ', $cons);
    }


    public function OriginGet(){
            $target_uid = Yii::app()->request->getParam('target_uid');
            $criteria=new CDbCriteria;
            if(!empty($target_uid)) {
                $criteria->condition='user_id=:user_id';
                $criteria->params = array(':user_id' => $target_uid);
            }
            $criteria->order='id DESC';
            $list=GeoDeliveryman::model()->findAll($criteria); // $params is not needed

            $data='';
            foreach ($list as $row)
            {
                $data['list'][] = array(
                    'id' => (string)$row->id,
                    'user_id' =>$row->user_id,
                    'lat' => $row->lat,
                    'lon' => $row->lon,
                    'amend_lat' => $row->amend_lat,
                    'amend_lon' => $row->amend_lon,
                    'acc' => $row->acc,
                    'time' => $row->time
                );
            }
            CommonFn::requestAjax(true, 'ok', $data);
    }

    public function testTotal(){
        $list=GeoDeliveryman::model()->findAll();
        $ids =array();
        foreach ($list as $row)
        {
            $ids[] =$row->user_id;
        }
        $infos =self::getUserInfo($ids);
        $data =array();
        foreach ($list as $row)
        {
            foreach ($infos as $info){
                 if($info['uid']==$row['uid']){
                     $data['list'][] = array(
                         'user_id' =>$row['uid'],
                         'lat' => $row['lat'],
                         'lon' => $row['lon'],
                         'amend_lat' => $row['amend_lat'],
                         'amend_lon' => $row['amend_lon'],
                         'acc' => $row['acc'],
                         'time' => $row['time'],
                         'name' => $info['name'],
                         'mobile' => $info['mobile'],
                     );
                     break;
                 }
            }
        }
        CommonFn::requestAjax(true, 'ok', $data);

    }


    public function  getUserInfo($ids){
        //去除其中重复的id
        $finalIds =  array_unique($ids);
        if(CommonFn::$is_uid_cache){
            //找出没有缓存的项的id
            $unCached = array();
            $cachedInfo =array();
            foreach ($finalIds as $row)
            {
                $value=Yii::app()->cache->get(CommonFn::$pre_cached_uid.$row->uid);//存储的json字串
                if($value===false)
                {
                    $unCached[] =$row->uid;
                }else{
                    $cachedInfo[] =json_decode($value,true);//得到存储的数据数组
                }
            }
            //根据uncached数组去远程查询数据
            $querydInfo =array();
            $infos = self::getUidInfo($unCached);
            foreach ($infos as $row)
            {
                //将查询的到的数据缓存起来
                $json =json_encode($row);
                Yii::app()->cache->set(CommonFn::$pre_cached_uid.$row->uid,  $json, CommonFn::$uid_cache_time);
                $infos[] =json_decode($json,true);
            }
            //合并数据
            $data =array_merge($querydInfo,$cachedInfo);//数据数组
            return $data;
        }else{
            $data = self::getUidInfo($finalIds);
            return $data;
        }
    }

  public function getUidInfo($list){
        $params = array_merge($_POST, $_GET);
        $url = Yii::app()->params['remote_login_url'];
        $post_data = http_build_query($params);
        $result = CommonFn::simple_http_post($url, $post_data);
        $res = json_decode($result,true);
        return $res['data'];//返回数组
  }




}
