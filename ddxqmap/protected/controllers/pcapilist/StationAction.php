<?php

class StationAction extends ZAction
{
    public function run()
    {

        $url = Yii::app()->params['remote_station_url'];
        $result = CommonFn::simple_http($url);
        $res = json_decode($result,true);
        if (!$res['success']) {
        	echo $result;
        	exit();
        }
        $data = array();
        $i = 0;
        foreach ($res['data'] as $value) {
            if ($i==0){
                $value['amend_lat'] = 31.199012;
                $value['amend_lon'] = 121.582788;
            }else if ($i==1){
                $value['amend_lat'] = 31.286011;
                $value['amend_lon'] = 121.605836;
            }else if ($i==2){
                $value['amend_lat'] = 31.249466;
                $value['amend_lon'] = 121.569041;
            }else if ($i==3){
                $value['amend_lat'] = 31.281073;
                $value['amend_lon'] = 121.558693;
            }else if ($i==4){
                $value['amend_lat'] = 31.212906;
                $value['amend_lon'] = 121.552943;
            }else{
                $value['amend_lat'] = 31.199012;
                $value['amend_lon'] = 121.552943;
            }
            if($value['name']=='益江路服务站'){
                //add scrop
                $value['scope'] = $this->getScope();
                $value['amend_lat'] = 31.204093;
                $value['amend_lon'] = 121.634287;
            }


        	$i ++;
        	$data[] = $value;
        }
        CommonFn::requestAjax(true, 'ok', $data);

    }

    public function getScope(){
         $data =array();
         $data[] =array(
             'lon'=>121.646145,
             'lat'=>31.208819,
         );
        $data[] =array(
            'lon'=>121.646109,
            'lat'=>31.206564,
        );
        $data[] =array(
            'lon'=>121.646468,
            'lat'=>31.204155,
        );
        $data[] =array(
            'lon'=>121.637736,
            'lat'=>31.200757,
        );
        $data[] =array(
            'lon'=>121.646145,
            'lat'=>31.199769,
        );
        $data[] =array(
            'lon'=>121.631628,
            'lat'=> 31.202456,
        );
        $data[] =array(
            'lon'=>121.632023,
            'lat'=> 31.204433,
        );
        $data[] =array(
            'lon'=>121.633856,
            'lat'=>31.20644,
        );
        $data[] =array(
            'lon'=>121.641545,
            'lat'=>31.208448,
        );
        $data[] =array(
            'lon'=>121.642192,
            'lat'=>31.20783,
        );
         return $data;
    }

}