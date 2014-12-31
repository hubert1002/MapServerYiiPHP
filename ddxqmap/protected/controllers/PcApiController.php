<?php

/**
 * summary: 代收快递API
 * date: 2014-08-04
 */
class PcApiController extends AppController
{
    public function init()
    {
        parent::init();
    }

    public function actionIndex()
    {
        CommonFn::requestAjax(true, '欢迎您...');
    }



    public function actions()
    {
        return array(
            'get_station_userinfo' => array(
                'class' => 'application.controllers.pcapilist.DeliveryersAction',
            ),
            'get_stationinfo' => array(
                'class' => 'application.controllers.pcapilist.StationAction',
            ),
            'get_unsigned_orders' => array(
                'class' => 'application.controllers.pcapilist.UnsignedOrdersAction',
                "typeinfo" =>"get"
            ),
            'update_orderlist' => array(
                'class' => 'application.controllers.pcapilist.UpdateListAction',
            ),
            'getUserInfo' => array(
                'class' => 'application.controllers.pcapilist.GetUserInfoAction',
            ),
            'getUserTask' => array(
                'class' => 'application.controllers.pcapilist.GetUserTaskAction',
            ),
            'newTaskCallback' => array(
                'class' => 'application.controllers.pcapilist.NotifyNewTaskAction',
            ),
            'getUserLocList' => array(
                'class' => 'application.controllers.pcapilist.GetUserLocListAction',
            ),
             'getUserInfoNew' => array(
               'class' => 'application.controllers.pcapilist.GetUserInfoNewAction',
            ),
            'addressParser' => array(
                'class' => 'application.controllers.pcapilist.AddressParserAction',
            ),
            'queryOrder' => array(
                'class' => 'application.controllers.pcapilist.SurveyAction',
            ),
        );
    }
}
