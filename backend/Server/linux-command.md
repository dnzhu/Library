##1. 删除大量文件的方法

文件太多，用rm直接删除不了.我发现/var/spool/postfix/maildrop/目录下有10多G的文件，估计有几十万、甚至上百万个小文件或者文件夹，这个时候，我们本来的删除命令rm -rf  * 就不好使了，因为要等待的太久。所以必须要采取一些非常手段。我们可以使用Rsync来实现快速 删除大量文件。 

建立一个空的文件夹 

  mkdir /root/blank 

用rsync删除目标目录 

  rsync --delete-before -a -H -v --progress --stats /root/blank/ ./

这样我们要删除的 cache目录就会被清空了，删除的速 度会非常快。

##2. Linux中的15个基本 `ls` 命令
> [查看详情](http://get.jobdeer.com/7288.get)

1. 不带任何选项列出文件: `ls`
2. 带 –l 选项列出文件列表: `ls -l`
3. 浏览隐藏文件: `ls -a`
4. 用 -lh 选项来以易读方式列出文件: `ls -lh`
5. 以尾部以 `/` 字符结尾的方式列出文件和目录: `ls -F`
6. 倒序列出文件: `ls -r`
7. 递归列出子目录: `ls -R`
8. 以修改时间倒序列出: `ls -ltr`
9. 按文件大小排序: `ls -lS`
10. 显示文件或目录的索引节点号: `ls -i`
11. 显示ls命令的版本: `ls --version`
12. 显示帮助页面: `ls --help`
13. 列出目录信息: `ls -l /dir`
14. 显示文件的UID和GID: `ls -n`
15. ls命令和它的别名: `alias ls="ls -l"`

    我们可以通过不加任何参数的alias命令来看到目前系统中可用的所有alias设置，当然它们同时也可以unalias来取消
    
    # alias
    alias cp='cp -i'
    alias l.='ls -d .* --color=auto'
    alias ll='ls -l --color=auto'
    alias ls='ls --color=auto'
    alias mv='mv -i'
    alias rm='rm -i'
    alias which='alias | /usr/bin/which --tty-only --read-alias --show-dot --show-tilde'
    
    删除一项之前定义的alias设置，只需用unalias命令即可
    
    unalias ls
