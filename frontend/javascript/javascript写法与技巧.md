#javascript写法与技巧

##JavaScript技巧篇


###1. 状态机

    var state = function () {
               this.count = 0;
               this.fun = null;
               this.nowcount = 0;
     
           };     
           state.prototype = {
               load: function (count,fun) {
                   this.count = count;
                   this.fun = fun;
                   this.nowcount=0;
               },
               trigger: function () {
                   this.nowcount++;
                   if (this.nowcount >= this.count){
                       this.fun();
                   }
               }
           };
     
           //--------------<br>
           function method1() {
               s.trigger();
           }
           function method2() {
               s.trigger();
           }
           var s = new state();
           s.load(2, function () {
               console.log('执行完毕');
           });
           setTimeout(method1, 1000);
           setTimeout(method2, 1000);

状态机一般用在多个异步任务的情况下，任务执行到某个阶段执行某个函数!

场景：同时请求多个异步执行[并发异步or异步串行](ajax,nodejs的io)，并处理结果集合，以上的写法最简单，但却不够优美

###2. setTimeout 的特殊应用

    var hander=setTimeout(function () { },100);
    clearTimeout(hander);

**场景1：*** 按钮三次快速点击才触发事件　　

    var num = 0;
        var hander = 0;
        function btnClick() {
            if (hander != 0){
                clearTimeout(hander);
                hander = 0;
            }
            num++;
            if (num >= 3) {
                Run();
                num = 0;
                clearTimeout(hander);
                hander = 0;
            }
            hander = setTimeout(function () {
                num = 0;
            }, 300);
        }
        function Run() {
            console.log('Run');
        }
    <input type="button" onclick="btnClick()" value="快速点击三次触发" />　
    
**场景2：** 快速多次点击只触发最后一次

    var hander = 0;
        function btnClick() {
            if (hander != 0) {
                clearTimeout(hander);
                hander = 0;
            }
            hander = setTimeout(function () {
                Run();
            }, 300);
        }
        function Run() {
            console.log('Run');
        }
    <input type="button" onclick="btnClick()" value="快速点击只触发最后一次" />
    

##JavaScript写法篇：

###1. . & []

    var obj = new Object();
       obj.add = function (a, b) {
           return a + b;
       }
       console.log(obj.add(1, 2));
     
       var obj2 = new Object();
       obj2['add'] = function (a, b) {
           return a + b;
       }
       console.log(obj2.add(1, 2));
       
###2. prototype

    var obj = function (name) {
           this.name = name;
       }
       obj.prototype.say = function () {
           console.log(this.name);
       }
       obj.prototype.add = function (a, b) {
           return a + n;
       }
       var o = new obj('fuck');
       o.say();
     
       var obj = function (age) {
           this.age = age;
     
       };
       obj.prototype = {
           add: function (a, b) {
               return this.age;
           },
           say: function () {
               console.log('@');
           }
       }
       var o = new obj(23333);
       console.log(o.add());

###switch语句重构为查找表

    var doSomething = function(doWhat) {
        switch(doWhat) {
            case "doThisThing":
                // more code...
            break;
            case "doThatThing":
                // more code...
            break;
            case "doThisOtherThing":
                // more code....
            break;
            // additional cases here, etc.
            default:
                // default behavior
            break;
        }
    }
    
也可以转化为像下面这样：

    var thingsWeCanDo = {
        doThisThing      : function() { /* behavior */ },
        doThatThing      : function() { /* behavior */ },
        doThisOtherThing : function() { /* behavior */ },
        default          : function() { /* behavior */ }
    };
    
    var doSomething = function(doWhat) {
        var thingToDo = thingsWeCanDo.hasOwnProperty(doWhat) ? doWhat : "default"
        thingsWeCanDo[thingToDo]();
    }
    



---
###Reference

- [我希望我知道的七个JavaScript技巧](http://yanhaijing.com/javascript/2014/04/23/seven-javascript-quirks-i-wish-id-known-about/)
- [JavaScript技巧&写法](http://www.cnblogs.com/dark89757/p/4287547.html)
