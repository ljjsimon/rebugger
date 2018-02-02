### 给线上环境的 debug 工具
系统会开两个端口，一个 TCP， 一个 HTTP  
TCP 接受到的所有数据都会被广播，本地用 telnet 连上 TCP 后用来接受接收。  
PHP 可以使用 file_get_contents 请求 HTTP，$_GET['a'] 会被发到 TCP 然后被转发到本地 telnet