<?php

class DeliveryersAction extends ZAction
{
  public function run()
    {
        $station = Yii::app()->request->getParam('stationid', '');

        if (!$station) {
            CommonFn::requestAjax(false, 'stationid is null', null);
        }

        $params = array_merge($_POST, $_GET);
        $url = Yii::app()->params['remote_station_url'];
        $post_data = http_build_query($params);

        $result = CommonFn::simple_http_post($url, null);

        $res = json_decode($result,true);
        if (!$res['success']) {
            CommonFn::requestAjax(false, 'failed', null);
        }
        $ids=array();

        foreach ($res['data'] as  $value) {

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
            $cons[] = Deliveryers::test2($row['user_id'],$row['mtime']);
        }
        $conditions= join(' OR ', $cons);
        $command = Yii::app()->getDb()->createCommand();
        $command->select('*')->from('tbl_geo_deliveryman');
        $command->where($conditions);
        $command->order('user_id ASC');
        $list = $command->queryAll();
        $results =this::sortArray($res['data']);
        $results =array_merge($results,$list);

        CommonFn::requestAjax(true, 'ok', $results);

        exit();
    }


    private static function getCondition($array){
       $cons =array();
        foreach ($array as  $value) {
             
             $cons[] =sprintf('user_id = "%s"', $user_id);
        }
       $conditions= join(' OR ', $cons);
    }
   

    private function sortArray($array){
        $temArr = array();
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
}
?>