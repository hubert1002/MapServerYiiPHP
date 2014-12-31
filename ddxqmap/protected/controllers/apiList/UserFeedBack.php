<?php
/*
对应数据库  tbl_feedback
 * @property string $userid
 * @property string $time
 * @property string $content
 *  */
class UserFeedBack extends ZAction
{
    public $userinfo = '';
    public $uidinfo ;
    public $typeinfo;
    public function run()
    {
        $user = $this->userinfo;
        $uid = $this->uidinfo;
        $type = $this->typeinfo;
        if($type=="insert"){
            $content = Yii::app()->request->getParam('content');
            $time =time();
            $user_id =$uid;

            $model=new Feedback;
            $model->userid = $user_id;
            $model->content = $content;
            $model->time = $time;
            if($model->save()){
                CommonFn::requestAjax(true, 'ok', "");
            }else{
                CommonFn::requestAjax(false, 'error', "");
            }

        }else if($type=="query"){
            $target_uid = Yii::app()->request->getParam('uid');
            if(empty($target_uid)){

                $lists = Feedback::model()->findAll();
                $data = array();
                foreach ($lists as $value) {
                    $data['list'][] = $value->attributes;
                }
                CommonFn::requestAjax(true, 'ok', $data);
            }else{
                $model=Feedback::model()->findByPk($id);
                // if($model===null)
                //     throw new CHttpException(404,'The requested page does not exist.');
                $data = array(
                    'list' => $model->attributes,
                );
                CommonFn::requestAjax(true, 'ok', $data);
            }

        }

    }

}