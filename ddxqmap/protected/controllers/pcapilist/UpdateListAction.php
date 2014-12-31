<?php

class UpdateListAction extends ZAction
{
    public function run()
    {
        $stationid = Yii::app()->request->getParam('station_id', '');
        $unfinishedlist = Yii::app()->request->getParam('unfinished_list','');
        $data = base64_decode($unfinishedlist);
        //用缓存保存
        if(!empty($stationid)&&!empty($unfinishedlist)){
            Yii::app()->cache->set(CommonFn::$pre_cached_unfinishedlist.$stationid,  $data, CommonFn::$unfinishedlist_cache_time);
            CommonFn::requestAjax(true);
        }else{
            CommonFn::requestAjax(false);
        }
    }

}