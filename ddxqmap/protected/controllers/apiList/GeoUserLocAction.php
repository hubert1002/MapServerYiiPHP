<?php

class GeoUserLocAction extends ZAction
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


}
