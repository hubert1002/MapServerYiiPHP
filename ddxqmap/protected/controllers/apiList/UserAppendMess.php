<?php
class UserAppendMess extends ZAction 
{
	public $userinfo = '';
    public $uidinfo;
    public $typeinfo;
	public function run(){
		$user = $this->userinfo;
        $uid = $this->uidinfo;
        $type = $this->typeinfo;

		$userid = Yii::app()->request->getParam('userid');
		if (empty($userid)) {
			CommonFn::requestAjax(FALSE, 'userid is null', '');
		}

		if ($type == 'insert') {
			
			$tag = Yii::app()->request->getParam('tag');
			$gatelock = Yii::app()->request->getParam('gate_lock');
			$description = Yii::app()->request->getParam('description');
			$sql = "select * from tbl_user_append where userid = '$userid'";
            $model = UserAppend::model()->findBySql($sql);
            if (empty($model)) {
            	$model = new UserAppend;
            	$model->userid = $userid;
            }

        	if (!empty($tag)) {
        		$model->tag = $tag;
        	}
        	if (!empty($gatelock)) {
        		$model->gatelock = $gatelock;
        	}
        	if (!empty($description)) {
        		$model->description = $description;
        	}
        	if($model->save()){
            	CommonFn::requestAjax(true, 'ok', "");
        	}else{
            	CommonFn::requestAjax(false, 'save failed', "");
        	}
			
		} elseif ($type == 'query') {
			$sql = "select * from tbl_user_append where userid = '$userid'";
            $model = UserAppend::model()->findBySql($sql);
            if (empty($model)) {
            	$str = "no record of $userid";
            	CommonFn::requestAjax(true, $str, '');
            }
            $data = $model->attributes;
            CommonFn::requestAjax(true, 'ok', $data);
		}
	}
}
?>