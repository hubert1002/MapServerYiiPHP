<?php
class AddRecord extends ZAction
{
    public $userinfo = '';
    public $uidinfo ;
    public $typeinfo;
    public function run(){
        header("Content-Type: application/octet-stream");
        if($this->typeinfo == 'insert'){
            $byte=Yii::app()->request->getParam('pic');
            $content = Yii::app()->request->getParam('content');
            $amend_lat = Yii::app()->request->getParam('amend_lat');
            $amend_lon = Yii::app()->request->getParam('amend_lon');
            $imgtype = Yii::app()->request->getParam('type');
            $address = Yii::app()->request->getParam('address');
            $byte = str_replace(' ','',$byte);   //处理数据 
            $byte = str_ireplace("<",'',$byte);
            $byte = str_ireplace(">",'',$byte);
            $byte=pack("H*",$byte);
     		if (empty($type)) {
     			$type = "png";
     		}
            $imageName = 'big_record_'.time().'.'.$type;
            $imagePath = dirname(dirname(dirname(dirname(__FILE__))))."/images/";
            if (!file_exists($imagePath)) {
            	mkdir($imagePath,0777);
            }
     		$imagePath = $imagePath.$imageName;
            file_put_contents($imagePath, $byte);
        
            $model=new Record();
            $model->imgpath = $imagePath;
            $model->content = $content;
            $model->amend_lat = $amend_lat;
            $model->amend_lon = $amend_lon;
            $model->imgname = $imageName;
            if (!empty($address)) {
            	$model->address = $address;
            }
            if($model->save()){
                CommonFn::requestAjax(true, 'ok', "");
            }else{
                CommonFn::requestAjax(false, 'error', "");
            }
        }elseif ($this->typeinfo == 'read') {
            $server = $_SERVER['SERVER_NAME'];
            echo $server;
            exit();
            $imgId = Yii::app()->request->getParam('id');
            if(empty($imgId)){
                CommonFn::requestAjax(FALSE,'id is null','');
            }
            $sql = 'select * from tbl_record where id = '.$imgId;
          
            $model = Record::model()->findBySql($sql);
            
             $data = $model->attributes;
             $data['imgurl'] = $_SERVER['SERVER_NAME'];
             CommonFn::requestAjax(true, 'ok', $data);
        }
     
    }
}
?>

