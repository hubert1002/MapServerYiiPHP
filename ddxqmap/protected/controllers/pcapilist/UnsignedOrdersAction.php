<?php

class UnsignedOrdersAction extends ZAction
{
    public $typeinfo;
    public function run()
    {
        $type = $this->typeinfo;
        if($type=='get'){
            $params = array_merge($_POST, $_GET);
            $url = Yii::app()->params['remote_getunsignedorders_url'];
            $post_data = http_build_query($params);
            $result = CommonFn::simple_http_post($url, $post_data);
            $res = json_decode($result,true);
            if(!empty($res)){
                if($res['success']){



                    $final_data=array();
                    $data = $res['data'];
                    foreach($data as $value){
                        $list = preg_split ("/号/", $value['user_build_number']);
                        if(!empty($list)&&!empty($list[0])){
                            $location = self::getLocation($list[0]);
                            $final_data[] =array_merge($value,$location);
                        }else{
                            $final_data[] =$value;
                        }
                    }


                    CommonFn::requestAjax(true, '',$final_data);
                }else{
                    CommonFn::requestAjax(false,$res['message']);
                }
            }else{
                CommonFn::requestAjax(false, '操作失败',$res);
            }



        }else{

        }


    }

    private static function getLocation($build_number){

        if(!is_numeric($build_number)){
            return array();
        }
        $criteria=new CDbCriteria;
        $criteria->limit=1;
        $criteria->select = 'amend_lat,amend_lon';
        $criteria->addCondition("build_number=$build_number");
        $list=GeoAdd::model()->findAll($criteria); // $params is not needed
        $data =array();
        if(!empty($list)){
            $data['amend_lat']= $list[0]->amend_lat;
            $data['amend_lon']= $list[0]->amend_lon;

        }else{
            $data['amend_lat']= 000;
            $data['amend_lon']= 000;
        }
        return $data;
    }


}