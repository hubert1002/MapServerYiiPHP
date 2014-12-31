<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AppController extends CController
{
    protected $secretKey = '';

    public function init()
    {
//        header('Content-Type:application/json;charset=UTF-8');

        $req = new CHttpRequest();
        Yii::log($req->getUrl());
    }
//
//    /**
//     * 远程验证sign
//     *
//     * @param array $param
//     * @return boolean
//     */
//    protected function checkSignToRemote()
//    {
//        if ( !CommonFn::$is_release )
//        {
//            return false;
//        }
//
//        $skip_arr = array('r');
//
//        $url = Yii::app()->params['sign_url'];
//        $params = array_merge($_POST, $_GET);
//
//        foreach ($skip_arr as $value)
//        {
//            unset($params[$value]);
//        }
//
//        $post_data = http_build_query($params);
//
//        $result = CommonFn::simple_http_post($url, $post_data);
//
//        $res = json_decode($result);
//        if ( empty($res->success) )
//        {
//            echo $result;
//            exit();
//        }
//    }
//
//    /**
//     * 请求参数验证
//     *
//     * @param array $param
//     * @return boolean
//     */
//    protected function checkSign()
//    {
//        if ( !CommonFn::$is_release )
//        {
//            return false;
//        }
//
//        $param = array_merge($_POST, $_GET);
//
//        $gen_sign = $this->_genSign($param);
//
//        if ($param['sign'] !== $gen_sign)
//        {
//            CommonFn::requestAjax(false, 'invalid');
//        }
//    }

//    /**
//     * 根据url参数生成校验码
//     */
//    private function _genSign($param)
//    {
//        // 特殊参数逻辑，具体问客户端相关开发
//        if (isset($param['message']) && $param['message'] === '' && isset($param['app_client_id']) && $param['app_client_id'] == 2)
//        {
//            $param['message'] = 'null';
//        }
//
//        $param['private_key'] = $this->secretKey;
//
//        ksort($param);
//
//        $skip_arr = array('do', 'file', 'act', 'what', 'sign', 'r');
//
//        $param_str = '';
//        foreach ($param as $key => $value)
//        {
//            if (in_array($key, $skip_arr, true))
//            {
//                continue;
//            }
//
//            $param_str .= '&' . $key . '=' . $value;
//        }
//
//        $param_str = trim($param_str, '&');
//
//        return md5($param_str);
//    }

}
