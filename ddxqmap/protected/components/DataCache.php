<?php
/**
 * Created by PhpStorm.
 * User: liuwei1
 * Date: 2014/12/15
 * Time: 16:16
 */
class DataCache{
    public static $is_uid_cache = true;
    public static $pre_cached_uid = 'pre_cached_uid';
    public static $uid_cache_time =30;//小哥信息缓存

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
        if(DataCache::$is_uid_cache){
            //找出没有缓存的项的id
            $unCached = array();
            $cachedInfo =array();
            foreach ($finalIds as $row)
            {
                $value=Yii::app()->cache->get(DataCache::$pre_cached_uid.$row);//存储的json字串
                if($value===false)
                {
                    $unCached[] =$row;
                }else{
                    $cachedInfo[] =json_decode($value,true);//得到存储的数据数组，单个小哥的完整信息
                }
            }
            //根据uncached数组去远程查询数据
            $querydInfo =array();
            $infos = self::getUidInfo($unCached);
            foreach ($infos as $row)
            {
                //将查询的到的数据缓存起来 缓存很耗时
                $json =json_encode($row);
                Yii::app()->cache->set(DataCache::$pre_cached_uid.$row['uid'],  $json, DataCache::$uid_cache_time);
                $querydInfo[] =$row;
            }
            //合并数据
            $data =array_merge($querydInfo,$cachedInfo);//数据数组
            return $data;
        }else{
            $data = self::getUidInfo($finalIds);
            return $data;
        }
    }


    private static  function getUidInfo($list){
//        $params = array_merge($_POST, $_GET);
//        $url = Yii::app()->params['remote_login_url'];
//        $post_data = http_build_query($params);
//        $result = CommonFn::simple_http_post($url, $post_data);
//        $res = json_decode($result,true);
//        return $res['data'];//返回数组
        $data =array();
        foreach ($list as $row)
        {
            $data[]=array(
                'uid' => $row,
                'name' =>'name'.$row,
                'mobile' =>'mobile'.$row
            );
        }
        $res = json_encode($data);
        $res= json_decode($res,true);
       return $res;
    }
}