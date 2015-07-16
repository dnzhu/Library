//番茄土豆登录
//https://pomotodo.com/scripts/account-bb810bbc.js

(function() {
  var accountErrorHandler, errorCatch, reject, request, user_login;

  window.Raven.config('http://a8b3a8f320b14fd1ba709de765da6eea@bug.hackplan.com/2', {
    fetchContext: true
  }).install();

  errorCatch = function(fn) {
    return function() {
      var err;
      try {
        return typeof fn === "function" ? fn() : void 0;
      } catch (_error) {
        err = _error;
        return Raven.captureException(err);
      }
    };
  };

  $.fn.show_validation_error = function(msg) {
    var text;
    text = i18n.t(msg);
    if ($(this).next().is(".validation_error.tip")) {
      $(this).next().find(".inner").text(text);
      return this;
    }
    $("<div class='validation_error tip'><div class='arrow'></div><div class='inner'>" + text + "</div></div>").insertAfter(this).hide().fadeIn(500);
    $(this).one("keydown", function() {
      return $(this).next().filter(".validation_error.tip").fadeOut(1000, function() {
        return $(this).remove();
      });
    });
    return this;
  };

  accountErrorHandler = function(data) {
    if (!data) {
      return;
    }
    switch (data.msg) {
      case "unavailable_username":
      case "bad_username":
      case "unknown_username":
      case "no_account":
      case "being_deleted":
        $("#login.tab-pane.active .tt-input.username").show_validation_error("account.error_messages." + data.msg).focus().select();
        $("#register.tab-pane.active .username").show_validation_error("account.error_messages." + data.msg).focus().select();
        $("#forget.tab-pane.active .tt-input.email").show_validation_error("account.error_messages." + data.msg).focus().select();
        return true;
      case "bad_email":
      case "unavailable_email":
      case "missing_email":
        $(".tab-pane.active .tt-input.email").show_validation_error("account.error_messages." + data.msg).focus().select();
        return true;
      case "wrong_password":
      case "missing_password":
      case "mismatched_passwords":
        $(".tab-pane.active .password").show_validation_error("account.error_messages." + data.msg).focus().select();
        return true;
      default:
        return false;
    }
  };

  reject = function(resp) {
    var defer;
    defer = $.Deferred();
    defer.reject(resp);
    return defer.promise();
  };

  user_login = errorCatch(function() {
    var hash, session;
    try {
      session = JSON.parse(localStorage.session);
    } catch (_error) {
      return;
    }
    hash = window.location.hash.substr(1);
    if (!(session && (hash === "" || hash === "login" || hash === "register"))) {
      return;
    }
    return request('POST', 'account/keep_session_alive', null, {
      headers: {
        'X-Lego-Token': session.token
      }
    }).then(function(data) {
      var expires_time;
      if (data.data.pro_expires_time > parseInt(Date.parse(Date()) / 1000)) {
        $('.pro-valid').show();
        $('.pro-upgrade').hide();
        expires_time = new Date(parseInt(data.data.pro_expires_time) * 1000);
        $('#pro_valid').text(expires_time.toLocaleDateString());
      }
      $('#pay-btn').removeClass('needlogin');
      $('.use_coupon').removeClass('needlogin');
      if (data.data.pro_expires_time < 1) {
        $(".freetrial").show();
      }
      $('#accountModal').modal('hide');
      return $('.pro-account').hide();
    });
  });

  request = function(method, url, data, userOpts) {
    var defer, options;
    defer = $.Deferred();
    url = ("" + apiUrlPrefix + "/actions/") + url;
    options = $.extend({
      method: method,
      url: url,
      dataType: "json",
      data: data
    }, userOpts);
    $.ajax(options).done(function(data, textStatus, jqXHR) {
      return defer[(data.error ? "reject" : "resolve")](data);
    }).fail(function(jqXHR) {
      $(".notice").text($.t("account.error_messages.request_failed")).show();
      setTimeout(function() {
        return $(".notice").hide();
      }, 3000);
      return defer.reject();
    });
    return defer.promise();
  };

  $(function() {
    var $tabPanes, $tabs, checkSomeValueEmpty;
    $tabPanes = $(".tab-pane");
    $tabs = $("#js-forms-tab > li");
    checkSomeValueEmpty = function(data, keys) {
      var key, _i, _len;
      for (_i = 0, _len = keys.length; _i < _len; _i++) {
        key = keys[_i];
        if (!(!data[key])) {
          continue;
        }
        $(".tab-pane.active ." + key + ":not(.tt-hint)").show_validation_error("account.validate." + key + "_is_empty").focus().select();
        return true;
      }
      return false;
    };
    routie({
      "login": function() {
        $tabs.not(".login, .register").hide();
        $tabs.filter(".login").show().addClass("active");
        $tabPanes.removeClass("active").filter("#login").addClass("active");
        return $tabs.removeClass("active").filter(".login").addClass("active");
      },
      forget: function() {
        $tabs.not(".forget").hide();
        $tabs.filter(".forget").removeClass("hide").show().addClass("active");
        return $tabPanes.removeClass("active").filter("#forget").addClass("active");
      },
      "reset/:id/:code": function(id, code) {
        $("#resetCode").val(code);
        $("#resetAccount").val(id);
        $tabs.not(".reset").hide();
        $tabs.filter(".reset").removeClass("hide").addClass("active");
        return $tabPanes.removeClass("active").filter("#reset").addClass("active");
      },
      "verify/:email/:code": function(email, code) {
        $tabs.not(".verify").hide();
        $tabs.filter(".verify").removeClass("hide").addClass("active");
        $tabPanes.removeClass("active").filter("#verify").addClass("active");
        return request("post", "account/email_verify", {
          email: email,
          vcode: code
        }).done(function(data) {
          return $("#verify .result.success").show();
        }).fail(function() {
          return $("#verify .result.fail").show();
        });
      },
      "unsubscribe/:email": function(email) {
        $tabs.not(".unsubscribe").hide();
        $tabs.filter(".unsubscribe").removeClass("hide").addClass("active");
        $tabPanes.removeClass("active").filter("#unsubscribe").addClass("active");
        return request("post", "account/unsubscribe", {
          email: email
        });
      },
      "revocation/:code": function(code) {
        $tabs.not(".revocation").hide();
        $tabs.filter(".revocation").removeClass("hide").addClass("active");
        $tabPanes.removeClass("active").filter("#revocation").addClass("active");
        return $("#revocation .confirm button").one("click", function() {
          return request("post", "account/revocation_email", {
            code: code
          }).done(function(data) {
            $("#revocation .confirm").hide();
            return $("#revocation .result.success").show();
          }).fail(function() {
            $("#revocation .confirm").hide();
            return $("#revocation .result.fail").show();
          });
        });
      },
      "*": function() {
        $tabPanes.removeClass("active").filter("#register").addClass("active");
        return $tabs.removeClass("active").filter(".register").addClass("active");
      }
    });
    $("#register > form").on("submit", function(event) {
      var $registerBtn, $this, data, dateVar, offset, timezone;
      $this = $(this);
      dateVar = new Date();
      offset = dateVar.getTimezoneOffset();
      timezone = jstz.determine();
      data = {
        email: $("#regEmail").val(),
        username: $("#regUser").val(),
        password: $("#regPass").val(),
        lang: $.i18n.lng(),
        offset: offset,
        timezone: timezone.name(),
        device: "web"
      };
      if (checkSomeValueEmpty(data, ["username", "email", "password"])) {
        return false;
      }
      if ($("#regRepeatPass").val() !== data.password) {
        $(".tab-pane.active .repeat_password").show_validation_error("account.validate.repeat_password_not_valid").focus().select();
        return false;
      }
      $registerBtn = $('#register button[type="submit"]').text(i18n.t('web:usual.submitting')).attr('disabled', 'disabled');
      return request("post", "account/register", data).done(function(data) {
        var session;
        session = data.data;
        localStorage.setItem('session', JSON.stringify(session));
        if ($('.header').data('page') === 'pro') {
          return user_login();
        } else {
          if (getParameterByName("goto") === "youzhu") {
            $(".loading-view").show();
            $("#account").hide();
            return location.href = "http://help.pomotodo.com/#!/jwt?token=" + session.jwt;
          } else if (getParameterByName("goto") === "reportboss") {
            $(".loading-view").show();
            $("#account").hide();
            return location.href = "http://report.hackplan.com/api/auth/pomotodo?jwt=" + session.jwt;
          } else {
            $(".loading-view").show();
            $("#account").hide();
            return location.href = "/app/";
          }
        }
      }).fail(accountErrorHandler).always(function() {
        return $registerBtn.text(i18n.t('account.register')).removeAttr('disabled');
      });
    });
    $("#login > form").on("submit", function(event) {
      var $loginBtn, $this, data, dateVar, offset, timezone;
      $this = $(this);
      dateVar = new Date();
      offset = dateVar.getTimezoneOffset();
      timezone = jstz.determine();
      data = {
        username: $("#loginUser").val(),
        password: $("#loginPass").val(),
        device: "web",
        lang: $.i18n.lng(),
        offset: offset,
        timezone: timezone.name()
      };
      if (checkSomeValueEmpty(data, ["username", "password"])) {
        return false;
      }
      $loginBtn = $('#login button[type="submit"]').text(i18n.t('web:usual.submitting')).attr('disabled', 'disabled');
      return request("post", "account/login", data).done(function(data) {
        var session;
        session = data.data;
        localStorage.setItem('session', JSON.stringify(session));
        if ($('.header').data('page') === 'pro') {
          return user_login();
        } else {
          if (getParameterByName("goto") === "youzhu") {
            $(".loading-view").show();
            $("#account").hide();
            return location.href = "http://help.pomotodo.com/#!/jwt?token=" + session.jwt;
          } else if (getParameterByName("goto") === "reportboss") {
            $(".loading-view").show();
            $("#account").hide();
            return location.href = "http://report.hackplan.com/api/auth/pomotodo?jwt=" + session.jwt;
          } else {
            $(".loading-view").show();
            $("#account").hide();
            return location.href = "/app/";
          }
        }
      }).fail(accountErrorHandler).always(function() {
        return $loginBtn.text(i18n.t('account.login')).removeAttr('disabled');
      });
    });
    $("#forget > form").on("submit", function(event) {
      var $forgetBtn, $this, data;
      $this = $(this);
      data = {
        email: $("#forgetEmail").val(),
        lang: $.i18n.lng()
      };
      if (checkSomeValueEmpty(data, ["email"])) {
        return false;
      }
      $forgetBtn = $('#forget button[type="submit"]').text(i18n.t('web:usual.submitting')).attr('disabled', 'disabled');
      return request("post", "account/forget", data).done(function(data) {
        $("#forget form").hide();
        return $("#forget .result").show();
      }).fail(accountErrorHandler).always(function() {
        return $forgetBtn.text(i18n.t('account.reset')).removeAttr('disabled');
      });
    });
    $("#reset > form").on("submit", function(event) {
      var $resetBtn, $this, data;
      $this = $(this);
      data = {
        recode: $("#resetCode").val(),
        account_id: $("#resetAccount").val(),
        password: $("#resetPass").val(),
        repeat_password: $("#resetRepeatPass").val()
      };
      if (checkSomeValueEmpty(data, ["password", "repeat_password"])) {
        return false;
      }
      if (data.repeat_password !== data.password) {
        $(".tab-pane.active .repeat_password").show_validation_error("account.validate.repeat_password_not_valid").focus().select();
        return false;
      }
      $resetBtn = $('#reset button[type="submit"]').text(i18n.t('web:usual.submitting')).attr('disabled', 'disabled');
      return request("post", "account/reset", data).done(function(data) {
        $("#reset form").hide();
        return $("#reset .result.success").show();
      }).fail(function() {
        $("#reset form").hide();
        return $("#reset .result.fail").show();
      }).always(function() {
        return $resetBtn.text(i18n.t('account.reset')).removeAttr('disabled');
      });
    });
    return $('#login input.username, #register input.email, #forget input.email').typeahead({
      highlight: false
    }, {
      display: 'value',
      source: function(q, cb) {
        var atpos, majorMailServices, result, serviceQuery, substrRegex, username;
        atpos = q.indexOf("@");
        if (atpos > 0 && q.length > atpos + 1) {
          username = q.substr(0, atpos);
          serviceQuery = q.substr(atpos + 1);
          majorMailServices = ["qq.com", "gmail.com", "163.com", "126.com", "hotmail.com", "sina.com", "foxmail.com", "yeah.net", "outlook.com", "vip.qq.com", "yahoo.com", "sohu.com", "live.com", "139.com", "aliyun.com", "icloud.com", "me.com", "msn.com", "tom.com", "21cn.com", "yandex.ru", "mail.ru", "aol.com", "naver.com", "yahoo.co.jp"];
          substrRegex = new RegExp(serviceQuery, "i");
          result = _(majorMailServices).map(function(service) {
            if (substrRegex.test(service)) {
              return "" + username + "@" + service;
            }
          }).uniq().compact().map(function(fix) {
            return {
              value: fix
            };
          }).value();
          return cb(result);
        } else {
          return cb(null);
        }
      }
    });
  });

}).call(this);

//# sourceMappingURL=../scripts/account-bb810bbc.js.map
