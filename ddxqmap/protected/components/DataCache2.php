<?php
/**
 * Created by PhpStorm.
 * User: liuwei1
 * Date: 2014/12/15
 * Time: 16:16
 */
class DataCache2{
    public static $is_uid_cache = true;
    public static $pre_cached_uid = 'pre_cached_uid';
    public static $uid_cache_time = 30;//小哥信息缓存

    public static $is_stationid_cache = true;
    public static $pre_cached_stationid = '$pre_cached_stationid';
    public static $stationid_cache_time = 30;//服务站信息缓存

    public static $pre_cached_unfinishedlist = '$pre_cached_stationid';
    public static $unfinishedlist_cache_time = 604800;//一周订单缓存

    public static function getDelivererInfo($ids){
        //去除其中重复的id
        if(empty($ids)){
            return null;
        }
        $finalIds =  array_unique($ids);
        if(DataCache2::$is_uid_cache){
            //找出没有缓存的项的id

            $value=Yii::app()->cache->get(DataCache2::$pre_cached_uid);//存储的json字串
            $data =array();
            if($value===false)
            {
              $data = self::getDataFromRemote($finalIds);
            }else{
                $list = json_decode($value,true);
                foreach ($finalIds as $id)
                {
                    $bool =false;
                    foreach ($list as $row){
                        if($id ==$row['uid']){
                            $data[] =$row;
                            $bool =true;
                            break;
                        }
                    }
                    //如果其中一项没有,则请求远端，并保存
                    if(!$bool){
                        $data = self::getDataFromRemote($finalIds);
                        break;
                    }
                }
            }
            return $data;
        }else{
            $data = self::getDataFromRemote($finalIds);
            return $data;
        }
    }
    private static function getDataFromRemote($finalIds){
        $list = self::getALLUidInfo($finalIds);
        if(self::$is_uid_cache){
            Yii::app()->cache->set(DataCache2::$pre_cached_uid,  json_encode($list), DataCache2::$uid_cache_time);
        }
        $data =array();
        foreach ($finalIds as $id)
        {
            foreach ($list as $row){
                if($id ==$row['uid']){
                    $data[] =$row;
                    break;
                }
            }
        }
        return $data;
    }



    private static  function getALLUidInfo($stationid){
//        $params = array_merge($_POST, $_GET);
//        $url = Yii::app()->params['remote_login_url'];
//        $post_data = http_build_query($params);
//        $result = CommonFn::simple_http_post($url, $post_data);
//        $res = json_decode($result,true);
//        return $res['data'];//返回数组
        echo 'getall';
        $data =array();
        $list =array( 100,101,102,103,104,105,106,107,108,109,110,111,112,22,333,232,1231,1233,2342,345,456,567,678,78,124603,26,256,27,524,245,2452,465345,3562,145,14515,164,145,3453,6456,315,1451,1451,1534,6356,37,765,1704,74,8,574,245,25,134,15,345,6276, );
        foreach ($list as $row)
        {
            $data[]=array(
                'uid' => $row,
                'name' =>'name'.$row,
                'mobile' =>'mobile'.$row
            );
        }

        $url= 'http://api.map.baidu.com/geoconv/v1/?coords=114.21892734521,29.575429778924;114.21892734521,29.575429778924&from=1&to=5&ak=5DRli4igDIO7lqdKlDpZ6SEK';
        $result = CommonFn::simple_http($url);
        $res = json_decode($result);


       return $data;
    }
}