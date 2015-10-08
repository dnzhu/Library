/* 
  lazyload的配置项说明 
  1.threshold: 提前加载, 默认的情况是，当你滚动到图片位置的时候，插件开始加载。这样，用户可能首先看到的是一个空白图像，然后再缓慢出现。如果你想在用户滚动之前，提前加载这个图像，你可以配置一下参数。
  2.event: 默认的触发事件，是滚动，当你滚动的时候，就会检查然后加载。你可以使用event属性，设置你自己的加载事件，之后你可以自定义触发这个事件的条件，然后去加载图像。如: { event : "click" }
  3.container: 把图像插入某个容器,在容器中实现缓冲加载,如:{container: $("#container")}
  4.skip_invisible: 加载不可见图像,有部分图像是不可见的，我们对其加上类似 display：none 等属性的图像。默认的情况下，这个插件是不会加载隐藏的不可见图像。如果我们需要用它加载不可见图像，我们需要将 skip_invisible 设置为 false
*/


//STEP 1
<script src="jquery.js" type="text/javascript"></script>
<script src="jquery.lazyload.js" type="text/javascript"></script>

//STEP 2
<img class="lazy" data-original="img/example.jpg" src="img/grey.gif">

//STEP 3
var lazyloadOptions = {
  threshold: 200, //当距离图片还有200像素的时候，就开始加载图片
  skip_invisible: false,//加载不可见图像
  effect: "fadeIn"
};

$('.lazy').lazyload(lazyloadOptions);
