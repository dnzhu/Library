//快盘登录插件
var rsa = (function($){
        var publicKey
        // 获取公钥
        var getPubKey = function(callback){
        if(publicKey) return callback();
        $.post('/accounts/prelogin').always(function(json){
            if(json && json.status == 'ok'){
            publicKey = json.data
            if(callback) callback()
            }
            })
        }

        // rsa加密
        var encrypt = function(txt){
            if(!publicKey) return txt
            var rsa = new RSA.RSAKey()
            rsa.setPublic(publicKey.n, publicKey.e)
            var res = rsa.encrypt(txt)
            res = RSA.linebrk( RSA.hex2b64(res) )
            return res
        }
        return {
            publicKey: publicKey,
            encrypt: encrypt,
            getPubKey: getPubKey
        }
})(jQuery);

;(function($){
	$.fn.login = function(options){
		options = $.extend({
			formEle: $(this),
			msgEle: $(this).find(".msg"),
			submitUrl : $(this).attr('action'),
			loginIdEle: $(this).find("input[name='username']"),
			pwdEle: $(this).find("input[name='password']"),
			remember: $(this).find("#remember"),
			success: $.noop
		}, options);

		var ERROR_MESSAGES = {
			'inputCorrectEmail': '请输入正确的用户名',
			'inputPassword': '请填写登录密码',
			'passwordLength': '密码应在6-32位字符内',
			'noreg': '此账号未注册',
			'checkemailcode_2': '此账号未注册',
			'checkemailcode_': '服务器繁忙，请稍后再试',
			'accountNotMatch': '账号密码不匹配',
			'serverdown': '服务器维护中',
			'clientUserBaned': '您的账号被限制登录',
			'accUserInvalid': '正在对该账号进行绑定处理，暂无法登录',
			'userLocked': '账号锁定中，暂时无法登录',
            'tooOften': '密码错误次数过多，请1小时后重试'
		};

		function showMsg(Msg){
			options.msgEle.html(Msg);
		}

		$(this).submit(function(){
			return false;
		})

		$(this).submit(function(){
			if(checkLoginId() && checkPwd()){
				submit();	
			}
		})

		function submit() {
			var loginId = $.trim(options.loginIdEle.val());
			var pwd = $.trim(options.pwdEle.val());
			if(options.remember.hasClass('checked') || options.remember.attr('checked') == 'checked') {
				var expired = parseInt(new Date().getTime()/1000) + 7*24*3600;
			} else {
				var expired = 0;	
			}

            rsa.getPubKey(function(){
                var para =  {
                    'username': loginId,
                    'password': pwd,
                    'expired' : expired
                }

                if(true){
                    para.security = 1;
                    para.username = rsa.encrypt(para.username);
                    para.password = rsa.encrypt(para.password);
                }

                $.post(options.submitUrl, para, function(data){
                    if(data.status == 'ok'){
                        options.formEle.trigger('reset');
                        options.success('登录成功');
                    }else{
                        if(typeof ERROR_MESSAGES[data.status] == 'string'){
                            showMsg(ERROR_MESSAGES[data.status]);	
                        }else{
                            showMsg('账号密码不正确,错误码：' + data.status);	
                        }
                    }
                }, 'json');


            });
		}

		function checkLoginId() {
			var loginId = $.trim(options.loginIdEle.val());

			if('' === loginId) {
				showMsg('登录名不能为空');
				options.loginIdEle.trigger('focus');
				return false;
			}

			if (!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/i.test(loginId) && !/^1\d{10}$/i.test(loginId) ){
				showMsg('账号格式不正确');
				options.loginIdEle.trigger('focus');
				return false;
			} 

			return true;
		}

		function checkPwd() {
			var pwd = $.trim(options.pwdEle.val());

			if('' === pwd) {
				showMsg('密码不能为空');
				options.pwdEle.trigger('focus');
				return false;
			}

			return true;
		}

		return $(this);
	}
})(jQuery);
