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
