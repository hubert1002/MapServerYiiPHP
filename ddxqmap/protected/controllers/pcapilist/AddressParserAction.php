<?php

class AddressParserAction extends ZAction
{
    public function run()
    {
        //ok
        if(false){
            $url='http://10.192.10.155:8000/getStandardAddress?buildNumber=2%E5%8F%B7ww&name=%E7%8E%89%E5%85%B0%E9%A6%99%E8%8B%91&address=wwww%E4%B8%89%E6%9C%9F';
            $result = CommonFn::simple_http($url);
            echo $result;
            exit;
        }
        //error
        if(false){
            $url='http://10.192.10.155:8000/getStandardAddress';
            $request=array();
            $request['buildNumber']='2%E5%8F%B7ww';
            $request['name']='%E7%8E%89%E5%85%B0%E9%A6%99%E8%8B%91';
            $request['address']='wwww%E4%B8%89%E6%9C%9F';

            $result = CommonFn::simple_http_post($url,$request);
            echo $result;
            exit;
        }
        if(true){
            $url='http://10.192.10.155:8000/getStandardAddress';
//            $buildNumber = Yii::app()->request->getParam('buildNumber');
//            $name = Yii::app()->request->getParam('name');
//            $address = Yii::app()->request->getParam('address');
            $buildNumber='2%E5%8F%B7ww';
            $name='%E7%8E%89%E5%85%B0%E9%A6%99%E8%8B%91';
            $address='wwww%E4%B8%89%E6%9C%9F';
            $final_url= $url.'?name='.$name.'&buildNumber='.$buildNumber.'&address='.$address;
            $result = CommonFn::simple_http($final_url);
            echo $result;
            exit;
        }


        $url = Yii::app()->params['local_py_address_parser'];


        $params = array_merge($_POST, $_GET);
        $post_data = http_build_query($params);

        $result = CommonFn::simple_http_post($url,$post_data);

        echo $result;
        exit;


        $res = json_decode($result,true);
        if (!$res['success']) {
        	echo $result;
        	exit();
        }
        $data = array();
        CommonFn::requestAjax(true, 'ok', $data);

    }


}