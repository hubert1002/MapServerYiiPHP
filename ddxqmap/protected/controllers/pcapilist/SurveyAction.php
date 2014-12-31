<?php

class SurveyAction extends ZAction
{
    //订单的四种状态
    const STATUS_CANCELLED = -1;
    const STATUS_WAIT_ASSIGN = 0;
    const STATUS_DEPARTURE = 1;
    const STATUS_FINISHED = 2;
//
    const USER_FROM_DDXQAPP= 0;
    const USER_FROM_WEIXIN = 1;
    public function run()
    {
        $station_id = Yii::app()->request->getParam('station_id', 'all');
        $static_type =Yii::app()->request->getParam('static_type', '1');
        $start_time =Yii::app()->request->getParam('start_time','');
        $end_time =Yii::app()->request->getParam('end_time', time());
        if(!empty($start_time)){
            $start_time  =strtotime($start_time);
        }else{
            $start_time = time()-60*60*24;
        }
        if(!empty($end_time)){
            $end_time =strtotime($end_time);
        }else{
            $end_time = time();
        }

        $query = array(
            'create_time' => array( '$gt' => $start_time, '$lt' => $end_time ),
        );
        if($station_id!='all'){
            $query['service_station']=new MongoId( $station_id );
        }
        $tempColl =CommonFn::getMongoCollection('delivery','delivery_order');
        switch ( $static_type)
        {
            case 1 :          //到达率

                $fiQuery = array_merge($query,array('status' =>self::STATUS_FINISHED) );
                $fi_count = $tempColl->count($fiQuery);

                $deQuery = array_merge($query,array('status' =>self::STATUS_DEPARTURE) );
                $de_count = $tempColl->count($deQuery);

                $waQuery = array_merge($query,array('status' =>self::STATUS_WAIT_ASSIGN) );
                $wa_count = $tempColl->count($waQuery);

                $caQuery = array_merge($query,array('status' =>self::STATUS_CANCELLED) );
                $ca_count = $tempColl->count($caQuery);

                $data =array(
                    'finished'=>$fi_count,
                    'departure'=>$de_count,
                    'wait_assign'=>$wa_count,
                    'canceled'=>$ca_count,
                );
                CommonFn::requestAjax(true,'ok',$data);



                break;
            case 2 :          //及时率
                //得到该时段已完成的订单
                $fiQuery = array_merge($query,array('status' =>self::STATUS_FINISHED) );
                $data = $tempColl->find($fiQuery);
                $time=array(
                    15*60,20*60,30*60,
                );
                $count =0;
                $count1=0;
                $count2 =0;
                $count3 =0;
                $count4 =0;
                foreach($data as $row){
                    if($row['update_time']-$row['create_time']<=15*60){
                        $count1 ++;
                    }else if($row['update_time']-$row['create_time']<=20*60){
                        $count2 ++;
                    }else if($row['update_time']-$row['create_time']<=30*60){
                        $count3 ++;
                    }else if($row['update_time']-$row['create_time']>30*60){
                        $count4 ++;
                    }
                    $count++;
                }
                $data =array(
                    'less_15_min'=>$count1,
                    '_15_20_min'=>$count2,
                    '_20_30_min'=>$count3,
                    'above_30_min'=>$count4,
                );
                CommonFn::requestAjax(true,'ok',$data);
                break;
            case 3 :          //来源分布

                $ddxqQuery = array_merge($query,array('user_source' =>self::USER_FROM_DDXQAPP) );
                $ddxq_count = $tempColl->count($ddxqQuery);

                $wxQuery = array_merge($query,array('status' =>self::USER_FROM_WEIXIN) );
                $wx_count = $tempColl->count($wxQuery);


                $data =array(
                    'ddxqapp'=>$ddxq_count,
                    'weixin'=>$wx_count
                );
                CommonFn::requestAjax(true,'ok',$data);

                break;
            case 4 :          //采购分布
                $caQuery = array_merge($query,array('status' =>self::STATUS_CANCELLED) );
                $data = $tempColl->find($caQuery);
                $count =array(0,0,0,0,0,0,0,0,0,0);
                foreach($data as $row){
                    $count[$row['cancel_type']]++;
                }
//                $data =array(
//                    '状态0'=>$count[0],
//                    '用户取消'=>$count[1],
//                    '回访取消'=>$count[2],
//                    '采购失败'=>$count[3],
//                    '坏单'=>$count[4],
//                    '提货失败'=>$count[5],
//                    '打包失败'=>$count[6],
//                    '卸货失败'=>$count[7],
//                    '支付超时'=>$count[8],
//                );
                $data =array();
                $data[]=array(
                    'name'=>'用户取消',
                    'count'=>$count[1]
                );
                $data[]=array(
                    'name'=>'回访取消',
                    'count'=>$count[2]
                );
                $data[]=array(
                    'name'=>'采购失败',
                    'count'=>$count[3]
                );
                $data[]=array(
                    'name'=>'坏单',
                    'count'=>$count[4]
                );
                $data[]=array(
                    'name'=>'提货失败',
                    'count'=>$count[5]
                );
                $data[]=array(
                    'name'=>'打包失败',
                    'count'=>$count[6]
                );
                $data[]=array(
                    'name'=>'卸货失败',
                    'count'=>$count[7]
                );
                $data[]=array(
                    'name'=>'支付超时',
                    'count'=>$count[8]
                );
                CommonFn::requestAjax(true,'ok',$data);
                break;
            case 5 :          //用户喜好
                //得到订单数据
                $data = $tempColl->find($query);
                $ids =array();
                foreach($data as $value){
                    $ids[]=$value['_id'];
                }
                $tempColl =CommonFn::getMongoCollection('delivery','delivery_order_item');
                $queryData= $tempColl->find(array( 'order' => array('$in' => $ids)));
                $final_data =iterator_to_array($queryData);
                $result = array();
                foreach ($final_data as $row) {

                    if(count($row)<=12)
                        continue;;

                    $product_id =(string)$row['product'];
                    $hasPutin =false;
                    foreach($result as &$child){
                        if($child['product_id']==$product_id){
                            $child['count']=$row['amount']+$child['count'];
                            $hasPutin=true;
                            break;
                        }
                    }
                    if(!$hasPutin){
                        $result[]=array(
                            'product_id'=>$product_id,
                            'name'=>$row['product_name'],
                            'count'=>$row['amount'],
                        );
                    }
                }
                $result=self::sortArray($result);
                $res_data =array();
                $index =0;
                $list_len=9;
                $total_count =0;
                $top_count =0;
                foreach($result as $item){
                    if($index<$list_len){
                        $res_data[]=$item;
                        $top_count+=$item['count'];
                    }
                    $total_count+=$item['count'];
                    $index++;
                }
                $res_data[]=array(
                    'product_id'=>'other id ',
                    'name'=>'其他',
                    'count'=>$total_count-$top_count,
                );
//                $queryData=  $tempColl->group(array('product'), array('sum' => 0), "function (obj, prev) { prev['sum'] += obj.amount; }");

//                $keys = array("product" => 1);
//                $initial = array('sum' => 0);
//                $reduce = "function (obj, prev) { prev['sum'] += obj.amount; }";
//                $queryData = $tempColl->group($keys, $initial, $reduce);

//                $final_data =iterator_to_array($queryData);
                CommonFn::requestAjax(true,'ok',$res_data);


                break;
            case 6 :          //分时吞吐率
                $my_time=array();
                $my_time[] =strtotime(date("Y-m-d",$start_time).' 00:00');
                $my_time[] =strtotime(date("Y-m-d",$start_time).' 08:00');
                $my_time[] =strtotime(date("Y-m-d",$start_time).' 10:00');
                $my_time[] =strtotime(date("Y-m-d",$start_time).' 12:00');
                $my_time[] =strtotime(date("Y-m-d",$start_time).' 14:00');
                $my_time[] =strtotime(date("Y-m-d",$start_time).' 16:00');
                $my_time[] =strtotime(date("Y-m-d",$start_time).' 20:00');
                $my_time[] =strtotime(date("Y-m-d",$start_time).' 23:59');
                $time_query=array();
                for($i=0;$i<count($my_time)-1;$i++){
                    $time_query[]=array(
                        'create_time' => array( '$gt' => $my_time[0], '$lt' =>  $my_time[$i+1] )
                    );
                }
                $id_query=array();
                if($station_id!='all'){
                    $id_query['service_station']=new MongoId( $station_id );
                }
                $data=array();
                for($i=0;$i<count($time_query);$i++){
                    $fiQuery = array_merge($id_query,$time_query[$i],array('status' =>self::STATUS_FINISHED) );
                    $fi_count = $tempColl->count($fiQuery);
                    $allQuery = array_merge($id_query,$time_query[$i]);
                    $all_count = $tempColl->count($allQuery);
                    $data[]=array(
                        'time_section'=>date("H",$my_time[$i]).'-'.date("H",$my_time[$i+1]).'点',
                        'all_count'=>$all_count,
                        'finish_count'=>$fi_count
                    );
                }
                CommonFn::requestAjax(true,'ok',$data);
                break;
            case 7 :          //全站吞吐一览
                $stationColl =CommonFn::getMongoCollection('delivery','service_station');
                $station_query = array(
                    'status' => 1,//已开通
                );
                $station_data = $stationColl->find($station_query);
                $final_data =array();
                foreach($station_data as $row){
                    $query = array(
                        'create_time' => array( '$gt' => $start_time, '$lt' => $end_time ),
                        'service_station'=>$row['_id']
                    );
                    $fiQuery = array_merge($query,array('status' =>self::STATUS_FINISHED) );
                    $fi_count = $tempColl->count($fiQuery);
                    $total_count = $tempColl->count($query);
                    $rate=0;
                    if($total_count!=0)
                       $rate =round($fi_count/$total_count*100);
                    $final_data[]=array(
                        'name'=>$row['name'],
                        'finished'=>$fi_count,
                        'total'=>$total_count,
                        'count'=>$rate
                    );
                }

                CommonFn::requestAjax(true,'ok',$final_data);
                break;

            case 60 :          //测试
                $data = $tempColl->find($query);
                $final_data =iterator_to_array($data);
                CommonFn::requestAjax(true,'ok',$final_data);
                break;
            case 70 :          //测试
                $tempColl =CommonFn::getMongoCollection('delivery','delivery_order_task');
                $data = $tempColl->find();
                $final_data =iterator_to_array($data);
                CommonFn::requestAjax(true,'ok',$final_data);
                break;
            case 80 :          //测试
                $caQuery = array_merge($query,array( 'cancel_type' => array('$ne' => 0)));//!=0
                $count= $tempColl->count($caQuery);
                $data =array('cancel'=>$count);
                CommonFn::requestAjax(true,'ok',$data);
                break;
            default:

        }
         CommonFn::requestAjax(false);
    }

    private static  function sortArray($array){
        for ($i=0; $i < count($array); $i++) {
            for ($j=$i; $j < count($array); $j++) {
                $iArr = $array[$i];
                $jArr = $array[$j];
                if ($iArr['count'] < $jArr['count']) {
                    $array[$i] = $jArr;
                    $array[$j] = $iArr;
                }
            }
        }
        return $array;
    }



}