<?php
/**
 * Created by PhpStorm.
 * User: liuwei1
 * Date: 2014/12/15
 * Time: 16:16
 */
class UsrDataCache{
    public static $is_uid_cache = true;
    public static $pre_cached_uid = 'pre_cached_uid';
    public static $uid_cache_time = 30;//小哥信息缓存

    public static $is_stationid_cache = true;
    public static $pre_cached_stationid = '$pre_cached_stationid';
    public static $stationid_cache_time = 60;//服务站信息缓存

    public static $pre_cached_unfinishedlist = '$pre_cached_stationid';
    public static $unfinishedlist_cache_time = 604800;//一周订单缓存


    public static function getStationDelivererList($stations){
        if(empty($stations)){
            return null;
        }
        if(UsrDataCache::$is_stationid_cache){
            //找出没有缓存的项的id
            $unCached = array();
            $cachedInfo =array();
            foreach ($stations as $row)
            {
                $value=Yii::app()->cache->get(UsrDataCache::$pre_cached_stationid.$row);//存储的json字串
                if($value===false)
                {
                    $unCached[] =$row;
                }else{
                    $cachedInfo[] =json_decode($value,true);//得到存储的数据数组
                }
            }
            //根据uncached数组去远程查询数据
            $querydInfo =array();
            $infos = self::getStationInfo($unCached);
            foreach ($infos as $row)
            {
                //将查询的到的数据缓存起来 缓存很耗时
                $json =json_encode($row);
                Yii::app()->cache->set(UsrDataCache::$pre_cached_stationid.$row['uid'],  $json, UsrDataCache::$stationid_cache_time);
                $querydInfo[] =$row;
            }
            //合并数据
            $data =array_merge($querydInfo,$cachedInfo);//数据数组
            return $data;
        }else{
            $data = self::getStationInfo($stations);
            return $data;
        }


    }


    /**
     * @param $list
     * @return mixed|string
     */
    private static  function getStationInfo($list){
//        $params = array_merge($_POST, $_GET);
//        $url = Yii::app()->params['remote_login_url'];
//        $post_data = http_build_query($params);
//        $result = CommonFn::simple_http_post($url, $post_data);
//        $res = json_decode($result,true);
//        return $res['data'];//返回数组
        $data =array();
        foreach ($list as $row)
        {
            $data['id'] =$list;
            $data['name'] ='station name';
            //10个小哥
            for ( $counter = 0; $counter < 10; $counter++) {
                $data['deliverer'][]=array(
                    'uid' => $row,
                    'name' =>'name'.$row,
                    'mobile' =>'mobile'.$row
                    );
            }
        }
        $res = json_encode($data);
        $res= json_decode($res,true);
        return $res;
    }
}