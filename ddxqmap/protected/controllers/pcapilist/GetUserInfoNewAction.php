<?php

class GetUserInfoNewAction extends ZAction
{
    public function run()
    {

        $station_id = Yii::app()->request->getParam('station_id', '');
        $task_type = Yii::app()->request->getParam('task_type', '');
        $task_status = Yii::app()->request->getParam('task_status', 0);
        $userColl =CommonFn::getMongoCollection('delivery','delivery_user');
        $query = array(
            'status' =>1//1为正常状态
        );
        if( $station_id )
        {
            $query['service_station'] = new MongoId( $station_id );
        }
        $users = $userColl->find($query);

        $data = array();
        foreach($users as $user){

            //查询id的task数目，由type 和 status决定
            $tempColl = CommonFn::getMongoCollection('delivery','delivery_order_task');
            $tempQuery = array(
                'status' =>$task_status,
                'operator' =>$user['_id']
            );
            $count = $tempColl->count($tempQuery);
            $data[] =array(
                'id' => (string)$user['_id'],
                'name' => $user['name'],
                'mobile' => $user['mobile'],
                'service_station_id' => (string)$user['service_station'],
                'count'=>$count
            );
        }
        CommonFn::requestAjax(true,'ok',$data);
    }


}