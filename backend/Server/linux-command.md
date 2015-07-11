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
        
## `Find Command` Find 命令
  
>[查看详情](http://www.tecmint.com/35-practical-examples-of-linux-find-command/)
  
  

> 按照名称查找

1. 在当前目录查找文件

    	# find . -name test.txt
    
    	./test.txt

2. 在家目录查找文件

    	# find /home -name test.txt
    
    	/home/tecmint.txt

3. 查找文件忽略大小写

    	# find /home -iname test.txt
    
    	/test.txt
    	/Test.txt

4. 查找目录

    	# find / -type d -name Test
    
    	/Test

5. 按照后缀查找文件(以PHP为例)

    	#find . -type f -name "*.php"
    
    	./login.php
    	./index.php

> 按照权限查找

1. 查找 777 权限的文件

	    # find . -type f -perm 0777 -print

2. 查找非 777 权限的文件

	    #find . -type f ! -perm 777


3. 查找只读文件

	    # find / -perm /u=r

4. 查找可执行文件

	    # find / -perm /a=x

5. 查找权限为777的目录并修改授权为755

	    # find / -type d -perm 777 -print -exec chmod 755 {} \;

6. 查找并删除单个文件

	    # find . -type f -name "test.txt" -exec rm -f {} \;

7. 查找并删除多个文件

	    # find . -type f -name "*.txt" -exec rm -f () \;

8. 查找所有的空文件

	    # find /tmp -type f -empty

9. 查找所有的空目录

	    # find /tmp -type d -empty

10. 查找所有的隐藏文件

	    # find /tmp -type f -name ".*"


> 按照所属组和所有者查找

1. 根据所有者查找文件

	    # find / -user root -name test.txt

2. 根据所有者查找出所有文件

	    # find /home -user jingwentian

3. 根据所属组查找所有文件

	    # find /home -group developer


> 按照日期和时间查找文件

1. 查找最近50天修改过的文件(modify)

	    # find / -mtime 50

2. 查找最近50天存取过的文件(accessed)

  	  # find / -atime 50

3. 查找最近50 - 100天修改过的文件

	    # find / -mtime +50 -mtime -100

4. 查找1分钟内变化过的文件(changed)

	    # find / -cmin -60

5. 查找1分钟内修改过的文件

	    # find / -mmin -60

> 根据文件大小查找文件

1. 查找50M的文件

	    # find / -size 50M

2. 查找50M-100M之间的文件

  	  # find / -size +50M -size -100M

3. 查找并删除100M的文件

	    # find / -size 100M -exec rm -rf {} \;







