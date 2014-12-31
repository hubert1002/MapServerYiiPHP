<?php

class StationInfoAction extends ZAction
{
    public function run()
    {
        $station = Yii::app()->request->getParam('server_station', '玉兰');
        //qurry
//        $params = array_merge($_POST, $_GET);
//        $url = Yii::app()->params['remote_login_url'];
//        $post_data = http_build_query($params);
//        $result = CommonFn::simple_http_post($url, $post_data);
//        $res = json_decode($result);

        $criteria=new CDbCriteria;
        $criteria->limit =3;
        $criteria->order='id DESC';
        $list=GeoDeliveryman::model()->findAll($criteria); // $params is not needed

        $data='';
        $index =0;
        foreach ($list as $row)
        {

            if($index==0){
                $data['station_list'][] = array(
                    'station_id' =>$index,
                    'lat' => $row->lat,
                    'lon' => $row->lon,
                    'amend_lat' => $row->lat,
                    'amend_lon' => $row->lon,
                    "name" =>"name".$index,
                    "mobile" =>"111111111".$index,
                );
            }else if($index==1){
                $data['station_list'][] = array(
                    'station_id' =>$index,
                    'lat' => $row->lat+ 0.01,
                    'lon' => $row->lon+ 0.01,
                    'amend_lat' => $row->lat+ 0.01,
                    'amend_lon' => $row->lon+ 0.01,
                    "name" =>"name".$index,
                    "mobile" =>"111111111".$index,
                );
            }else{
                $data['station_list'][] = array(
                    'station_id' =>$index,
                    'lat' => $row->lat- 0.05,
                    'lon' => $row->lon+ 0.05,
                    'amend_lat' => $row->lat- 0.05,
                    'amend_lon' => $row->lon+ 0.05,
                    "name" =>"name".$index,
                    "mobile" =>"111111111".$index,
                );
            }
            $index++;
        }
        CommonFn::requestAjax(true, '', $data);

    }


}