<?php
/*
对应数据库  tbl_geo_add
 * @property integer $id
 * @property integer $type
 * @property double $lat
 * @property double $lon
 * @property string $city
 * @property string $station
 * @property string $neighbourhood
 * @property string $unit
 * @property string $description
 * @property double $amend_lat
 * @property double $amend_lon
 *  */
class VillageAdd extends ZAction
{
    public $userinfo = '';
    public $uidinfo ;
    public $typeinfo;
    public function run()
    {
        $user = $this->userinfo;
        $uid = $this->uidinfo;
        $typeinfo = $this->typeinfo;
         
        if($typeinfo == 'insert'){
            
            $type = Yii::app()->request->getParam('type');
            $lat = Yii::app()->request->getParam('lat');
            $lon = Yii::app()->request->getParam('lon');
            $city = Yii::app()->request->getParam('city');
            $station = Yii::app()->request->getParam('station');
            $name = Yii::app()->request->getParam('name');
            $address = Yii::app()->request->getParam('address');
            $build_number = Yii::app()->request->getParam('build_number');
            $description = Yii::app()->request->getParam('description');
            $amend_lat = Yii::app()->request->getParam('amend_lat');
            $amend_lon = Yii::app()->request->getParam('amend_lon');
            
    
            $model=new GeoAdd();
            $model->type = $type;
            $model->lat = $lat;
            $model->lon = $lon;
            $model->city = $city;
            $model->station = $station;
            $model->name = $name;
            $model->address = $address;
            $model->build_number = $build_number;
            if(!empty($description)){
                $model->description = $description;
            }else {
                $model->description = '采集的数据';
           }  
            $model->amend_lat = $amend_lat;
            $model->amend_lon = $amend_lon;
            
            if($model->save()){
                CommonFn::requestAjax(true, 'ok', "");
            }else{
               // $model->errors;
                CommonFn::requestAjax(false, 'error', "");
            } 
        } elseif ($typeinfo == 'query') {
            $result = GeoAdd::model()->findAll();
             if(empty($result)){
                CommonFn::requestAjax(false);
         }
             foreach ($result as $value)
            {
                $data['list'][] = array(
                    'type' => $value->type,
                    'lat' =>$value->lat,
                    'city' => $value->city,
                    'lon' => $value->lon,
                    'station' => $value->station,
                    'name' => $value->name,
                    'address' => $value->address,
                    'build_number' => $value->build_number,
                    'description' => $value->description,
                    'amend_lat' => $value->amend_lat,
                    'amend_lon' => $value->amend_lon
                );
            }
            CommonFn::requestAjax(true, 'ok', $data);
        }
        
    }
}