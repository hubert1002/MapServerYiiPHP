<?php

class GetUserTaskAction extends ZAction
{
    public function run()
    {
        $params = array_merge($_POST, $_GET);
        if(empty($params['start_time'])){
            $params['start_time']=time()-60*60*24*10;
        }
        if(empty($params['end_time'])){
            $params['end_time']=time();
        }
        $url = Yii::app()->params['remote_getusertask_url'];
        $task_status = Yii::app()->request->getParam('task_status',-10000);


        $post_data = http_build_query($params);
        $result = CommonFn::simple_http_post($url, $post_data);
        $res = json_decode($result,true);
        if(!empty($res)){
            if($res['success']){

                $final_data=array();
                $data = $res['data'];
                //拼接地理位置信息
                foreach($data as $value){
                    if($task_status!=-10000){
                        if($value['task_status']!=$task_status){
                            continue;
                        }
                    }
                    //get data
                    $list = preg_split ("/号/", $value['user_build_number']);
                    if(!empty($list)&&!empty($list[0])){
                        $location = self::getLocation($list[0]);
                        $final_data[] =array_merge($value,$location);
                    }else{
                        $final_data[] =$value;
                    }

                }
                //拼接用户id
                $order_ids =array();
                foreach($final_data as $value){
                    $order_ids[]=new MongoId($value['order_id']);
                }
                $tempColl =CommonFn::getMongoCollection('delivery','delivery_order');
                $queryData= $tempColl->find(array( '_id' => array('$in' => $order_ids)));
                $orderInfo =iterator_to_array($queryData);
                foreach($final_data as &$value){
                    foreach($orderInfo as $item){
                        if((string)$item['_id']==$value['order_id']){
                            $value['user_id']=(string)$item['user'];
                            break;
                        }
                    }
                }
                $final_data=self::sortArray($final_data);
                CommonFn::requestAjax(true, 'ok',$final_data);
            }else{
                CommonFn::requestAjax(false,$res['message']);
            }
        }else{
            CommonFn::requestAjax(false, '操作失败le ',$res);
        }
    }
    private static  function sortArray($array){
        for ($i=0; $i < count($array); $i++) {
            for ($j=$i; $j < count($array); $j++) {
                $iArr = $array[$i];
                $jArr = $array[$j];
                if ($iArr['task_create_time'] < $jArr['task_create_time']) {
                    $array[$i] = $jArr;
                    $array[$j] = $iArr;
                }
            }
        }
        return $array;
    }

    private static function getLocation($build_number){
        $criteria=new CDbCriteria;
        $criteria->limit=1;
        $criteria->select = 'amend_lat,amend_lon,lon,lat';
        $criteria->addCondition("build_number=$build_number");
        $list=GeoAdd::model()->findAll($criteria); // $params is not needed
        $data =array();
        if(!empty($list)){
            $data['amend_lat']= $list[0]->amend_lat;
            $data['amend_lon']= $list[0]->amend_lon;
            $data['lat']= $list[0]->lat;
            $data['lon']= $list[0]->lon;
        }else{
            $data['amend_lat']= 000;
            $data['amend_lon']= 000;
            $data['lat']= 000;
            $data['lon']=000;
        }
        return $data;
    }
}