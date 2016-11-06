#FROM 指令指定基础镜像
#比较常用的基础镜像有ubuntu，centos。
FROM daocloud.io/php:5.6-apache

#MAINTAINER指令用于将镜像制作者相关的信息写入到镜像中
#您可以将您的信息填入name以及email
MAINTAINER v4if <karma_wjc@yeah.net>

#安装 pdo_mysql PHP 扩展
RUN docker-php-ext-install pdo_mysql

#COPY指令复制主机的文件到镜像中 （在这里当前路径就是repo根目录）
COPY . /var/www/html/

#EXPOSE：指定容器监听的端口
EXPOSE 80
