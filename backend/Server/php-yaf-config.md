## yaf 安装

下载: `http://pecl.php.net/package/yaf`

>确定系统已经安装了gcc、gcc-c++、make、automake、autoconf等依赖库

	sudo apt-get install gcc gcc-c++ make automake autoconf

**步骤**

1.去Pecl下载 Yaf的发布包 [2.2.9],并且解压,并进去 yaf-2.2.9 源码目录

	tar -zxvf yaf-2.1.18.tgz
	cd yaf-2.1.18
	//wget http://pecl.php.net/get/yaf-2.2.9.tgz && tar zxvf yaf-2.2.9.tgz && cd yaf-2.2.9

2.接着依次执行:
	
	/usr/local/php/bin/phpize  && ./configure --with-php-config=/usr/local/php/bin/php-config && make && make install

3.执行完你看到了这么一句,说明你第一步Yaf编译部分是ok了.

	Installing shared extensions: /usr/local/php/lib/php/extensions/no-debug-non-zts-20121212/

4.查看确认编译后的文件
	
	ll  /usr/local/php/lib/php/extensions/no-debug-non-zts-20121212/
	yaf.so //可以看到 yaf.so php扩展也已经帮我们编译好了

5.配置 php.ini

	vi /usr/local/php/etc/php.ini

	[yaf]
	yaf.environ = product
	yaf.library = NULL
	yaf.cache_config = 0
	yaf.name_suffix = 1
	yaf.name_separator = ""
	yaf.forward_limit = 5
	yaf.use_namespace = 0
	yaf.use_spl_autoload = 0
	extension=yaf.so //关键步骤:载入yaf.so ,上面也可忽略

6.重启PHP

	/etc/init.d/php-fpm restart

7.查看phpinfo()

![](http://www.youcan.cc/wp-content/uploads/2013/06/ok-yaf.png)



>参考

http://www.youcan.cc/index.php/archives/693
http://www.feiyan.info/20.html
http://www.widuu.com/archives/07/713.html
http://blog.csdn.net/eflyq/article/details/10597201

## 利用Yaf自带的快速代码生成工具`yaf_code_generator`生成代码

**1.下载yaf工具包**

	https://github.com/laruence/php-yaf

**2.上传文件到相应目录**

	/home/software/php-yaf-master

**3.进入tools/cg/并执行**

	cd /home/software/php-yaf-master/tools/cg
	/usr/local/php/bin/php yaf_cg app #app是生成的目录名

执行以上代码,将在cg/output/目录生成一份yaf的骨架代码

**4.复制至项目目录**

	cp -a /home/software/php-yaf-master/tools/cg/output/app/* /home/wwwroot/project/

>遇到的问题

在执行yaf_cg命令时可能报错`shell_exec() has been disabled for security reasons`

	警告: shell_exec()已经出于安全原因关闭

出现这现象的原因php配置文件php.ini默认关闭了shell_exec；

解决办法:

	vi /usr/local/php/etc/php.ini  #编辑
	/shell_exec #查找
	disable_functions = passthru,exec,system,chroot,scandir,chgrp,chown,proc_open,proc_get_status,ini_alter,ini_restore,dl,openlog,syslog,readlink,symlink,popepassthru,stream_socket_server,fsocket 

去掉disable_functions中的shell_exec和scandir即可.
	
	
		
