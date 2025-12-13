# gaia-nat 

`Gaia`框架的内网穿透工具

### 安装

```bash
composer require mongdch/gaia-nat
```

### 使用

1. 服务器端配置`config.php`, 设置`server`项`listen`节点，监听服务器外网访问的端口，默认`8087`。可配合`nginx`反向代理，实现域名访问、端口隐藏。

```conf:nginx
# nginx代理配置

upstream gaia-nat {
    server 127.0.0.1:8087;
    keepalive 10240;
}

server {
  server_name dev.test;
  listen 80;
  access_log off;
  # 注意，这里可以指定任意空目录
  root /www/wwwroot/gaia-nat;

  location / {
    try_files $uri $uri/ @proxy;
  }

  location @proxy {
    proxy_set_header Host $http_host;
    proxy_set_header X-Forwarded-For $remote_addr;
    proxy_set_header X-Forwarded-Proto $scheme;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_http_version 1.1;
    proxy_set_header Connection "";
    proxy_pass http://gaia-nat;
  }

  # 允许访问 .well-known 目录
  location ~ ^/\.well-known/ {
    allow all;
  }

  # 拒绝访问所有以 . 开头的文件或目录
  location ~ /\. {
      return 404;
  }
}

```

2. 启动服务端

```bash
php bin/nat_server.php start -d
```

3. 客户端配置`config.php`, 设置`channel_host`、`channel_port`节点，与服务器配置保持一致。设置`proxy_host`、`proxy_port`节点，配置代理转发的目标地址和端口。
同样可通过`nginx`反向代理，实现多域名支持。

4. 启动客户端
```bash
php bin/nat_client.php start -d
```