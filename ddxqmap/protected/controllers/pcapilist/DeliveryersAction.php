<?php

class DeliveryersAction extends ZAction
{
  public function run()
    {
        $station = Yii::app()->request->getParam('stationid', '');

        $params = array_merge($_POST, $_GET);
        $url = Yii::app()->params['remote_deliveryers_url'];
        $post_data = http_build_query($params);
        $result = CommonFn::simple_http_post($url, $post_data);

        $res = json_decode($result,true);
        if (!$res['success']) {
            CommonFn::requestAjax(false, 'failed', null);
        }
        $remote_data =$res['data'];


        $ids=array();
        foreach ($remote_data as  $value) {
           $ids[] =  $value['id'];
        }

        $command = Yii::app()->getDb()->createCommand();
        $command->where(self::getCondition($ids));
        $command->select('id, user_id, max(time) as mtime')->from('tbl_geo_deliveryman');
        $command->order('user_id ASC');
        $command->group('user_id');
        $results = $command->queryAll();

        $cons = array();
        foreach ($results as $row)
        {
            $cons[] = DeliveryersAction::combineCondition($row['user_id'],$row['mtime']);
        }
        $conditions= join(' OR ', $cons);
        $command = Yii::app()->getDb()->createCommand();
        $command->select('user_id,lat,lon,amend_lat,amend_lon,acc,time')->from('tbl_geo_deliveryman');
        $command->where($conditions);
        $command->order('user_id ASC');
        $list = $command->queryAll();



        $data=array();
      foreach ($remote_data as $row){
          $bool =false;
          foreach($list as $value){
              if($row['id']==$value['user_id']){
                  $data[]=array_merge($row,$value);
                  $bool =true;
                  break;
              }
          }
          if(!$bool){
              $data[] =$row;
          }
      }
        //add unfinished task count
        foreach($data as &$row){
            $tempColl = CommonFn::getMongoCollection('delivery','delivery_order_task');
            $tempQuery = array(
                'status' =>0,//0 为未完成
                'operator' =>new MongoId( $row['id'] )
            );
            $count = $tempColl->count($tempQuery);
            $row['task_count'] =$count;
        }



        CommonFn::requestAjax(true, 'ok', $data);
    }


    private static function getCondition($array){
       $cons =array();
        foreach ($array as  $value) {
             $cons[] =sprintf('user_id = "%s"', $value);
        }
       return join(' OR ', $cons);
    }
   

    private static  function sortArray($array){
        for ($i=0; $i < count($array); $i++) {
            for ($j=$i; $j < count($array); $j++) { 
                $iArr = $array[$i];
                $jArr = $array[$j];
                if ($iArr['id'] > $jArr['id']) {
                    $array[$i] = $jArr;
                    $array[$j] = $iArr;
                }
            }
        }
        return $array;
    }

    public static  function combineCondition($user_id,$time){
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
}
?>