这两个Javascript Library可以用来处理Mardown

>markdown.js https://github.com/mengfeng/zths/blob/master/js/markdown.js
>
>to-markdown.js https://github.com/mengfeng/zths/blob/master/js/to-markdown.js

用法:

    var htmltomarkdown=function(html){
        //toMarkdown is defined in to-mardown.js
        //console.log(html);
        return toMarkdown(html);
    };
    
    var markdowntohtml=function(text){
        //markdown is defined in markdown.js
        //console.log(text);
        var html=markdown.toHTML(text);
        //console.log(html);
        return html;
    };
