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
	
	-----------------------------------------------------------------------------------------
	
	//创建cookie
	function setCookie(name, value, expires, path, domain, secure) {
	    var cookieText = encodeURIComponent(name) + '=' + encodeURIComponent(value);
	    if (expires instanceof Date) {
	        cookieText += '; expires=' + expires;
	    }
	    if (path) {
	        cookieText += '; expires=' + expires;
	    }
	    if (domain) {
	        cookieText += '; domain=' + domain;
	    }
	    if (secure) {
	        cookieText += '; secure';
	    }
	    document.cookie = cookieText;
	}
	
	//获取cookie
	function getCookie(name) {
	    var cookieName = encodeURIComponent(name) + '=';
	    var cookieStart = document.cookie.indexOf(cookieName);
	    var cookieValue = null;
	    if (cookieStart > -1) {
	        var cookieEnd = document.cookie.indexOf(';', cookieStart);
	        if (cookieEnd == -1) {
	            cookieEnd = document.cookie.length;
	        }
	        cookieValue = decodeURIComponent(document.cookie.substring(cookieStart + cookieName.length, cookieEnd));
	    }
	    return cookieValue;
	}
	
	//删除cookie
	function unsetCookie(name) {
	    document.cookie = name + "= ; expires=" + new Date(0);
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
	
**生成唯一字符**

	function getOnlyCode() {
		var code = (new Date()).valueOf();
		code = code + "_" + generateMixed(5);
		return code;
	}
	
	function generateMixed(n) {
		var res = "";
		var chars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
		for (var i = 0; i < n; i++) {
			var id = Math.ceil(Math.random() * 35);
			res += chars[id];
		}
		return res;
	}
	
**一些常用的验证**
	
	function checkemail(email){
		if(email != ""){
			var partten = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if(partten.test(email)){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}
	
	function checknumber(bank_card){
		var number = /^\d+$/;
		if(number.test(bank_card)){
			return true;
		}else{
			return false;
		}
	}
	
	
	function checktel(tel){
		var partton = /^1[3,4,5,8]\d{9}$/;
		if(partton.test(tel)){
			return true;
		}else{
			return false;
		}
	}
	
**获取URL地址中的GET参数**

	/*-----------------实现1--------------------*/
	function getPar(par){
	    //获取当前URL
	    var local_url = document.location.href; 
	    //获取要取得的get参数位置
	    var get = local_url.indexOf(par +"=");
	    if(get == -1){
	        return false;   
	    }   
	    //截取字符串
	    var get_par = local_url.slice(par.length + get + 1);    
	    //判断截取后的字符串是否还有其他get参数
	    var nextPar = get_par.indexOf("&");
	    if(nextPar != -1){
	        get_par = get_par.slice(0, nextPar);
	    }
	    return get_par;
	}
	
	function getQueryString( name ) {  
	    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");  
	    var r = location.search.substr(1).match(reg);  
	    if (r != null) return unescape(decodeURI(r[2])); return null;  
	}  
	 
	/*--------------------实现2(返回 $_GET 对象, 仿PHP模式)----------------------*/
	var $_GET = (function(){
	    var url = window.document.location.href.toString();
	    var u = url.split("?");
	    if(typeof(u[1]) == "string"){
	        u = u[1].split("&");
	        var get = {};
	        for(var i in u){
	            var j = u[i].split("=");
	            get[j[0]] = j[1];
	        }
	        return get;
	    } else {
	        return {};
	    }
	})();
	 
	/*第2种方式, 使用时, 可以直接 $_GET['get参数'], 就直接获得GET参数的值*/


**Get values from multiple inputs jQuery**

	<input name="titles[]">
	<input name="titles[]">
	<button>submit</button>
	
	// click handler
	function onClick(event) {
	  var titles = $('input[name^=titles]').map(function(idx, elem) {
	    return $(elem).val();
	  }).get();
	
	  console.log(titles);
	  event.preventDefault();
	}
	
	// attach button click listener on dom ready
	$(function() {
	  $('button').click(onClick);
	});


**判断Object是否为空**

	function isEmpty(obj) {
	    for(var prop in obj) {
	        if(obj.hasOwnProperty(prop))
	            return false;
	    }
	
	    return true;
	}
	
	// http://stackoverflow.com/questions/4994201/is-object-empty
	function isEmpty(obj) {

	    // null and undefined are "empty"
	    if (obj == null) return true;
	
	    // Assume if it has a length property with a non-zero value
	    // that that property is correct.
	    if (obj.length > 0)    return false;
	    if (obj.length === 0)  return true;
	
	    // Otherwise, does it have any properties of its own?
	    // Note that this doesn't handle
	    // toString and valueOf enumeration bugs in IE < 9
	    for (var key in obj) {
	        if (hasOwnProperty.call(obj, key)) return false;
	    }
	
	    return true;
	}
	
**JS动态变量**
	
	var fullname = {
	  firstname: 'tian',
	  lastname: 'jingwen'
	};
	
	var replace = 'firstname'; 
	
	console.log(fullname[this.replace]);
