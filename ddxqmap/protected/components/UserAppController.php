<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class UserAppController extends AppController {

    /**
     * 用户ID
     *
     * @var string
     */
    public $uid = '';
    public  $user ;

    public function init()
    {
        parent::init();
        
        $r = @$_GET['r'];
        	// 叮咚小区App登陆
        	//$this->checkSignByAppVersion();
           // $this->getUserInfo();
        	$uid = Yii::app()->request->getParam('uid');
        	if (empty($uid))
        	{
        		CommonFn::requestAjax(false, '你的访问已过期,请重新登录~');
        	}
        	//查询远程查询uid是否有效如果有效则进入
            if(true){
                $user = new UserComponent();
            }else{
            }
        	if (empty($user))
        	{
        		CommonFn::requestAjax(false, '非法用户~');
        	}
        	else if (UserComponent::STATUS_DEL == $user->status)
        	{
        		CommonFn::requestAjax(false, '你的权限已被关闭');
        	}
        	else if (empty($user->mobile))
        	{
        		CommonFn::requestAjax(false, 'oh，漏！你的账号诡异了你造吗？\n1、速速进入个人中心，重新登录；\n2、如若解决不了，联系叮咚小妹021-50276099-8653。');
        	}

        $this->uid = $uid;
        $this->user = $user;
    }


    public function  getUserInfo(){

        $url = Yii::app()->params['userinfo_url'];

         $url= "http://10.192.10.155/map-php/ddxqmap/index.php?r=login/test";

        $skip_arr = array('r');

        $uid = Yii::app()->request->getParam('uid');
        $params = array_merge($_POST, $_GET);

        foreach ($skip_arr as $value)
        {
            unset($params[$value]);
        }

        $post_data = http_build_query($params);

        $result = CommonFn::simple_http_post($url, $post_data);

        $res = json_decode($result);
        if ( empty($res->success) )
        {
            echo $result;
         //   exit();
        }
    }

}
