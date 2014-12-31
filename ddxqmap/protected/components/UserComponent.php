<?php
/**
 * Created by JetBrains PhpStorm.
 * User: charlie
 * Date: 13-12-20
 * Time: 下午4:24
 * To change this template use File | Settings | File Templates.
 */
class UserComponent extends CComponent
{
    public $name = ''; //用户名
    public $real_name; //真实姓名
    public $sex = 3; //性别
    public $birthday; //生日
    public $id_number; //身份证号
    public $mobile = '12345678901'; //手机号
    const STATUS_OK = 1;
    const STATUS_DEL = -2;
    public $status = 1; //用户状态
    public function __construct(){
    }

}