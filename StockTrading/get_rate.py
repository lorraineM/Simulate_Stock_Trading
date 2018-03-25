# -*- encoding:utf-8 -*-
# Author :  Zhang Xuewen
# Function: 每日 24:00 爬虫各币种利率、汇率, 进行利息积数计算
#           6.31 24:00 采用多线程进行结息计算
#           当脚本出错时发送邮件通知管理员
# Remark:        0 人民币  1 美元  2 港币      3 欧元      4 英镑
#                5 日元    6 澳元  7 加拿大元  8 瑞士法郎  9 新加坡元
# crawler order: 0 人民币  1 澳元  2 港币      3 加拿大元  4 美元
#                5 欧元    6 日元  7 瑞士法郎  8 新加坡元  9 英镑
# Method:   每日计算利息积数
#           结息时： 利息 = 利息积数 * 相应日利率 / 360 + 利息
#                    本金 = 本金 + 利息整数部分
#                    利息 = 利息 + 利息小数部分
# Versuon   1.0


import urllib2
import time
import datetime
import MySQLdb
import smtplib
import threading
from email.mime.text import MIMEText

conn = None       # 数据库
cur = None        # 数据库游标

currency_order = [0,6,2,7,1,3,5,8,9,4]     # 数据库币种的顺序,用于转换爬虫下来的顺序
crawler_oder = [0,4,2,5,9,6,1,3,7,8]       # 数据库币种顺序对应的爬虫顺序

# 发送邮箱设置参数
mailto_list = ['blue.snow013@163.com',]    # 要发送的邮箱
mail_host = 'smtp.163.com'                 # 邮箱服务器
mail_from = 'cprices@163.com'              # 发送邮箱
mail_pass = 'compare&see'                  # 发送邮箱密码


class UpdateThread(threading.Thread):
    """ 结息线程 """
    def __init__(self, fids):
        self.fids = fids                  # 该线程需计算的账户
        threading.Thread.__init__(self)   # 初始化线程

    def run(self):
        cal_interest(self.fids)         # 结息


def opendb():
    """ 打开数据库 """
    try:
        global conn                 # 声明使用全局变量
        global cur
        conn = MySQLdb.connect(host='localhost',user='trader',
                passwd='programmer',db='StockTrading',port=3306)   # 打开数据库连接
        cur = conn.cursor()         # 获得数据库游标
    except MySQLdb.Error, e:
        msg = u'Mysql Error ' + str(e.args[0]) + ': ' + str(e.args[1])   # 错误信息
        send_email(msg)            # 发送邮件通知


def closedb():
    """ 关闭数据库 """
    try:
        cur.close()         # 关闭数据库
        conn.close()
    except MySQLdb.Error, e:
        msg = u'Mysql Error ' + str(e.args[0]) + ': ' + str(e.args[1])   # 错误信息
        send_email(msg)            # 发送邮件通知


def send_email(content):
    """ 当脚本出错,发送邮件通知 """
    msg = MIMEText(content, _subtype='plain', _charset='utf-8')     # 设置邮件正文
    msg['Subject'] = u'StockTrading Script Error'  # 设置邮件主题
    msg['From'] = mail_from                        # 设置邮件发送方
    msg['To'] = ';'.join(mailto_list)              # 设置邮件收信方
    try:
        server = smtplib.SMTP()                    # 邮件服务器
        server.connect(mail_host)                  # 连接邮件服务器
        server.login(mail_from, mail_pass)         # 登录邮件服务器
        server.sendmail(mail_from, mailto_list, msg.as_string())    # 发送邮件
        server.close()                             # 关闭邮件服务器
    except Exception, e:
        print str(e)


def get_rate():
    """ 爬虫得到各币种的汇率,利率 """
    try:
        url = 'http://www.bankrate.com.cn/rate/bank/4'      # 中国银行活期利率查询
        html = urllib2.urlopen(url).read()               # 打开网页
        pos1 = 0
        irates = []
        for num in range(0,10):                        # 根据html爬虫利率
            pos1 = html.find('<td',pos1+1)
            pos1 = html.find('活期',pos1+1)
            pos2 = html.find('%',pos1)
            irate = html[pos1+9:pos2].strip()                # 得到利率
            irates.append(float(irate))
        update_rate(0, irates[crawler_oder[num-1]], 1)       # 更新人民币，汇率为1
        for num in range(2,11):
            url = 'http://www.yinhang.com/Exchange/' + str(num) + '_1'   # 各币种对应的汇率网页
            html = urllib2.urlopen(url).read()               # 打开网页
            pos1 = html.find('现汇')
            for cycle in range(0,4):                         # 根据html爬虫汇率
                pos1 = html.find('<td>', pos1+4)
            pos2 = html.find('</td>', pos1)
            erate = html[pos1+4:pos2].strip()                # 得到汇率
            erate = float(erate)/100                             # 转换为浮点数
            update_rate(currency_order[num-1], irates[crawler_oder[num-1]], erate)   # 数据库中更新汇率,利率
    except Exception, e:
        print str(e)
        send_email('get_rate(): '+str(e))            # 发送邮件通知


def update_rate(num, irate, erate):
    """ 数据库更新币种的汇率,利率 """
    try:
        result = cur.execute('select * from rate where currency=' + str(num)) # 选择语句
        if result != 0:           # 判断该币种是否已被插入
             sql = "update rate set interest_rate=%f, exchange_rate=%f where currency=%d" \
                  % (irate, erate, num)    # 更新语句
        else:
             sql = "insert into rate (currency, interest_rate, exchange_rate) values (%d, %f, %f)" \
                  % (num, irate, erate)    # 插入语句
        cur.execute(sql)               # 执行语句
        conn.commit()                  # 提交到数据库执行
    except Exception, e:
        conn.rollback()               # 发生错误时回滚
        print str(e)
        send_email('update_rate(): '+str(e))            # 发送邮件通知


def cal_product():
    """ 计算利息今日的累积积数 """
    try:
        sql = 'update currency set product=product+amount'
        cur.execute(sql)               # 对所有资金账户的币种进行利息积数累加
        conn.commit()                  # 提交到数据库执行
    except Exception, e:
        conn.rollback()               # 发生错误时回滚
        print str(e)
        send_email('cal_product(): '+str(e))            # 发送邮件通知


def cal_interest(fids):
    """ 结息, 利息合并到本金 """
    try:
        irates = []
        cur.execute('select interest_rate from rate order by currency')  # 得到各币种利率
        rates = cur.fetchall()
        for rate in rates:
            irates.append(rate[0])
        for fid in fids:              # 得到各资金账户的详细币种资金信息
            cur.execute('select product,interest,types from currency where fid='+str(fid))
            results = cur.fetchall()
            for arr in results:
                product = arr[0]               # 得到利息积数
                interest = arr[1]              # 得到利息
                num = arr[2]                   # 得到币种种类
                interest = product*irates[0]*0.01/360 + interest    # 利息=利息积数*利率/360 + 利息
                amount = int(interest)              # 新增的本金元部分保留
                interest = interest - amount             # 角分等部分保留到利息中
                sql = 'update currency set amount=amount+%f, available=available+%f, \
                      interest=%f, product=0 where fid=%ld and types=%d' \
                      %(amount, amount, interest, fid, num)
                cur.execute(sql)                      # 更新本金，可用资金，利息，利息积数
                conn.commit()
    except Exception, e:
        conn.rollback()                   # 发生错误时回滚
        print str(e)
        send_email('cal_interest(): '+str(e))            # 发送邮件通知


if __name__ == '__main__':
    opendb()                                         # 打开数据库  首先得到利率，汇率
    get_rate()                                       # 爬虫利率，汇率
    closedb()                                        # g关闭数据库
    while True:                                      # 后台一直运行
        now = datetime.datetime.now()                # 得到现在的时间
        now = now.replace(day=1)
        next = datetime.datetime(now.year,now.month,2,0,0,0,0)
        delta = int((next-now).seconds)              # 算出距24:00还有多少秒
        time.sleep(delta)                            # 睡眠直至24:00
        opendb()                                     # 打开数据库
        get_rate()                                   # 爬虫利率，汇率
        cal_product()                                # 计算利息积数
        now = datetime.datetime.now()                # 得到现在的时间
        if now.month == 7 and now.day == 1:          # 判断是否是结息日
            print 'Today is interest day!'
            cur.execute('select fid from fund_account')  # 得到资金账户id
            fids = []
            num = 0                                  # 计数，一个线程更新10个资金账户
            results = cur.fetchall()
            length = len(results)                    # 资金账户的个数
            nowl = 0;                                # 已参与计算的资金账户
            threads = []
            for fid in results:               # 得到fid
                fids.append(fid[0])
                num += 1
                if num == 10 or num+nowl==length:                        # 当有10个资金账户时，开一个线程结息
                    update_t = UpdateThread(fids)    # 初始化线程
                    update_t.start()                 # 线程开始运行
                    threads.append(update_t)
                    nowl += num
                    num = 0                          # 重头计数
                    fids = []
            for thread in threads:                   # 线程等待
                thread.join()
        print now.month,now.day,'updating done'
        closedb()                                    # 关闭数据库
