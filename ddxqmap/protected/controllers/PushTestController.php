<?php

class PushTestController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('push','update'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('push','delete'),
                'users'=>array('admin'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionPush()
    {
        $model=new PushForm;
        if(isset($_POST['PushForm']))
        {
            $model->attributes=$_POST['PushForm'];
            // if($model->validate())
            {

                self::pushSomething($model);
                Yii::app()->user->setFlash('push',' Push ok');
                $this->refresh();
            }
        }
        $this->render('push',array('model'=>$model));
    }

    public function  pushSomething($model){
        $title = Yii::app()->request->getParam('title','订单标题');
        if(!empty($model->title)){
            $title = $model->title;
        }

        $contact_name = Yii::app()->request->getParam('contact_name','叮咚');
        if(!empty($model->contact_name)){
            $contact_name = $model->contact_name;
        }

        $contact_mobile =Yii::app()->request->getParam('contact_mobile','110');
        if(!empty($model->contact_mobile)){
            $contact_name = $model->contact_mobile;
        }

        $lat =Yii::app()->request->getParam('lat','31.19825');
        $lon =Yii::app()->request->getParam('lon','121.632823');
        $radius =Yii::app()->request->getParam('radius','10.0');
        $address =Yii::app()->request->getParam('address','玉兰');
        $order_id =Yii::app()->request->getParam('order_id','121212121212');
        $order_description =Yii::app()->request->getParam('order_description','order description');
        $unit = Yii::app()->request->getParam('unit','9');
        $amend_lat =Yii::app()->request->getParam('amend_lat','31.203958');
        $amend_lon =Yii::app()->request->getParam('amend_lon','121.639387');

        $alias_id = Yii::app()->request->getParam('alias_id','53e2ab3994058adf8c2474c9');
        $tags_id = Yii::app()->request->getParam('tags_id','53e9f1527f8b9a7b55000035');
        $json ='{"operator_id":"53fc259b7f8b9afa580001b8","operator_name":"\u6768\u4eae","order_id":"548575fedb26ce6e758bde72","order_code":"0009","user_name":"\u5fae\u4fe1\u7528\u6237","user_mobile":"18729554571","user_village":"\u5927\u5510\u76db\u4e16\u82b1\u56ed\uff08\u4e00\u81f3\u4e8c\u671f\uff09","user_village_period":"\u4e8c\u671f","user_build_number":"6\u53f7","user_room_number":"8\u5ba4","order_item":[{"product_id":"546bfdb97f8b9ae8090041e4","product_name":"\u7535\u6c60111","product_count":1,"stockout_amount":0,"product_price":0,"product_picture":"http:\/\/iyaya-neighborhood.u.qiniudn.com\/5dd2da651416363429454.png!delivery.product.list","partner_name":"\u4e24\u9c9c\u7f51\u6c34\u679c","partner_number":21}],"service_station_id":"53e9fdba7f8b9aa455000039","task_status":1,"task_type":1,"task_create_time":1418032820,"task_finish_time":1418032836,"purchase_name":null,"purchase_address":null,"delivery_name":"\u4e1c\u6e2f\u4e50","delivery_address":"\u4e1c\u6e2f\u4e50","amend_lat":"31.204576","amend_lon":"121.640213","lat":"31.198858","lon":"121.633653"}';
        $data = json_decode($json,true);

        $final = array(
            'title'=>$title,
            'order_code'=>$data['order_code'],
            'order_id'=>$data['order_id'],
            'user_name'=>$data['user_name'],
            'user_mobile'=>$data['user_mobile'],
            'user_village'=>$data['user_village'],
            'user_village_period'=>$data['user_village_period'],
            'user_build_number'=>$data['user_build_number'],
            'user_room_number'=>$data['user_room_number'],
            'task_create_time'=>$data['task_create_time'],
            'task_finish_time'=>$data['task_finish_time'],
            'delivery_address'=>$data['delivery_address'],
            'amend_lat'=>$data['amend_lat'],
            'amend_lon'=>$data['amend_lon'],
            'order_item'=>$data['order_item'],
        );

        $alias =array();
        $alias[]=$alias_id;
        $tags =array();
        $tags[]=$tags_id;
        JPushHandler::push($alias,$tags,$title,$final);


    }

    public function actionIndex()
    {
        echo 'this is push';
    }



    /**
     * Performs the AJAX validation.
     * @param Feedback $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='feedback-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
