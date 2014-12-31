<?php
class UserScore extends ZAction
{
    public $userinfo = '';
    public $uidinfo ;
    public $typeinfo;
    public function run()
    {
        $user = $this->userinfo;
        $uid = $this->uidinfo;
        $type = $this->typeinfo;
        
        if($type=='insert'){
            $name = Yii::app()->request->getParam('username');
            if(empty($name)){
                CommonFn::requestAjax(FALSE, 'name is null', '');
            }
            $title = Yii::app()->request->getParam('title');
            if(empty($title)){
                CommonFn::requestAjax(FALSE, 'title is null', '');
            }
            $content = Yii::app()->request->getParam('content');
            if(empty($content)){
                CommonFn::requestAjax(FALSE, 'content is null', '');
            }
            $score = Yii::app()->request->getParam('score');
            if(empty($score)){
                CommonFn::requestAjax(FALSE, 'score is null', '');
            }
            $time = time();
            $model = new Score;
            $model->name = $name;
            $model->title = $title;
            $model->content = $content;
            $model->time = $time;
            $model->score = $score;
            if($model->save()){
                CommonFn::requestAjax(true, 'ok', "");
            }else{
                CommonFn::requestAjax(false, 'save failed', "");
            }
        }elseif ($type=='query') {
        	$page = Yii::app()->request->getParam('page');
        	$pagesize = Yii::app()->request->getParam('pagesize');
        	if (empty($page)) {
        		$page = 1;
        	}
        	if (empty($pagesize)) {
        		$pagesize = 10;
        	}
        	$offset = ($page -1) * $pagesize;
        	$offset = $offset < 0 ? 0 : $offset;
        	$criteria=new CDbCriteria;
        	$criteria->limit=$pagesize;
        	$criteria->offset=$offset;
        	$criteria->order='id ASC';
        	$lists=Score::model()->findAll($criteria);
        	$total = Score::model()->count();
            
            $data = array();
            foreach ($lists as $value) {
            	$data['list'][] = $value->attributes;
            }
            $hasMore = 0;
            if (($offset + $pagesize) < $total) {
            	$hasMore = 1;
            }
            $data['hasMore'] = $hasMore;
            $data['page'] = $page + 1;
            CommonFn::requestAjax(true, 'ok', $data);
        }
    }
}
?>