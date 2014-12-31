<?php

require_once 'vendor/autoload.php';


use JPush\Model as M;
use JPush\JPushClient;
use JPush\JPushLog;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use JPush\Exception\APIConnectionException;
use JPush\Exception\APIRequestException;





class JPushHandler{
    public static  $br = '<br/>';
    public static $master_secret = '9183745e6ab8c6adf3239782';
    public static  $app_key='f30ecc249c9862131ff674a3';

    //$master_secret = 'd94f733358cca97b18b2cb98';
    //$app_key='47a3ddda34b2602fa9e17c01';

    public static function test(){
        //JPushLog::setLogHandlers(array(new StreamHandler('jpush.log', Logger::DEBUG)));
        $client = new JPushClient(JPushHandler::$app_key, JPushHandler::$master_secret);
        try {
            $result = $client->push()
                ->setPlatform(M\all)
                ->setAudience(M\all)
                ->setNotification(M\notification('Hi, JPush'))
                ->printJSON()
                ->send();
            echo 'Push Success.' . JPushHandler::$br;
            echo 'sendno : ' . $result->sendno . JPushHandler::$br;
            echo 'msg_id : ' .$result->msg_id . JPushHandler::$br;
            echo 'Response JSON : ' . $result->json . JPushHandler::$br;
        } catch (APIRequestException $e) {
            echo 'Push Fail.' . JPushHandler::$br;
            echo 'Http Code : ' . $e->httpCode . JPushHandler::$br;
            echo 'code : ' . $e->code . JPushHandler::$br;
            echo 'Error Message : ' . $e->message . JPushHandler::$br;
            echo 'Response JSON : ' . $e->json . JPushHandler::$br;
            echo 'rateLimitLimit : ' . $e->rateLimitLimit . JPushHandler::$br;
            echo 'rateLimitRemaining : ' . $e->rateLimitRemaining . JPushHandler::$br;
            echo 'rateLimitReset : ' . $e->rateLimitReset . JPushHandler::$br;
        } catch (APIConnectionException $e) {
            echo 'Push Fail: ' . JPushHandler::$br;
            echo 'Error Message: ' . $e->getMessage() . JPushHandler::$br;
            echo 'IsResponseTimeout: ' . $e->isResponseTimeout . JPushHandler::$br;
        }
    }

    public static function testInfo($title){
        //JPushLog::setLogHandlers(array(new StreamHandler('jpush.log', Logger::DEBUG)));
        $client = new JPushClient(JPushHandler::$app_key, JPushHandler::$master_secret);
        try {
            $result = $client->push()
                ->setPlatform(M\all)
                ->setAudience(M\all)
                ->setNotification(M\notification($title))
                ->printJSON()
                ->send();
            echo 'Push Success.' . JPushHandler::$br;
            echo 'sendno : ' . $result->sendno . JPushHandler::$br;
            echo 'msg_id : ' .$result->msg_id . JPushHandler::$br;
            echo 'Response JSON : ' . $result->json . JPushHandler::$br;
        } catch (APIRequestException $e) {
            echo 'Push Fail.' . JPushHandler::$br;
            echo 'Http Code : ' . $e->httpCode . JPushHandler::$br;
            echo 'code : ' . $e->code . JPushHandler::$br;
            echo 'Error Message : ' . $e->message . JPushHandler::$br;
            echo 'Response JSON : ' . $e->json . JPushHandler::$br;
            echo 'rateLimitLimit : ' . $e->rateLimitLimit . JPushHandler::$br;
            echo 'rateLimitRemaining : ' . $e->rateLimitRemaining . JPushHandler::$br;
            echo 'rateLimitReset : ' . $e->rateLimitReset . JPushHandler::$br;
        } catch (APIConnectionException $e) {
            echo 'Push Fail: ' . JPushHandler::$br;
            echo 'Error Message: ' . $e->getMessage() . JPushHandler::$br;
            echo 'IsResponseTimeout: ' . $e->isResponseTimeout . JPushHandler::$br;
        }
    }





    /**
     * @param $alias int[]
     * @param $tags  string[]
     * @param $title  string
     * @param $message内容数组
     */
    public static function push($alias,$tags,$title,$message){
//        JPushLog::setLogHandlers(array(new StreamHandler('jpush.log', Logger::DEBUG)));
        $client = new JPushClient(JPushHandler::$app_key, JPushHandler::$master_secret);
        try {
            $result = $client->push()
                ->setPlatform(M\platform( 'android'))
                ->setAudience(M\audience(M\tag($tags), M\alias($alias)))
                ->setNotification(M\notification($title))
                ->setMessage(M\message('msg content', null, null, $message))
                ->printJSON()
                ->send();
            echo 'Push Success.' . JPushHandler::$br;
            echo 'sendno : ' . $result->sendno . JPushHandler::$br;
            echo 'msg_id : ' .$result->msg_id . JPushHandler::$br;
            echo 'Response JSON : ' . $result->json . JPushHandler::$br;
        } catch (APIRequestException $e) {
            echo 'Push Fail.' . JPushHandler::$br;
            echo 'Http Code : ' . $e->httpCode . JPushHandler::$br;
            echo 'code : ' . $e->code . JPushHandler::$br;
            echo 'Error Message : ' . $e->message . JPushHandler::$br;
            echo 'Response JSON : ' . $e->json . JPushHandler::$br;
            echo 'rateLimitLimit : ' . $e->rateLimitLimit . JPushHandler::$br;
            echo 'rateLimitRemaining : ' . $e->rateLimitRemaining . JPushHandler::$br;
            echo 'rateLimitReset : ' . $e->rateLimitReset . JPushHandler::$br;
        } catch (APIConnectionException $e) {
            echo 'Push Fail: ' . JPushHandler::$br;
            echo 'Error Message: ' . $e->getMessage() . JPushHandler::$br;
            echo 'IsResponseTimeout: ' . $e->isResponseTimeout . JPushHandler::$br;
        }
    }


    /**
     * @param $alias int[]
     * @param $title  string
     * @param $message内容数组
     */
    public static function pushInfo($alias,$title,$message){
        //JPushLog::setLogHandlers(array(new StreamHandler('jpush.log', Logger::DEBUG)));
        $client = new JPushClient(JPushHandler::$app_key, JPushHandler::$master_secret);
        try {
            $result = $client->push()
                ->setPlatform(M\platform( 'android'))
                ->setAudience(M\audience(M\alias($alias)))
                ->setNotification(M\notification($title))
                ->setMessage(M\message('msg content', null, null, $message))
                ->printJSON()
                ->send();
            echo 'Push Success.' . JPushHandler::$br;
            echo 'sendno : ' . $result->sendno . JPushHandler::$br;
            echo 'msg_id : ' .$result->msg_id . JPushHandler::$br;
            echo 'Response JSON : ' . $result->json . JPushHandler::$br;
        } catch (APIRequestException $e) {
            echo 'Push Fail.' . JPushHandler::$br;
            echo 'Http Code : ' . $e->httpCode . JPushHandler::$br;
            echo 'code : ' . $e->code . JPushHandler::$br;
            echo 'Error Message : ' . $e->message . JPushHandler::$br;
            echo 'Response JSON : ' . $e->json . JPushHandler::$br;
            echo 'rateLimitLimit : ' . $e->rateLimitLimit . JPushHandler::$br;
            echo 'rateLimitRemaining : ' . $e->rateLimitRemaining . JPushHandler::$br;
            echo 'rateLimitReset : ' . $e->rateLimitReset . JPushHandler::$br;
        } catch (APIConnectionException $e) {
            echo 'Push Fail: ' . JPushHandler::$br;
            echo 'Error Message: ' . $e->getMessage() . JPushHandler::$br;
            echo 'IsResponseTimeout: ' . $e->isResponseTimeout . JPushHandler::$br;
        }
    }





}

