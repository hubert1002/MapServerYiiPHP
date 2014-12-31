<?php

/**
 * Created on 2012-6-20
 * add by wangyang
 * 全局公共函数
 */
class CommonFn
{
    public static $is_uid_cache = true;
    public static $pre_cached_uid = 'pre_cached_uid';
    public static $uid_cache_time = 30;

    public static $is_stationid_cache = true;
    public static $pre_cached_stationid = '$pre_cached_stationid';
    public static $stationid_cache_time = 30;

    public static $pre_cached_unfinishedlist = '$pre_cached_stationid';
    public static $unfinishedlist_cache_time = 604800;//一周


	// 是否正式环境
	public static $is_release = true;

	/**
	 * 获取easyui datagrid分页参数 返回 limit, offset, order 如果no_page=1 不分页
	 * 
	 * @param $nopage boolean 是否不分页
	 */
	public static function getPageParams($no_page = false)
	{
		$page = Yii::app()->request->getParam('page');
		$rows = Yii::app()->request->getParam('rows');
		$sort = Yii::app()->request->getParam('sort');
		$order = Yii::app()->request->getParam('order');
		if ($page == null || $page < 1)
		{
			$page = 1;
		}
		if ($rows == null)
		{
			$rows = 20;
		}
		$new_sort = array();
		if ($sort)
		{
			$sorts = explode(',', $sort);
			$orders = explode(',', $order);
			for ($i = 0; $i < count($sorts); $i ++)
			{
				if ($orders[$i] == 'asc')
				{
					$temp = EMongoCriteria::SORT_ASC;
				}
				else
				{
					$temp = EMongoCriteria::SORT_DESC;
				}
				$new_sort[$sorts[$i]] = $temp;
			}
		}
		$offset = ($page - 1) * $rows;
		$result = array(
				'offset' => $offset,
				'sort' => $new_sort
		);
		
		if (!$no_page)
		{
			$result['limit'] = $rows;
		}
		return $result;
	}

	/**
	 * 从cursor游标得到数组
	 * 同时获取该记录的操作者
	 */
	public static function getRowsFromCursor($cursor)
	{
		$rows = array();
		$cursor->next();
		while ($row = $cursor->current())
		{
			$rows[] = $row->attributes;
			$cursor->next();
		}
		
		return $rows;
	}

	/**
	 * 组合easyui datagrid json数据
	 * 当参数里面不包含数量时
	 */
	public static function composeDatagridData($rows, $total = "", $more = "")
	{
		$result = array();
		if ($total === "")
		{
			$result = $rows;
		}
		else
		{
			$result['rows'] = $rows;
			$result['total'] = $total;
			$result['more'] = $more;
			if (is_array($more) && isset($more['footer']))
			{
				$result['footer'] = $more['footer'];
			}
		}

		return json_encode($result);
	}

	/**
	 * 根据$response 返回 json
	 */
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
		exit();
	}

	/**
	 * 数据返回标准格式
	 *
	 * @param int $code 0 代表成功；其他值代表各类错误编码
	 * @param string $msg 出错信息
	 * @param unknown_type $data 返回的数据部分
	 */
	public static function formatReturn($code = 0, $message = '', $data = array())
	{
		if ($code == 0)
		{
			if ($message == "")
			{
				$message = '操作成功';
			}
		}
		else
		{
			if ($message == '')
			{
				$message = '操作失败';
			}
		}
		
		$res = array(
				'code' => $code,
				'msg' => $message,
				'data' => $data
		);
		
		$debug = Yii::app()->request->getParam('debug');
		if ($debug !== null)
		{
			$res['exec_time'] = Yii::getLogger()->getExecutionTime();
		}
		
		echo json_encode($res);
		Yii::app()->end();
	}
	
	/**
	 * 标准返回错误码 和 错误信息 
	 * @param int $code
	 * @param string $message
	 * @return array( 'code' => $code, 'msg' => $message);
	 */
	public static function errCodeMsg($code = 0, $message = '', $data = array())
	{
		if ($code == 0)
		{
			if ($message == "")
			{
				$message = '操作成功';
			}
		}
		else
		{
			if ($message == '')
			{
				$message = '操作失败';
			}
		}
		
		$res = array(
				'code' => $code,
				'msg' => $message,
				'data' => $data
		);
		
		return $res;
	}

	public static function requestIframe($response = true, $message = "", $data = array())
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
		echo "<script>parent.upload_success(" . json_encode($res) . ")</script>";
		exit();
	}

	/**
	 * 将配置数组转为combobox数据列表
	 * $config = array(value1 => 'text1', value2 => 'text2' .
	 *
	 * ..) or array(value1 => array('name' => 'text1') ...);
	 * $specified 指定的初始值
	 * $all 是否添加全部选项
	 * $all_value 全部选项的值
	 */
	public static function getComboboxData($config, $specified = '', $all = true, $all_value = '')
	{
		$data = array();
		if ($all)
		{
			$temp = array(
					'value' => $all_value,
					'text' => '全部'
			);
			if ($specified == $all_value)
			{
				$temp['selected'] = true;
			}
			$data[] = $temp;
		}
		foreach ($config as $k => $v)
		{
			if (is_array($v))
			{
				$name = $v['name'];
			}
			else
			{
				$name = $v;
			}
			$temp = array(
					'value' => $k,
					'text' => $name,
					'attributes' => $v
			);
			if ($specified == $k)
			{
				$temp['selected'] = true;
			}
			$data[] = $temp;
		}
		return $data;
	}

	/**
	 * 将数据库取出的二维数组生成easyui combotree所需要的json数据
	 * params： $datas 数据库取出二维数组, $key 每个item的唯一id, $value 每个item的描述, $level 用来区分组的数据列名
	 * 注意: 改函数只针对特定表类型的二级目录
	 */
	public static function composeCombotreeData($datas, $key, $value, $level)
	{
		$type_list = array();
		$temp_array = array();
		// 按组名重组数组
		foreach ($datas as $k => $v)
		{
			$temp_array[$v[$level]][] = $v;
		}
		foreach ($temp_array as $k => $v)
		{
			$temp_array1 = array(); // 缓存一级目录
			$temp_array1['text'] = $k;
			$temp_array1['children'] = array();
			foreach ($v as $k1 => $v1)
			{
				$temp_array2 = array(); // 缓存二级目录
				$temp_array2['id'] = $v1[$key];
				$temp_array2['text'] = $v1[$value];
				array_push($temp_array1['children'], $temp_array2);
			}
			array_push($type_list, $temp_array1);
		}
		return $type_list;
	}

	public static function composeTreeData($rows, $key = '_id', $value = 'name', $parent = 'parent', $level = 'level')
	{
		$tree_data = array();
		$level_array = array();
		// 按组名重组数组
		$max_level = 0;
		foreach ($rows as $k => $v)
		{
			$level_array[$v[$level]][] = $v;
			if ($max_level < $v[$level])
			{
				$max_level = $v[$level];
			}
		}
		$child_data = array();
		for ($i = $max_level; $i >= 1; $i --)
		{
			$level_data = $level_array[$i];
			foreach ($level_data as $k => $v)
			{
				$v[$key] = (string) $v[$key];
				$v[$parent] = (string) $v[$parent];
				$temp = array(
						'id' => $v[$key],
						'text' => (string) $v[$value],
						'attributes' => $v
				);
				if (isset($child_data[$v[$key]]))
				{
					$temp['children'] = $child_data[$v[$key]];
				}
				else
				{
					$temp['children'] = array();
				}
				if ($i == 1)
				{
					$tree_data[] = $temp;
				}
				else
				{
					$child_data[$v[$parent]][] = $temp;
				}
			}
		}
		return $tree_data;
	}

	/**
	 * 返回指定场景下的选项
	 */
	public static function getScenarioOption($all_option, $scenario = '')
	{
		$options = array();
		foreach ($all_option as $k => $v)
		{
			if ($scenario == '' || (isset($v[$scenario]) && $v[$scenario]))
			{
				$options[$k] = $v;
			}
		}
		return $options;
	}

	/**
	 * 将unicode转化为utf-8编码
	 */
	public static function unescape($str)
	{
		$str = rawurldecode($str);
		preg_match_all("/(?:%u.{4})|&#x.{4};|&#\d+;|.+/U", $str, $r);
		$ar = $r[0];
		// print_r($ar);
		foreach ($ar as $k => $v)
		{
			if (substr($v, 0, 2) == "%u")
				$ar[$k] = iconv("UCS-2", "UTF-8", pack("H4", substr($v, - 4)));
			elseif (substr($v, 0, 3) == "&#x")
				$ar[$k] = iconv("UCS-2", "UTF-8", pack("H4", substr($v, 3, - 1)));
			elseif (substr($v, 0, 2) == "&#")
			{
				// echo substr($v,2,-1)."\n";
				$ar[$k] = iconv("UCS-2", "UTF-8", pack("n", substr($v, 2, - 1)));
			}
		}
		return join("", $ar);
	}

	public static function get_val_if_isset($var, $key, $defaul_val = '')
	{
		return (isset($var) && isset($var[$key])) ? $var[$key] : $defaul_val;
	}

	public static function parse_break($str)
	{
		return str_replace("\r\n", "\n", $str);
	}

	public static $site_config = array(
			"village_status" => array(
					1 => '正常',
					0 => '未激活',
					- 1 => '小区被拆迁',
					- 2 => '抓取的错误数据',
					- 3 => '小区将要被拆分',
					- 4 => '合并的小区'
			),
			"village_active_status" => array(
					1 => '激活',
					0 => '未激活'
			)
	);

	public static $empty = array();

	/**
	 * 简单获取远程文件数据
	 *
	 * curl方式获取远程文件信息
	 * @param string $url 要获取的网址
	 * @return string 获取的链接内容
	 */
	public static function simple_http($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, Yii::app()->params['curl_connection_timeout']);// 发起连接前等待的时间
        curl_setopt($ch, CURLOPT_TIMEOUT, Yii::app()->params['curl_timeout']);// 执行时间
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
		$res = curl_exec($ch);
		curl_close($ch);
		return $res;
	}

	/**
	 * 将对象转换为数组，同时将期中的MongoId转为字符串
	 */
	public static function objToArray($object)
	{
		$row = array();
		foreach ($object as $k => $v)
		{
			if (is_array($v) && !empty($v))
			{
				$row[$k] = self::objToArray($v);
			}
			else
			{
				if (is_a($v, 'MongoId'))
				{
					$row[$k] = (string) $v;
				}
				else
				{
					$row[$k] = (NULL === $v) ? '' : $v;
				}
			}
		}
		
		return $row;
	}

	/**
	 * 是否是mongoid
	 * 当前驱动不支持判断mongoid，先自定义
	 */
	public static function isMongoId($char)
	{
		if (method_exists(new MongoId(), 'isValid'))
		{
			return MongoId::isValid($char);
		}
		else
		{
			return ! preg_match('/[\x80-\xff]./', $char) && strlen($char) == 24;
		}
	}
	
	
	/**
	 * 修正网址
	 *
	 * 如果网址中没有http://前缀，则自动加上
	 * @param $url string 网址
	 * @return string 修正后的网址
	 */
	public static function fixUrl($url)
	{
		$prefix = "http://";
		if (stripos($url, $prefix) === false)
		{
			$url = $prefix . $url;
		}
		return $url;
	}
	
	
	/**
	 * 格式化数组
	 * 
	 * @param array $array
	 * @param string $keyField
	 * @param string/array $valueField
	 * @return array
	 */
	public static function arrayFormat($array, $keyField = null, $valueField = null)
	{
		$newArray = array();
		
		foreach ($array as $key => $value)
		{
			$index = !is_null($keyField) ? $value[$keyField] : $key;
			
			// 兼容MongoId做key
			if (is_a($index, 'MongoId'))
			{
				$index = (string)$index;
			}
				
			if (is_null($valueField))
			{
				$newArray[$index] = $value;
			}
			elseif (is_array($valueField))
			{
				foreach ($valueField as $valueKey => $valueItem)
				{
					$newArray[$index][$valueItem] = $value[$valueItem];
				}
			}
			else
			{
				$newArray[$index] = $value[$valueField];
			}
		}

		return $newArray;
	}
	
	
	/**
	 * 获取参数
	 * @param string $param 参数名
	 * @param int $default 默认值
	 * 
	 * @return fixed
	 */
	public static function getParam($param, $default = '')
	{
		return Yii::app()->request->getParam($param, $default);
	}
	
	
	/**
	 * 获取整形参数
	 * @param string $param 参数名
	 * @param int $default 默认值
	 * 
	 * @return int
	 */
	public static function getIntval($param, $default = 0)
	{
		return intval(Yii::app()->request->getParam($param, $default));
	}
	
	
	/**
	 * 获取字符型参数
	 * @param string $param 参数名
	 * @param string $default 默认值
	 */
	public static function getTrim($param, $default = '')
	{
		return trim(strip_tags(Yii::app()->request->getParam($param, $default)));
	}
	
	
	/**
	 * 获取浮点型参数
	 * @param string $param 参数名
	 * @param string $default 默认值
	 */
	public static function getFloat($param, $default = '')
	{
		return floatval(Yii::app()->request->getParam($param, $default));
	}
	
	
	/**
	 * post
	 * @param $url string http地址
	 * @param $post_data mix array or string 
	 * @return string
	 */
	public static function simple_http_post($url, $post_data) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, Yii::app()->params['curl_connection_timeout']);// 发起连接前等待的时间
        curl_setopt($ch, CURLOPT_TIMEOUT, Yii::app()->params['curl_timeout']);// 执行时间
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	


	/**
	 * 比较时间字符串的大小
	 *
	 * @param string $time_str_a 时间字符串
	 * @param string $time_str_b 时间字符串
	 * @return int > 返回 1，< 返回 -1，== 返回 0
	 */
	public static function compareStringHour( $time_str_a, $time_str_b )
	{
		$timeA = self::_splitStringHour($time_str_a);
		$timeB = self::_splitStringHour($time_str_b);
	
		if ($timeA['hour'] != $timeB['hour'])
		{
			return ($timeA['hour'] > $timeB['hour']) ? 1 : -1;
		}
	
		if ($timeA['minute'] != $timeB['minute'])
		{
			return ($timeA['minute'] > $timeB['minute']) ? 1 : -1;
		}
	
		if ($timeA['second'] != $timeB['second'])
		{
			return ($timeA['second'] > $timeB['second']) ? 1 : -1;
		}
	
		return 0;
	}
	
	/**
	 * 拆分时间字符串。
	 *
	 * @param string $time_str 时间字符串(H:m:s)
	 * @return array 时间数组
	 */
	private static function _splitStringHour( $time_str )
	{
		$temp = split(':', $time_str);
	
		$data = array();
		$data['hour'] = isset($temp[0]) ? (int)$temp[0] : 0;
		$data['minute'] = isset($temp[1]) ? (int)$temp[1] : 0;
		$data['second'] = isset($temp[2]) ? (int)$temp[2] : 0;
	
		return $data;
	}

    public  static  function getMongoCollection($dbName,$dbTable){
        $mongo_config = Yii::app()->params['remote_mongodb_delivery'];
        $dbConnection = new MongoClient($mongo_config);
        $db = $dbConnection->selectDB($dbName);
        $userColl = $db->selectCollection($dbTable);
        return $userColl;
    }



}
