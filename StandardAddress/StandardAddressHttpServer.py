# encoding=utf-8
import json

__author__ = 'yongjunwen'
from read_standardAddress_id import regex_line, get_all_address

'''
#本地访问
http://localhost:8000/getStandardAddressId?buildNumber=1ww&name=222樟盛苑&address=ddd盛夏路738弄222
http://127.0.0.1:8000/getStandardAddressId?buildNumber=1ww&name=222樟盛苑&address=ddd盛夏路738弄222

#可以通过ip地址加端口访问
http://10.192.248.125:8000/getStandardAddressId?buildNumber=1ww&name=222樟盛苑&address=ddd盛夏路738弄222
基于BaseHTTPServer的http server实现，包括get，post方法，get参数接收，post参数接收。

#叮咚地图服务器
http://10.192.10.155:8000/getStandardAddressId?buildNumber=1ww&name=222樟盛苑&address=ddd盛夏路738弄222
'''
from BaseHTTPServer import BaseHTTPRequestHandler, HTTPServer
import io, shutil
import urllib, time
import getopt, string


class MyRequestHandler(BaseHTTPRequestHandler):
    def do_GET(self):
        self.process(2)

    def do_POST(self):
        self.process(1)

    def process(self, type):

        content = ""
        if type == 1:  # post方法，接收post参数
            datas = self.rfile.read(int(self.headers['content-length']))
            datas = urllib.unquote(datas).decode("utf-8", 'ignore')  # 指定编码方式
            datas = transDicts(datas)  # 将参数转换为字典
            print 'post参数数据：', datas
            if datas.has_key('data'):
                content = "data:" + datas['data'] + "\r\n"

        if '?' in self.path:
            query = urllib.splitquery(self.path)
            action = query[0]
            action = action.replace('/', '')
            if action == 'getStandardAddressId':
                # print self.path, query[1], query[1].split('&')
                paraDict = transDicts(query[1])
                # print 'processDict:', paraDict,
                # print 'name:', paraDict['name']
                exe_id = regex_line(paraDict['name'], paraDict['address'], paraDict['buildNumber'])

                print "exe_id=", exe_id

                retResult = -1
                if exe_id > 0:
                    retResult = 1

                retDict = {"success": retResult, "msg": "", "data": {"match_id": exe_id}}
                retDict = json.dumps(retDict)
                # 指定返回编码
                enc = "UTF-8"
                # content = content.encode(enc)
                f = io.BytesIO()
                content = str(retDict)
                f.write(content)
                f.seek(0)
                self.send_response(200)
                self.send_header("Content-type", "text/html; charset=%s" % enc)
                self.send_header("Content-Length", str(len(content)))
                self.end_headers()
                shutil.copyfileobj(f, self.wfile)
            elif action == 'getStandardAddress':
                paraDict = transDicts(query[1])
                # print 'processDict:', paraDict,
                # print 'name:', paraDict['name']
                exe_id = get_all_address(paraDict['name'], paraDict['address'], paraDict['buildNumber'])

                print "exe_id=", exe_id

                retResult = False
                if exe_id > 0:
                    retResult = True

                retDict = {"success": retResult, "msg": "", "data": exe_id}
                retDict = json.dumps(retDict)
                # 指定返回编码
                enc = "UTF-8"
                # content = content.encode(enc)
                f = io.BytesIO()
                content = str(retDict)
                f.write(content)
                f.seek(0)
                self.send_response(200)
                self.send_header("Content-type", "text/html; charset=%s" % enc)
                self.send_header("Content-Length", str(len(content)))
                self.end_headers()
                shutil.copyfileobj(f, self.wfile)


def transDicts(params):
    dicts = {}
    if len(params) == 0:
        return
    params = params.split('&')
    for param in params:
        kv = param.split('=')
        key = urllib.unquote(kv[0])  # urllib.unquote(kv[0]).decode("utf-8", 'ignore').encode("utf-8")#
        value = urllib.unquote(kv[1])  # urllib.unquote(kv[0])decode("utf-8", 'ignore').encode("utf-8")#
        # print 'value=', value
        dicts[str(key)] = str(value)
    return dicts


if __name__ == '__main__':

    try:
        server = HTTPServer(('0.0.0.0', 8000), MyRequestHandler)
        print '====started httpserver==='
        server.serve_forever()

    except KeyboardInterrupt:
        server.socket.close()
        print '====close httpserver==='
    pass