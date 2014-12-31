<?php

class GetUserLocListAction extends ZAction
{
    public $userinfo = '';
    public $uidinfo ;
    public $typeinfo;
    public function run()
    {
        $id = Yii::app()->request->getParam('id', '');
        $time=time()-60*60*24;

        $debug = Yii::app()->request->getParam('debug', false);
        if($debug){
            $id =123456789;
            $time=0;
        }


        $criteria=new CDbCriteria;
        $condition1=sprintf('user_id = "%s"', $id);
        $criteria->addCondition($condition1);
        $condition2=sprintf('time > %d', $time);
        $criteria->addCondition($condition2,'AND');
        $list=GeoDeliveryman::model()->findAll($criteria); // $params is not needed
        $data =array();
        foreach ($list as $row)
        {
                $data[] = array(
                    'user_id' =>$row['user_id'],
                    'lat' => $row['lat'],
                    'lon' => $row['lon'],
                    'amend_lat' => $row['amend_lat'],
                    'amend_lon' => $row['amend_lon'],
                    'time' =>date("H:i:s", $row['time'])//date("Y-m-d H:i:s", time()) ;
                );
          }
         CommonFn::requestAjax(true, 'ok', $data);
    }

}
