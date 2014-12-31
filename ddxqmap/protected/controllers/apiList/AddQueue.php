<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class AddQueue
{

    public static $is_run = FALSE; 
    /*
    $post_data  array
    如果是get $post_data为空
    */
    public static function insertRequest($url,$post_data＝array()){
        
        if(!empty($param)){
            $model = new Queue();
            $model->query = $url;
            if (count($post_data) > 0) {
                $model->param = json_encode($post_data);
            }
            if($model->save()){
                
                self::requestAjax(true, 'ok', '');
                ob_flush();
                if (!$is_run) {
                    self::queryQueue();
                    $is_run = true;
                }
                exit();
            }  else {
                CommonFn::requestAjax(FALSE, 'error', '');
            }
        }
    }
    
    private static function queryQueue(){
        $list = Queue::model()->findAll();
        if(count($list) >0){
            $value = array_shift($array);
            $array = $value->attribute;
             if(!empty($array['query'])){
                 self::execQueue($array);
             }
        } else {
            $is_run = FALSE;
        }
    }
    
    private static function execQueue($param){
        $ch = curl_init();
        $curl_opt = array(
            CURLOPT_URL=>$param['query'],
            CURLOPT_RETURNTRANSFER=>1,
            CURLOPT_TIMEOUT=>1
        );
        curl_setopt_array($ch, $curl_opt);
        $result = curl_exec($ch);
        curl_close($ch);
        if (!empty($result)) {
            Queue::model()->deleteByPk($param['id']);
        }
        
        self::queryQueue();
    }
    
    public static function requestAjax($response = true, $message = "", $data = array())
	{
		if ($response)
		{
			if ($message == "")
			{
				$message = "操作成功";
			}
		}
		else
		{
			if ($message == "")
			{
				$message = "操作失败";
			}
		}
		$res = array(
				'success' => $response,
				'message' => $message,
				'data' => $data
		);
		$debug = Yii::app()->request->getParam('debug');
		if ($debug !== null)
		{
			$res['exec_time'] = Yii::getLogger()->getExecutionTime();
		}
		echo json_encode($res);
	}
}
