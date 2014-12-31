<?php

/**
 * summary: 代收快递API
 * date: 2014-08-04
 */
class ApiController extends UserAppController
{

    //http://api.map.baidu.com/geoconv/v1/?coords=114.21892734521,29.575429778924;114.21892734521,29.575429778924&from=1&to=5&ak=5DRli4igDIO7lqdKlDpZ6SEK
    //转换gps到百度地图坐标

    public function init()
    {
        parent::init();
    }


    public function actionPush(){
        $title = Yii::app()->request->getParam('title','订单标题');
        $contact_name = Yii::app()->request->getParam('contact_name','叮咚');
        $contact_mobile =Yii::app()->request->getParam('contact_mobile','110');
        $lat =Yii::app()->request->getParam('lat','31.19825');
        $lon =Yii::app()->request->getParam('lon','121.632823');
        $radius =Yii::app()->request->getParam('radius','10.0');
        $address =Yii::app()->request->getParam('address','玉兰');
        $order_id =Yii::app()->request->getParam('order_id','121212121212');
        $order_description =Yii::app()->request->getParam('order_description','order description');
        $alias_id = Yii::app()->request->getParam('alias_id','1000');
        $tags_id = Yii::app()->request->getParam('tags_id','10000000');
        $unit = Yii::app()->request->getParam('unit','9');
        $amend_lat =Yii::app()->request->getParam('amend_lat','31.203958');
        $amend_lon =Yii::app()->request->getParam('amend_lon','121.639387');

        $data = array(
            'title'=>$title,
            'contact_name'=>$contact_name,
            'contact_mobile'=>$contact_mobile,
            'lat'=>$lat,
            'lon'=>$lon,
            'amend_lat'=>$amend_lat,
            'amend_lon'=>$amend_lon,
            'radius'=>$radius,
            'address'=>$address,
            'order_id'=>$order_id,
            'unit'=>$unit,
            'order_description'=>$order_description,
        );
        $alias =array();
        $alias[]=$alias_id;
        $tags =array();
        $tags[]=$tags_id;
        JPushHandler::push($alias,$tags,$title,$data);
    }

    public function actionIndex()
    {
        /*
        JPushHandler::test();
            echo "index";
        $value=Yii::app()->cache->get($this->uid);
        if($value===false)
        {
            echo "empty";
            Yii::app()->cache->set($this->uid, "data", 30);
        }
        echo $value;
         */





        CommonFn::requestAjax(true, '欢迎您...');
    }

    public function  actionTestFeedback(){
        $list=Feedback::model()->findAll(); // $params is not needed
        foreach ($list as $row)
        {
            $data['data'][] = array(
                'userid' => $row->userid,
                'time' => $row->time,
                'content' => $row->content
            );
        }
        CommonFn::requestAjax(true, 'ok', $data);
    }


    public function actionTestCurl(){
        $url= 'http://api.map.baidu.com/geoconv/v1/?coords=114.21892734521,29.575429778924;114.21892734521,29.575429778924&from=1&to=5&ak=5DRli4igDIO7lqdKlDpZ6SEK';
        $result = CommonFn::simple_http($url);
        $res = json_decode($result);
        CommonFn::requestAjax(true, 'ok', $res);
    }

    public function actionTestCache(){
//        $ids =array(100);
        $ids =array( 100,101,102,103,104,105,106,107,108,109,110,111,112,22,333,232,1231,1233,2342,345,456,567,678,78,124603,26,256,27,524,245,2452,465345,3562,145,14515,164,145,3453,6456,315,1451,1451,1534,6356,37,765,1704,74,8,574,245,25,134,15,345,6276, );
        $data= DataCache::getDelivererInfo($ids);
        CommonFn::requestAjax(true, 'ok', $data);
    }

    public function actionTestCache2(){

//        $ids =array( 100,101,102,103,104,105,106,106 );
        $ids =array( 100,101,102,103,104,105,106,107,108,109,110,111,112,22,333,232,1231,1233,2342,345,456,567,678,78,124603,26,256,27,524,245,2452,465345,3562,145,14515,164,145,3453,6456,315,1451,1451,1534,6356,37,765,1704,74,8,574,245,25,134,15,345,6276, );
        $data= DataCache2::getDelivererInfo($ids);
        CommonFn::requestAjax(true, 'ok', $data);
    }


    public function actions()
    {
        return array(
            'get_current_version' => array(
                'class' => 'application.controllers.apiList.CheckNewVersionAction',
                'userinfo' => $this->user,
                "uidinfo"  => $this->uid
            ),
            'post_user_loc' => array(
                'class' => 'application.controllers.apiList.GeoUserLocAction',
                'userinfo' => $this->user,
                "uidinfo"  => $this->uid,
                "typeinfo" =>"post"
            ),
            'get_user_loc' => array(
                'class' => 'application.controllers.apiList.GeoUserLocAction',
                'userinfo' => $this->user,
                "uidinfo"  => $this->uid,
                "typeinfo" =>"get"
            ),
            'insert_village_geo' => array(
                'class' => 'application.controllers.apiList.VillageAdd',
                'userinfo' => $this->user,
                "uidinfo"  => $this->uid,
                "typeinfo" =>"insert"
                ),
            'query_village_geo' => array(
                'class' => 'application.controllers.apiList.VillageAdd',
                'userinfo' => $this->user,
                "uidinfo"  => $this->uid,
                "typeinfo" =>"query"
                ),
            'insert_feedback' => array(
                'class' => 'application.controllers.apiList.UserFeedBack',
                'userinfo' => $this->user,
                "uidinfo"  => $this->uid,
                "typeinfo" =>"insert"
                ),
            'query_feedback' => array(
                'class' => 'application.controllers.apiList.UserFeedBack',
                'userinfo' => $this->user,
                "uidinfo"  => $this->uid,
                "typeinfo" =>"query"
                ),
            'query_deliver' => array(
                'class' => 'application.controllers.apiList.DeliverBoyInfo',
                'userinfo' => $this->user,
                "uidinfo"  => $this->uid,
                "typeinfo" =>"query"
                ),
            'get_deliver_orderlist' => array(
                'class' => 'application.controllers.apiList.DeliverOrderListAction',
                'userinfo' => $this->user,
                "uidinfo"  => $this->uid,
                "typeinfo" =>"unfinished"
            ),
            'get_deliver_finishedorderlist' => array(
                'class' => 'application.controllers.apiList.DeliverOrderListAction',
                'userinfo' => $this->user,
                "uidinfo"  => $this->uid,
                "typeinfo" =>"finished"
            ),
            'add_record' => array(
                'class' => 'application.controllers.apiList.AddRecord',
                'userinfo' => $this->user,
                "uidinfo"  => $this->uid,
                "typeinfo" =>"insert"
                ),
            'read_record' => array(
                'class' => 'application.controllers.apiList.AddRecord',
                'userinfo' => $this->user,
                "uidinfo"  => $this->uid,
                "typeinfo" =>"read"
                ),
            'get_order' => array(
                'class' => 'application.controllers.apiList.DeliveryOrder',
                'userinfo' => $this->user,
                "uidinfo"  => $this->uid,
                ),
            'getDdxqUserinfo' => array(
                'class' => 'application.controllers.apiList.DdxqUserInfo',
                'userinfo' => $this->user,
                "uidinfo"  => $this->uid,
                ),
            'getTaskDetail' => array(
                'class' => 'application.controllers.apiList.GetTaskDetailInfoAction',
                'userinfo' => $this->user,
                "uidinfo"  => $this->uid,
                "typeinfo" =>"read"
            ),
            'insert_score' => array(
                'class' => 'application.controllers.apiList.UserScore',
                'userinfo' => $this->user,
                "uidinfo"  => $this->uid,
                "typeinfo" =>"insert"
                ),
            'query_score' => array(
                'class' => 'application.controllers.apiList.UserScore',
                'userinfo' => $this->user,
                "uidinfo"  => $this->uid,
                "typeinfo" =>"query"
                ),
            'insert_append' => array(
                'class' => 'application.controllers.apiList.UserAppendMess',
                'userinfo' => $this->user,
                "uidinfo"  => $this->uid,
                "typeinfo" =>"insert"
                ),
            'order_detail' => array(
                'class' => 'application.controllers.apiList.OrderDetail',
                'userinfo' => $this->user,
                "uidinfo"  => $this->uid,
                ),
        );
    }
}
