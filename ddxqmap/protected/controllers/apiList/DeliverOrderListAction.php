<?php

class DeliverOrderListAction extends ZAction
{
    public $userinfo = '';
    public $uidinfo ;
    public $typeinfo;
    public function run()
    {
//        $user = $this->userinfo;
//        $uid = $this->uidinfo;
//        $type = $this->typeinfo;

        $type = $this->typeinfo;
        if($type=="unfinished"){
            $criteria=new CDbCriteria;
            $criteria->limit=5;
            $criteria->order='id ASC';
            $list=GeoAdd::model()->findAll($criteria); // $params is not needed
            $data='';
            $index =0;
            foreach ($list as $row)
            {
                $data['order_list'][] = array(
                    'title' => 'title'.$index,
                    'content' =>'content'.$index,
                    'order_time' => time()-100,
                    'custom_name' =>'custom_name'.$index,
                    'amend_lat' => $row->amend_lat,
                    'amend_lon' => $row->amend_lon,
                    'address' =>'玉兰test',
                    'unit' => $row->build_number,
                    'lon' =>$row->lon,
                    'lat' =>$row->lat
                );
                $index++;
            }
            CommonFn::requestAjax(true, 'ok', $data);
        }else{
            $criteria=new CDbCriteria;
            $criteria->limit=5;
            $criteria->order='id ASC';
            $list=GeoAdd::model()->findAll($criteria); // $params is not needed
            $data='';
            $index =0;
            foreach ($list as $row)
            {
                $data['order_list'][] = array(
                    'title' => 'finished title'.$index,
                    'content' =>'content'.$index,
                    'order_time' => time()-100,
                    'custom_name' =>'custom_name'.$index,
                    'amend_lat' => $row->amend_lat,
                    'amend_lon' => $row->amend_lon,
                    'address' =>'玉兰test',
                    'unit' => $row->build_number,
                    'lon' =>$row->lon,
                    'lat' =>$row->lat
                );
                $index++;
            }
            CommonFn::requestAjax(true, 'ok', $data);
        }





    }





}
