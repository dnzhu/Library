#Sublime 常用插件

##语法检查插件

- [sublimelinter-php](http://www.cnblogs.com/sirocco/p/3699094.html)
- [在编译系统增加语法检测](https://www.moreofless.co.uk/sublime-text-php-build-system/)

    tools->build system->New Build System增加以下内容,然后保存为 php.sublime-build

    {
      "cmd": ["php", "$file"],
      "file_regex": "php$",
      "selector": "source.php"
    }
    
    通过Command + B / Ctrl + B 触发检测
