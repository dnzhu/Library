有些时候，大家不想让别人调用自己的图片，一是因为个人版权的问题，再一点就是会增加服务器的负载、还会产生一些没必要的流量。

其实在Nginx里面，很容易就做到防盗链的，在nginx.conf文件加入一个localtion配置项。

>下面请看配置：

```
location ~ .*\.(jpg|jpeg|JPG|png|gif|icon)$ {
        valid_referers blocked www.jingwentian.com jingwentian.com;
        if ($invalid_referer) {
            return 404;
            #rewrite ^/ http://otherdomin.com/404.jpg;
        }
}
```

gif|jpg|jpeg|….,这些是你想要屏蔽的文件类型，可以根据情况修改。

只需要把文中`www.jingwentian.com jingwentian.com` 修改为你允许显示你网站图片的其他网站域名，注意中间用空格分开，而不是逗号。

这样直接返回的是404页面。也可以用 `http://domain.com/404.jpg` ，显示给盗链者看到的图片，注意不要放到自己的域名上，因为放盗链的作用，那样对方是看不到的，可以上传到一些支持外联的网络相册上。

当然了，也可以设置某个目录防盗链，只需把localtion匹配的改成一个目录就可以了，比如：

```
location ~ ^/images/ {
	valid_referers none blocked www.jingwentian.com jingwentian.com;
	if ($invalid_referer) {
		return 404;
		#rewrite ^/ http://otherdomin.com/404.jpg;
	}	
}
```

这样就对images这个目录设置防盗链了。
