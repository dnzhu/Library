#Sublime 常用插件

##语法相关

###语法检测

- [sublimelinter-php](http://www.cnblogs.com/sirocco/p/3699094.html)
- [在编译系统增加语法检测](https://www.moreofless.co.uk/sublime-text-php-build-system/)

        tools->build system->New Build System增加以下内容,然后保存为 php.sublime-build
        
        // osx
        {
          "cmd": ["php", "-l", "$file"],
          "file_regex": "php$",
          "selector": "source.php"
        }
        
        // win, 依赖wamp环境
        {
          "cmd": ["C:\\workspace\\wamp\\bin\\php\\php5.5.12\\php.exe", "-l", "$file"],
          "file_regex": "php$",
          "selector": "source.php"
        }
        
        通过Command + B / Ctrl + B 触发检测
        
###语法高亮

- Bracket Highlighter
        
        
##远程连接/版本控制插件

- SFTP
- [GitGutter](https://github.com/jisaacks/GitGutter)

##文档处理

- DocBlockr
- [Markdown Preview](http://www.jianshu.com/p/378338f10263)


##格式相关

- Alignment

##前端相关

- Emmet


---

>**参考**:

- [Sublime Text 全程指南](http://lucida.me/blog/sublime-text-complete-guide/)
- [Sublime Text 3常用快捷键](https://github.com/vino24/iminyao/issues/27)
- [Sublime Text3插件之SideBarEnhancements侧边栏增强&浏览器预览](https://github.com/vino24/iminyao/issues/20)
- [Sublime Text3插件之sublimeLinter](https://github.com/vino24/iminyao/issues/19)

