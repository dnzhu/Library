##1. 删除大量文件的方法

文件太多，用rm直接删除不了.我发现/var/spool/postfix/maildrop/目录下有10多G的文件，估计有几十万、甚至上百万个小文件或者文件夹，这个时候，我们本来的删除命令rm -rf  * 就不好使了，因为要等待的太久。所以必须要采取一些非常手段。我们可以使用Rsync来实现快速 删除大量文件。 

建立一个空的文件夹 

  mkdir /root/blank 

用rsync删除目标目录 

  rsync --delete-before -a -H -v --progress --stats /root/blank/ ./

这样我们要删除的 cache目录就会被清空了，删除的速 度会非常快。
