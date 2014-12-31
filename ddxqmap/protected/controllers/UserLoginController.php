<?php

/**
 * summary: 配送端app登录
 *
 * date: 2014.10.15
 */
class UserLoginController extends Controller
{
    public function actionIndex()
    {
        $is_debug =true;
        header('Content-Type:application/json;charset=UTF-8');

        $username = Yii::app()->request->getParam('username', '');
        $password = Yii::app()->request->getParam('passwd', '');

        if( empty($username) || empty($password) )
        {
            CommonFn::requestAjax(false, '账号或密码不能不空~');
        }


        $params = array_merge($_POST, $_GET);
        $url = Yii::app()->params['remote_login_url'];
        $post_data = http_build_query($params);

        $result = CommonFn::simple_http_post($url, $post_data);
        $data = json_decode($result,true);
        $final_data =array();

        $final_data['id'] =$data['data']['id'];
        $final_data['mobile'] =$data['data']['mobile'];
        $final_data['name'] =$data['data']['name'];
        $final_data['service_id'] =$data['data']['service_station_id'];
        CommonFn::requestAjax(true, 'ok', $final_data);


    }
}