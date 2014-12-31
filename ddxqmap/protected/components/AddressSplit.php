<?php
/**
 * Created by PhpStorm.
 * User: liuwei1
 * Date: 2014/12/25
 * Time: 9:58
 */

class AddressSplit {

    /*
     * 将输入地址进行正则匹配，返回对应标准写法
     */
    public static function splitStandard($name='',$address='',$build_number=''){

        $mod =array();
        //==============================玉兰==============================
        $mod[]=array(
            'split'=>"/益江路.*286(弄|号)?|玉兰香苑.*[一1]期.*A/i",
            'name'=>'玉兰香苑',
            'address'=>'一期A组团'
        );
        $mod[]=array(
            'split'=>"/益江路.*126(弄|号)?|玉兰香苑.*[一1]期.*B/i",
            'name'=>'玉兰香苑',
            'address'=>'一期B块'
        );
        $mod[]=array(
            'split'=>"/益江路.*511(弄|号)?|玉兰香苑.*[二2]期.*A/i",
            'name'=>'玉兰香苑',
            'address'=>'二期A块'
        );
        $mod[]=array(
            'split'=> "/益江路.*516(弄|号)?|玉兰香苑.*[二2]期.*B/i",
            'name'=>'玉兰香苑',
            'address'=>'二期B块'
        );
        $mod[]=array(
            'split'=>  "/益江路.*396(弄|号)?|玉兰香苑.*[二2]期.*C/i",
            'name'=>'玉兰香苑',
            'address'=>'二期C块'
        );
        $mod[]=array(
            'split'=>"/盛夏路.*1107(弄|号)?|玉兰香苑.*[三3]期/i",
            'name'=>'玉兰香苑',
            'address'=>'三期'
        );
        $mod[]=array(
            'split'=>"/张东路.*2281(弄|号)?|玉兰香苑.*[四4]期/i",
            'name'=>'玉兰香苑',
            'address'=>'四期'
        );

        $mod[]=array(
            'split'=>"/益丰新村|益江路.*299(弄|号)?/i",
            'name'=>'益丰新村',
            'address'=>'益江路299弄'
        );

        $mod[]=array(
            'split'=>"/樟盛苑|盛夏路.*738(弄|号)?/i",
            'name'=>'樟盛苑',
            'address'=>'盛夏路738弄'
        );

        //==============================证大==============================
        $mod[]=array(
            'split'=>'/证大家园.*[一1]期/i',
            'name'=>'证大家园',
            'address'=>'一期'
        );
        $mod[]=array(
            'split'=>'/证大家园.*[二2]期/i',
            'name'=>'证大家园',
            'address'=>'二期'
        );
        $mod[]=array(
            'split'=>'/证大家园.*[三3]期/i',
            'name'=>'证大家园',
            'address'=>'三期'
        );
        $mod[]=array(
            'split'=>'/证大家园.*[四4]期/i',
            'name'=>'证大家园',
            'address'=>'四期'
        );
        $mod[]=array(
            'split'=>'/证大家园.*[五5]期/i',
            'name'=>'证大家园',
            'address'=>'五期'
        );
        $mod[]=array(
            'split'=>"/双桥路.*180(弄|号)?|双桥小区.*[一1]期/i",
            'name'=>'双桥小区',
            'address'=>'双桥路180弄'
        );
        $mod[]=array(
            'split'=>"/双桥路.*220(弄|号)?|双桥小区.*[二2]期/i",
            'name'=>'双桥小区',
            'address'=>'双桥路220弄'
        );
        $mod[]=array(
            'split'=>"/双桥路.*218(弄|号)?|双桥小区.*[三3]期/i",
            'name'=>'双桥小区',
            'address'=>'双桥路218弄'
        );
        $mod[]=array(
            'split'=>"/东陆新村.*420(弄|号)?|凌河路.*420(弄|号)?/i",
            'name'=>'东陆新村',
            'address'=>'二街坊-凌河路420弄'
        );
        $mod[]=array(
            'split'=>"/东陆新村.*354(弄|号)?|凌河路.*354(弄|号)?/i",
            'name'=>'东陆新村',
            'address'=>'二街坊-凌河路354弄'
        );
        $mod[]=array(
            'split'=>"/东陆新村.*[三3]街坊/i",
            'name'=>'东陆新村',
            'address'=>'三街坊'
        );
        $mod[]=array(
            'split'=>"/东陆新村.*[四4]街坊/i",
            'name'=>'东陆新村',
            'address'=>'四街坊'
        );
        $mod[]=array(
            'split'=>"/东陆新村.*[五5]街坊/i",
            'name'=>'东陆新村',
            'address'=>'五街坊'
        );
        $mod[]=array(
            'split'=>"/东陆新村.*[六6]街坊-巨峰路90(弄|号)?|巨峰路.*90(弄|号)?/i",
            'name'=>'东陆新村',
            'address'=>'六街坊-巨峰路90弄'
        );
        $mod[]=array(
            'split'=>"/东陆新村.*[六6]街坊-巨峰路176(弄|号)?|巨峰路.*176(弄|号)?/i",
            'name'=>'东陆新村',
            'address'=>'六街坊-巨峰路176弄'
        );
        $mod[]=array(
            'split'=>"/东陆新村.*[七7]街坊-五莲路1424(弄|号)?|五莲路.*1424(弄|号)?/i",
            'name'=>'东陆新村',
            'address'=>'七街坊-五莲路1424弄'
        );
        $mod[]=array(
            'split'=>"/东陆新村.*[七7]街坊-博兴路1663(弄|号)?|博兴路.*1663(弄|号)?/i",
            'name'=>'东陆新村',
            'address'=>'七街坊-博兴路1663弄'
        );
        $mod[]=array(
            'split'=> "/安居苑.*[八8]街坊|博兴路.*1663(弄|号)?/i",
            'name'=>'安居苑',
            'address'=>'八街坊-博兴路1663弄'
        );
        $mod[]=array(
            'split'=>  "/安居苑.*[九9]街坊/i",
            'name'=>'安居苑',
            'address'=>'九街坊'
        );
        $mod[]=array(
            'split'=> '/浦沁苑/',
            'name'=>'浦沁苑',
            'address'=>'浦沁苑'
        );
        $mod[]=array(
            'split'=> '/浦沁苑/',
            'name'=>'浦沁苑',
            'address'=>'浦沁苑'
        );
        $mod[]=array(
            'split'=> '/巨峰家苑/i',
            'name'=>'巨峰家苑',
            'address'=>'巨峰路758弄'
        );
        $mod[]=array(
            'split'=>'/巨峰路.*758(弄|号)?/i',
            'name'=>'巨峰家苑',
            'address'=>'巨峰路758弄'
        );
        $mod[]=array(
            'split'=>'/巨峰路.*1768(弄|号)?/i',
            'name'=>'巨峰家苑',
            'address'=>'巨峰路1768弄'
        );
        $mod[]=array(
            'split'=>'/金桥一方雅苑/i',
            'name'=>'金桥一方雅苑',
            'address'=>'金桥一方雅苑'
        );

        //==============================证大==============================

        $mod[]=array(
            'split'=> '/花木鑫丰苑|樱花路.*469(弄|号)?/i',
            'name'=>'花木鑫丰苑',
            'address'=>'樱花路469弄'
        );

        $mod[]=array(
            'split'=> '/瑞达新苑|樱花路.*515(弄|号)?/i',
            'name'=>'瑞达新苑',
            'address'=>'樱花路515弄'
        );


        $mod[]=array(
            'split'=> '/环龙新纪园|白杨路.*360(弄|号)?/i',
            'name'=>'环龙新纪园',
            'address'=>'白杨路360弄'
        );

        $mod[]=array(
            'split'=>"/银霄路.*100(弄|号)?|世纪花园.*[一1]期/i",
            'name'=>'世纪花园',
            'address'=>'一期'
        );
        $mod[]=array(
            'split'=>"/银霄路.*39(弄|号)?|世纪花园.*[二2]期/i",
            'name'=>'世纪花园',
            'address'=>'二期'
        );
        $mod[]=array(
            'split'=>"/白杨路.*199(弄|号)?|大唐盛世花园.*[一1]期/i",
            'name'=>'大唐盛世花园',
            'address'=>'一期'
        );
        $mod[]=array(
            'split'=>"/白杨路.*801(弄|号)?|大唐盛世花园.*[二2]期/i",
            'name'=>'大唐盛世花园',
            'address'=>'二期'
        );
        $mod[]=array(
            'split'=>"/樱花路.*802(弄|号)?|银霄路.*280(弄|号)?|大唐国际公寓/i",
            'name'=>'大唐国际公寓',
            'address'=>'银霄路280号、樱花路802弄'
        );
        $mod[]=array(
            'split'=>"/建华钻石公寓|海桐路.*336(弄|号)?/i",
            'name'=>'建华钻石公寓',
            'address'=>'海桐路336弄'
        );
        $mod[]=array(
            'split'=>"/建华公寓/i",
            'name'=>'建华公寓',
            'address'=>'花木路718弄'
        );
        $mod[]=array(
            'split'=>"/绿缘公寓/i",
            'name'=>'绿缘公寓',
            'address'=>'花木路718弄'
        );
        $mod[]=array(
            'split'=>"/金桂小区.*258|牡丹路.*258(弄|号)?/i",
            'name'=>'金桂小区',
            'address'=>'牡丹路258弄'
        );
        $mod[]=array(
            'split'=>"/金桂小区.*340|牡丹路.*340(弄|号)?/i",
            'name'=>'金桂小区',
            'address'=>'牡丹路340弄'
        );
        $mod[]=array(
            'split'=>'/牡丹路225弄/i',
            'name'=>'牡丹路225弄小区',
            'address'=>'牡丹路225弄'
        );
        $mod[]=array(
            'split'=>'/牡丹路295弄/i',
            'name'=>'牡丹路259弄小区',
            'address'=>'牡丹路259弄'
        );
        $mod[]=array(
            'split'=>'/丽晶博苑|花木路.*826(弄|号)?/i',
            'name'=>'丽晶博苑',
            'address'=>'花木路826弄'
        );
        $mod[]=array(
            'split'=>'/海桐路.*73(弄|号)?/i',
            'name'=>'海桐路',
            'address'=>'海桐路73弄'
        );
        $mod[]=array(
            'split'=>'/海桐路.*61(弄|号)?/i',
            'name'=>'海桐路',
            'address'=>'海桐路61弄'
        );
        $mod[]=array(
            'split'=>'/海桐路.*68(弄|号)?/i',
            'name'=>'海桐路',
            'address'=>'海桐路68弄'
        );
        $mod[]=array(
            'split'=>"/雍景台公寓|花木路.*(86[2-9]|[8-9][0-9][0-9]|91[0-2])(弄|号)/i",
            'name'=>'雍景台公寓',
            'address'=>'花木路862-912号'
        );
        $mod[]=array(
            'split'=>'/四季全景台|花木路.*916(弄|号)?/i',
            'name'=>'四季全景台',
            'address'=>'花木路916弄'
        );
        $mod[]=array(
            'split'=>'/建华新苑|梅花路.*777(弄|号)?/i',
            'name'=>'建华新苑',
            'address'=>'梅花路777弄'
        );
        $mod[]=array(
            'split'=>'/樱花坊|牡丹路.*418(弄|号)?/i',
            'name'=>'樱花坊',
            'address'=>'牡丹路418弄'
        );
        $mod[]=array(
            'split'=>'/六街坊小区|梅花路.*768(弄|号)?/i',
            'name'=>'六街坊小区',
            'address'=>'梅花路768弄'
        );


        $final_name ='';
        $final_address ='';
        $final_build_number ='';

       $location =self::trimAll($name.$address);
        if(empty($address)){
            //一整串地址
            //进行小区名和地址的匹配，并得到楼号的字串字符
            $sub ='';
            foreach($mod as $row){
                if (preg_match ($row['split'], $location,$match))
                {
                    $final_name=$row['name'];
                    $final_address=$row['address'];
                    $sub =$match[0];
                    break;
                }
            }
            if(!empty($sub)){
                $sub = substr($name,strlen($sub));
                if (preg_match ('/\d+号/', $sub,$num))
                {
                    $build_number =$num[0];
                }
            }
            //解析楼号
            $list = preg_split ("/号/", $build_number);
            if(!empty($list)&&!empty($list[0])&&is_numeric($list[0])){
                $final_build_number=$list[0];
            }
        }else{
            //三部分组成的地址
            //进行小区名和地址的匹配
            foreach($mod as $row){
                if (preg_match ($row['split'], $location))
                {
                    $final_name=$row['name'];
                    $final_address=$row['address'];
                    break;
                }
            }
            //解析楼号
            if (preg_match ('/\d+号/', $build_number,$num))
            {
                $build_number =$num[0];
            }
            $list = preg_split ("/号/", $build_number);
            if(!empty($list)&&!empty($list[0])&&is_numeric($list[0])){
                $final_build_number=$list[0];
            }
        }


        $data =array(
            'name'=>$final_name,
            'address'=>$final_address,
            'build_number'=>$final_build_number,
        );
        return $data;

    }

    /*
     * 删除空格符号（只有，。）
     */
   public static  function trimAll($str)
    {
        $replace=array(" ","　","\t","\n","\r",',','.','，','。');$space=array("");
        return str_replace($replace,$space,$str);
    }

} 