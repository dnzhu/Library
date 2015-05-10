**javascript截取字符串**

	var sub=function(str,n){
		var r=/[^\x00-\xff]/g;
		if(str.replace(r,"mm").length<=n){return str;}
		var m=Math.floor(n/2);
		for(var i=m;i<str.length;i++){
			if(str.substr(0,i).replace(r,"mm").length>=n){
			  return str.substr(0,i)+"...";
			}
		}
		return str;
	}
	alert('javascript截取字符串',10);
		
**`jQuery .keyup() delay`延迟搜索**
> [jQuery .keyup() delay - stackoverflow](http://stackoverflow.com/questions/1909441/jquery-keyup-delay)

	var delay = (function(){
	  var timer = 0;
	  return function(callback, ms){
	    clearTimeout (timer);
	    timer = setTimeout(callback, ms);
	  };
	})();
	
	$('input').keyup(function() {
	    delay(function(){
	      alert('Time elapsed!');
	    }, 1000 );
	});

**JS操作COOKIE的方法**

	function setCookie(name,value)//两个参数，一个是cookie的名子，一个是值
	{
		var Days = 3000; //此 cookie 将被保存 300 天
		var exp  = new Date();    //new Date("December 31, 9998");
		exp.setTime(exp.getTime() + Days*24*60*60*1000);
		document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
	}
	function getCookie(name)//取cookies函数       
	{
		var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
		if(arr != null) return (arr[2]); return null;
	}
	function delCookie(name)//删除cookie
	{
		var exp = new Date();
		exp.setTime(exp.getTime() - 1);
		var cval=getCookie(name);
		if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();
	}
	
**JS判断浏览器UA实现跳转**

	var mobileAgent = new Array("iphone", "ipod", "ipad", "android", "mobile", "blackberry", "webos", "incognito", "webmate", "bada", "nokia", "lg", "ucweb", "skyfire");
	var browser = navigator.userAgent.toLowerCase(); 
	var isMobile = false; 
	for (var i=0; i<mobileAgent.length; i++){
		if (browser.indexOf(mobileAgent[i])!=-1){
			isMobile = true;

			location.href = 'http://m.website.com';
			break;
		}
	};

