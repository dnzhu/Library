##如何安装nginx第三方模块
>nginx文件非常小但是性能非常的高效,这方面完胜apache,nginx文件小的一个原因之一是nginx自带的功能相对较少,好在nginx允许第三方模块,第三方模块使得nginx越发的强大.在安装模块方面,nginx显得没有apache安装模块方便，当然也没有php安装扩展方便.在原生的nginx,他不可以动态加载模块,所以当你安装第三方模块的时候需要覆盖nginx文件.接下来看看如何安装nginx第三模块吧.

**nginx第三方模块安装方法:**

    ./configure --prefix=/你的安装目录  --add-module=/第三方模块目录

以安装pagespeed模块实例

**在 `未安装nginx` 情况下安装nginx第三方模块**

    # ./configure --prefix=/usr/local/nginx-1.6.2 \
    --with-http_stub_status_module \
    --with-http_ssl_module --with-http_realip_module \
    --with-http_image_filter_module \
    --add-module=../ngx_pagespeed-master --add-module=/第三方模块目录
    # make
    # make install

**在 `已安装nginx` 情况下安装nginx模块**

    # ./configure --prefix=/usr/local/nginx-1.6.2 \
     --with-http_stub_status_module \
     --with-http_ssl_module --with-http_realip_module \
     --with-http_image_filter_module \
     --add-module=../ngx_pagespeed-master
    # make
    # /etc/init.d/nginx restart

安装 `nginx` 安装第三方模块实际上是使用 `-–add-module` 重新安装一次 `nginx` ，不要 `make install` 而是直接把编译目录下 `objs/nginx` 文件直接覆盖老的 `nginx` 文件.如果你需要安装 `多个nginx第三方模块` ,你只需要多指定几个相应的 `-–add-module` 即可.

---

##0. Nginx下安装配置PageSpeed模块 `ngx_pagespeed`

[Build ngx_pagespeed From Source](https://developers.google.com/speed/pagespeed/module/build_ngx_pagespeed_from_source)

**0. 准备**
  
  [Ubuntu or Debian] 先编译安装所需要的依赖
  
    sudo apt-get install build-essential zlib1g-dev libpcre3 libpcre3-dev unzip
    
**1. 下载 `ngx_pagespeed`**

    cd /downloads
    NPS_VERSION=1.9.32.3
    wget https://github.com/pagespeed/ngx_pagespeed/archive/release-${NPS_VERSION}-beta.zip
    unzip release-${NPS_VERSION}-beta.zip
    cd ngx_pagespeed-release-${NPS_VERSION}-beta/
    wget https://dl.google.com/dl/page-speed/psol/${NPS_VERSION}.tar.gz
    tar -xzvf ${NPS_VERSION}.tar.gz  # extracts to psol/
    
**2. 下载并编译Nginx (支持 `pagespeed` )**

    cd /downloads
    # 获取NGINX最新版本 http://nginx.org/en/download.html 
    NGINX_VERSION=1.6.2
    wget http://nginx.org/download/nginx-${NGINX_VERSION}.tar.gz
    tar -xvzf nginx-${NGINX_VERSION}.tar.gz
    cd nginx-${NGINX_VERSION}/
    # 查看线上版本编译参数
    /usr/local/nginx/sbin/nginx -V
      configure arguments: --user=www --group=www --prefix=/usr/local/nginx --with-http_stub_status_module --with-http_ssl_module --with-http_gzip_static_module --with-ipv6
    # 增加ngx_pagespeed模块重新编译(注意pagespeed的路径)
    ./configure --user=www --group=www --prefix=/usr/local/nginx --with-http_stub_status_module --with-http_ssl_module --with-http_gzip_static_module --with-ipv6 --add-module=../ngx_pagespeed-release-${NPS_VERSION}-beta
    make
    # 在未安装nginx的情况下
    sudo make install

**3. 使用ngx_pagespeed**

>3.1 新建 `/usr/local/nginx/conf/pagespeed_handler.conf`

    #ngx_pagespeed config
    pagespeed FileCachePath /var/ngx_pagespeed_cache;  # Use tmpfs for best results.
    pagespeed RewriteLevel CoreFilters;
    pagespeed EnableFilters local_storage_cache;
    pagespeed EnableFilters collapse_whitespace,remove_comments;
    pagespeed EnableFilters outline_css;
    pagespeed EnableFilters flatten_css_imports;
    pagespeed EnableFilters move_css_above_scripts;
    pagespeed EnableFilters move_css_to_head;
    pagespeed EnableFilters outline_javascript;
    pagespeed EnableFilters combine_javascript;
    pagespeed EnableFilters combine_css;
    pagespeed EnableFilters rewrite_javascript;
    pagespeed EnableFilters rewrite_css,sprite_images;
    pagespeed EnableFilters rewrite_style_attributes;
    pagespeed EnableFilters recompress_images;
    pagespeed EnableFilters resize_images;
    pagespeed EnableFilters convert_meta_tags;
    pagespeed EnableFilters inline_preview_images;
    pagespeed EnableFilters resize_mobile_images;
    pagespeed EnableFilters lazyload_images;
    pagespeed LazyloadImagesAfterOnload off;
    pagespeed LazyloadImagesBlankUrl "http://www.jingwentian.com/static/loading.gif";
    #  Ensure requests for pagespeed optimized resources go to the pagespeed
    #  handler and no extraneous headers get set.
    location ~ "\.pagespeed\.([a-z]\.)?[a-z]{2}\.[^.]{10}\.[^.]+" { add_header "" ""; }
    location ~ "^/ngx_pagespeed_static/" { }
    location ~ "^/ngx_pagespeed_beacon$" { }
    location /ngx_pagespeed_statistics { allow 127.0.0.1; deny all; }
    location /ngx_pagespeed_global_statistics { allow 127.0.0.1; deny all; }
    location /ngx_pagespeed_message { allow 127.0.0.1; deny all; }
    location /pagespeed_console { allow 127.0.0.1; deny all; }

>3.2 配置 `pagespeed` 缓存目录

    mkdir /var/ngx_pagespeed_cache
    chown www.www /var/ngx_pagespeed_cache
    cp /usr/local/nginx/conf/nginx.conf /usr/local/nginx/conf/nginx.conf$(date +%m%d) #备份nginx配置文件
    #vim /usr/local/nginx/conf/nginx.conf
    
>3.3 应用到生产环境 

    #vim /usr/local/nginx/conf/nginx.conf
    server {
      #省略
      pagespeed on;
      include pagespeed_handler.conf;
      #省略
    }
    #/etc/init.d/nginx restart
    
> 3.4 测试是否安装成功

    /usr/local/nginx/sbin/nginx -t
        nginx: the configuration file /usr/local/nginx/conf/nginx.conf syntax is ok
        nginx: configuration file /usr/local/nginx/conf/nginx.conf test is successful
    
    curl -I 'http://106.185.30.159/ocp.php' | grep X-Page-Speed
        % Total    % Received % Xferd  Average Speed   Time    Time     Time  Current
                                       Dload  Upload   Total   Spent    Left  Speed
        0     0    0     0    0     0      0      0 --:--:-- --:--:-- --:--:--     0
        X-Page-Speed: 1.9.32.3-4448
    
##1. Nginx过滤替换内容模块 `substitutions4nginx`

- [模块开发者主页](http://code.google.com/p/substitutions4nginx/)
- [This module has been moved to github](https://github.com/yaoweibin/ngx_http_substitutions_filter_module/)

**1. 下载**

    cd /downloads
    wget https://github.com/yaoweibin/ngx_http_substitutions_filter_module/
    unzip master.zip
    mv ngx_http_substitutions_filter_module-master/ ngx_http_substitutions_filter_module
    
**2. 下载并编译Nginx (支持 `substitutions4nginx` ) [同上]**

    cd /downloads
    # 获取NGINX最新版本 http://nginx.org/en/download.html 
    NGINX_VERSION=1.6.2
    wget http://nginx.org/download/nginx-${NGINX_VERSION}.tar.gz
    tar -xvzf nginx-${NGINX_VERSION}.tar.gz
    cd nginx-${NGINX_VERSION}/
    # 查看线上版本编译参数
    /usr/local/nginx/sbin/nginx -V
      configure arguments: --user=www --group=www --prefix=/usr/local/nginx --with-http_stub_status_module --with-http_ssl_module --with-http_gzip_static_module --with-ipv6 --add-module=../ngx_pagespeed-release-1.9.32.3-beta
    # 增加ngx_pagespeed模块重新编译(注意pagespeed的路径)
    ./configure --user=www --group=www --prefix=/usr/local/nginx --with-http_stub_status_module --with-http_ssl_module --with-http_gzip_static_module --with-ipv6 --add-module=../ngx_pagespeed-release-1.9.32.3-beta  --add-module=../ngx_http_substitutions_filter_module
    make
    # 在未安装nginx的情况下
    sudo make install
    
**3. 应用实例**

    location / {
    
        subs_filter_types text/html text/css text/xml;
        subs_filter st(\d*).example.com $1.example.com ir;
        subs_filter a.example.com s.example.com;
    
    }
