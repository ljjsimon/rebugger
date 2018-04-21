### 给线上环境的 debug 工具
系统会开两个端口，一个 TCP， 一个 HTTP  
HTTP 接收到请求后会转给 TCP  
TCP 接受到的所有数据都会被广播给所有客户端

### 使用方法
本地部署
```
git clone https://github.com/questionlin/rebugger.git
cd rebugger
composer install
php start.php start
telnet 127.0.0.1 1234
```
另一个终端运行
```
php tclient.php
```
将 tclient.php 里面的代码改变 ip，a 的值，添加到要测试的线上服务器即可
