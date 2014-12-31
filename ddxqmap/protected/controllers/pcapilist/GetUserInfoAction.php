<?php

class GetUserInfoAction extends ZAction
{
    public function run()
    {

        $params = array_merge($_POST, $_GET);
        $url = Yii::app()->params['remote_getuserinfo_url'];
        $post_data = http_build_query($params);
        $result = CommonFn::simple_http_post($url, $post_data);
        $res = json_decode($result,true);
        if(!empty($res)){
            if($res['success']){
                CommonFn::requestAjax(true, '', $res['data']);
            }else{
                CommonFn::requestAjax(false,$res['message']);
            }
        }else{
            CommonFn::requestAjax(false, '操作失败',$res);
        }

    }


}