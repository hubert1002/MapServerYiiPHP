<?php
/*
快送小哥 信息
*/
class DeliverBoyInfo extends ZAction
{
    public $userinfo = '';
    public $uidinfo ;
    public $typeinfo;
    public function run()
    {
        $user = $this->userinfo;
        $uid = $this->uidinfo;
        $type = $this->typeinfo;

        $target_uid = Yii::app()->request->getParam('uid');
        if(empty($target_uid)){

           /*
                todo:
           */
            CommonFn::requestAjax(true, 'ok', $data);
        }else{
            /*
                todo:
           */
            CommonFn::requestAjax(true, 'ok', $data);
        }

    }

}