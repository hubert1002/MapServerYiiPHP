# coding=utf-8
__author__ = 'yongjunwen'
import re
import sqlite3
# ------------------------------------------标准地址录入数据库-------------------------------------

# ------------------------------------------数据库的初始化-------------------------------------

reg_yulan_1A = '玉兰香苑.*一期A|.*益江路286弄'
reg_yulan_1B = '玉兰香苑.*一期B|.*益江路126弄'
reg_yulan_2A = '玉兰香苑.*二期A|.*益江路511弄'
reg_yulan_2B = '玉兰香苑.*二期B|.*益江516弄'
reg_yulan_2C = '玉兰香苑.*二期C|.*益江路396弄'
reg_yulan_3 = '玉兰香苑.*三期|.*盛夏路1107弄'
reg_yulan_4 = '玉兰香苑.*四期|.*张东路2281弄'
# 益丰
reg_yifengxincun = '益丰新村.*|.*益江路299弄'
#樟盛苑
reg_zhangshengyuan = '樟盛苑.*|.*盛夏路738弄'
#==============================证大==============================
reg_zhengda_yiqi = '证大家园.*一期'
reg_zhengda_erqi = '证大家园.*二期'
reg_zhengda_sanqi = '证大家园.*三期'
reg_zhengda_siqi = '证大家园.*四期'
reg_zhengda_wuqi = '证大家园.*五期'
reg_shuangqiaoxiaoqu_1 = '双桥小区.*180'
reg_shuangqiaoxiaoqu_2 = '双桥小区.*220'
reg_shuangqiaoxiaoqu_3 = '双桥小区.*218'
reg_dongluxincun_1 = '东陆新村.*420'
reg_dongluxincun_2 = '东陆新村.*354'
reg_dongluxincun_3 = '东陆新村.*三街坊'
reg_dongluxincun_4 = '东陆新村.*四街坊'
reg_dongluxincun_5 = '东陆新村.*五街坊'
reg_dongluxincun_6 = '东陆新村.*六街坊-巨峰路90弄'
reg_dongluxincun_7 = '东陆新村.*六街坊-巨峰路176弄'
reg_dongluxincun_8 = '东陆新村.*七街坊-五莲路1424弄'
reg_dongluxincun_9 = '东陆新村.*七街坊-博兴路1663弄'
reg_anjuyuan_1 = '安居苑.*八街坊'
reg_anjuyuan_2 = '安居苑.*九街坊'
reg_puqinyuan = '浦沁苑.*'
reg_jufengjiayuan_1 = '巨峰家苑.*巨峰路758弄'
reg_jufengjiayuan_2 = '巨峰家苑.*巨峰路1768弄'
reg_jinqiaoyifang = '金桥一方雅苑.*'

#==============================大唐==============================
reg_huamuxinfengyuan = '花木鑫丰苑.*469|.*樱花路469弄'
reg_ruidaxinyuan = '瑞达新苑.*515|.*樱花路515弄'
reg_huanlongxinjiyuan = '环龙新纪园.*360|.*白杨路360弄'
reg_shijihuayuan_1 = '世纪花园一期.*100|.*银霄路100弄'
reg_shijihuayuan_2 = '世纪花园二期.*39|.*银霄路39弄'
reg_datangshengshihuayuan_1 = '大唐盛世花园一期.*199|.*白杨路199弄'
reg_datangshengshihuayuan_2 = '大唐盛世花园二期.*801|.*樱花路801弄'
reg_datangguojigongyu = '大唐国际公寓|.*银霄路280号、樱花路802弄'
reg_jianhuazuanshigongyu = '建华钻石公寓|.*海桐路336弄'
reg_jianhuagongyu = '建华公寓'
reg_lvyuangongyu = '绿缘公寓'
reg_jinguixiaoqu_1 = '金桂小区.*258|.*牡丹路258弄'
reg_jinguixiaoqu_2 = '金桂小区.*340|.*牡丹路340弄'
reg_mudanluxiaoqu_1 = '牡丹路225弄小区|.*牡丹路225弄'
reg_mudanluxiaoqu_2 = '牡丹路259弄小区|.*牡丹路259弄'
reg_lijingboyuan = '丽晶博苑|.*花木路826弄'
reg_haitongyuan_1 = '海桐苑|.*海桐路73弄'
reg_haitongyuan_2 = '海桐苑|.*海桐路61弄'
reg_haitongyuan_3 = '海桐苑|.*海桐路68弄'
reg_yongjingtaigongyu = '雍景台公寓|.*花木路862-912号'
reg_sijiquanjingtai = '四季全景台|.*花木路916弄'
reg_jianhuaxinyuan = '建华新苑|.*梅花路777弄'
reg_yinhuafang = '樱花坊|.*牡丹路418弄'
reg_liujiefangxiaoqu = '六街坊小区|.*梅花路768弄'

deliveryArr = []

cx = sqlite3.connect("deliveryAddress.db")  # 建立数据库连接
cu = cx.cursor()  # 获取sql光标

# ------------------------------------------开始正则匹配-------------------------------------

def regex_line(name, address, buildNum):
    temp_buildNumber = 0
    if buildNum.isdigit():
        temp_buildNumber = int(buildNum)
    else:
        find_result = re.findall(r'\d+', buildNum)
        if len(find_result) == 0:
            return -1
        temp_buildNumber = int(find_result[-1])

    line = name + address

    if re.search(reg_yulan_1A, line):
        name = '玉兰香苑'
        address = '一期A组团'
    elif re.search(reg_yulan_1B, line):
        name = '玉兰香苑'
        address = '一期B块'
    elif re.search(reg_yulan_2A, line):
        name = '玉兰香苑'
        address = '二期A块'

    elif re.search(reg_yulan_2B, line):
        name = '玉兰香苑'
        address = '二期B块'

    elif re.search(reg_yulan_2C, line):
        name = '玉兰香苑'
        address = '二期C块'

    elif re.search(reg_yulan_3, line):
        name = '玉兰香苑'
        address = '三期'
    elif re.search(reg_yulan_4, line):
        name = '玉兰香苑'
        address = '四期'
    elif re.search(reg_yifengxincun, line):
        name = '益丰新村'
        address = '益江路299弄'
    elif re.search(reg_zhangshengyuan, line):
        name = '樟盛苑'
        address = '盛夏路738弄'

    #===============证大正则匹配===============

    elif re.search(reg_zhengda_yiqi, line):
        name = '证大家园'
        address = '一期'
    elif re.search(reg_zhengda_erqi, line):
        name = '证大家园'
        address = '二期'
    elif re.search(reg_zhengda_sanqi, line):
        name = '证大家园'
        address = '三期'
    elif re.search(reg_zhengda_siqi, line):
        name = '证大家园'
        address = '四期'
    elif re.search(reg_zhengda_wuqi, line):
        name = '证大家园'
        address = '五期'
    elif re.search(reg_shuangqiaoxiaoqu_1, line):
        name = '双桥小区'
        address = '双桥路180弄'
    elif re.search(reg_shuangqiaoxiaoqu_2, line):
        name = '双桥小区'
        address = '双桥路220弄'
    elif re.search(reg_shuangqiaoxiaoqu_3, line):
        name = '双桥小区'
        address = '双桥路218弄'
    elif re.search(reg_dongluxincun_1, line):
        name = '东陆新村'
        address = '二街坊-凌河路420弄'
    elif re.search(reg_dongluxincun_2, line):
        name = '东陆新村'
        address = '二街坊-凌河路354弄'
    elif re.search(reg_dongluxincun_3, line):
        name = '东陆新村'
        address = '三街坊'
    elif re.search(reg_dongluxincun_4, line):
        name = '东陆新村'
        address = '四街坊'
    elif re.search(reg_dongluxincun_5, line):
        name = '东陆新村'
        address = '五街坊'
    elif re.search(reg_dongluxincun_6, line):
        name = '东陆新村'
        address = '六街坊-巨峰路90弄'
    elif re.search(reg_dongluxincun_7, line):
        name = '东陆新村'
        address = '六街坊-巨峰路176弄'
    elif re.search(reg_dongluxincun_8, line):
        name = '东陆新村'
        address = '七街坊-五莲路1424弄'
    elif re.search(reg_dongluxincun_9, line):
        name = '东陆新村'
        address = '七街坊-博兴路1663弄'
    elif re.search(reg_anjuyuan_1, line):
        name = '安居苑'
        address = '七街坊-博兴路1663弄'
    elif re.search(reg_anjuyuan_2, line):
        name = '安居苑'
        address = '八街坊'
    elif re.search(reg_dongluxincun_9, line):
        name = '安居苑'
        address = '九街坊'
    elif re.search(reg_puqinyuan, line):
        name = '浦沁苑'
        address = ''
    elif re.search(reg_jufengjiayuan_1, line):
        name = '巨峰家苑'
        address = '巨峰路758弄'
    elif re.search(reg_jufengjiayuan_2, line):
        name = '巨峰家苑'
        address = '博兴路1768弄'
    elif re.search(reg_jinqiaoyifang, line):
        name = '金桥一方雅苑'
        address = ''

    #===============大唐正则匹配===============
    elif re.search(reg_huamuxinfengyuan, line):
        name = '花木鑫丰苑'
        address = '樱花路469弄1-34号'
    elif re.search(reg_ruidaxinyuan, line):
        name = '瑞达新苑'
        address = '樱花路515弄1-9号'
    elif re.search(reg_huanlongxinjiyuan, line):
        name = '环龙新纪园'
        address = '白杨路360弄'
    elif re.search(reg_shijihuayuan_1, line):
        name = '世纪花园一期'
        address = '银霄路100弄'
    elif re.search(reg_shijihuayuan_2, line):
        name = '世纪花园二期'
        address = '银霄路39弄'
    elif re.search(reg_datangshengshihuayuan_1, line):
        name = '大唐盛世花园一期'
        address = '白杨路199弄1-30号'
    elif re.search(reg_datangshengshihuayuan_2, line):
        name = '大唐盛世花园二期'
        address = '樱花路801弄1-29号'
    elif re.search(reg_datangguojigongyu, line):
        name = '大唐国际公寓'
        address = '银霄路280号、樱花路802弄'
    elif re.search(reg_jianhuazuanshigongyu, line):
        name = '建华钻石公寓'
        address = '海桐路336弄'

    elif re.search(reg_jianhuagongyu, line):
        name = '建华公寓'
        address = '花木路718弄'
    elif re.search(reg_lvyuangongyu, line):
        name = '绿缘公寓'
        address = '花木路718弄'
    elif re.search(reg_jinguixiaoqu_1, line):
        name = '金桂小区'
        address = '牡丹路258弄'
    elif re.search(reg_jinguixiaoqu_2, line):
        name = '金桂小区'
        address = '牡丹路340弄'
    elif re.search(reg_mudanluxiaoqu_1, line):
        name = '牡丹路259弄小区'
        address = '牡丹路225弄'
    elif re.search(reg_mudanluxiaoqu_2, line):
        name = '牡丹路259弄小区'
        address = '牡丹路259弄'

    elif re.search(reg_lijingboyuan, line):
        name = '丽晶博苑'
        address = '花木路826弄'
    elif re.search(reg_haitongyuan_1, line):
        name = '海桐苑'
        address = '海桐路73弄1-24号'
    elif re.search(reg_haitongyuan_2, line):
        name = '海桐苑'
        address = '海桐路61弄1-22号'
    elif re.search(reg_haitongyuan_3, line):
        name = '海桐苑'
        address = '海桐路68弄1-47号'
    elif re.search(reg_yongjingtaigongyu, line):
        name = '雍景台公寓'
        address = '花木路862-912号'
    elif re.search(reg_sijiquanjingtai, line):
        name = '四季全景台'
        address = '花木路916弄1-4号'
    elif re.search(reg_jianhuaxinyuan, line):
        name = '建华新苑'
        address = '梅花路777弄1-18号'
    elif re.search(reg_yinhuafang, line):
        name = '樱花坊'
        address = '牡丹路418弄1-24号'
    elif re.search(reg_liujiefangxiaoqu, line):
        name = '六街坊小区'
        address = '梅花路768弄1-30号'
    else:
        return -1

    print name, address, temp_buildNumber
    cu.execute(
        "select id from StandardAddress where (name='%s' and address='%s' and build_number='%d')"
        % (name, address, temp_buildNumber))
    exe_all = cu.fetchall()
    print exe_all
    if len(exe_all) == 0:
        return -1
    exe_id = exe_all[0][0]
    print "id =", exe_id
    return exe_id


def get_all_address(name, address, buildNum):
    exe_id = regex_line(name, address, buildNum)
    if exe_id == -1:
        return exe_id
    else:
        cu.execute(
            "select * from StandardAddress where id= '%s'" % exe_id)
    exe_all = cu.fetchall()
    tuple_arr = exe_all[0]
    print exe_all
    addressDict = {"match_id":tuple_arr[0],"name":tuple_arr[1],"address":tuple_arr[2],"build_number":tuple_arr[3]}
    return addressDict

if __name__ == '__main__':
    if regex_line('222樟盛苑', 'ddd盛夏路738弄222', '11ww') == -1:
        print '======sorry，没有查询到所归属的标准地址======='
    else:
        print '匹配上了'