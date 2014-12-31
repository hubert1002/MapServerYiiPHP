<?php

class NotifyNewTaskAction extends ZAction
{
    public function run()
    {
        $base64 = Yii::app()->request->getParam('data', '');
        if(!empty($base64)){
            $oridata = base64_decode($base64);
            $data = json_decode($oridata,true);
            $alias =array();
            $alias[]=$data['user_id'];
            $title =$data['data']['text'];
            if(!preg_match ("/已/", $title)){
                JPushHandler::pushInfo($alias,$title,$data['data']);
                CommonFn::requestAjax(true);
            }else{
                CommonFn::requestAjax(false);
            }
        }else{
            CommonFn::requestAjax(false);
        }
    }


}