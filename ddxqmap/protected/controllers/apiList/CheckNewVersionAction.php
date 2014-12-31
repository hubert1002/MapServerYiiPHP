<?php

class CheckNewVersionAction extends ZAction
{
    public $userinfo = '';
    public $uidinfo ;
    public function run()
    {
        $user = $this->userinfo;
        $uid = $this->uidinfo;
        $version= Yii::app()->params['current_version'];
        $data = array(
            'current_version' => $version,
            'download_url' => Yii::app()->params['download_url']
        );
         CommonFn::requestAjax(true, 'ok', $data);

    }


}