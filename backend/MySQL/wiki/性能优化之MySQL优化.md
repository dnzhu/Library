#性能优化之MySQL优化

>教程：[www.imooc.com](http://www.imooc.com/learn/194)

## SQL语句优化

###1. MySQL慢查日志的开启方式和存储格式 

- 查看mysql是否开启慢查询日志

        show variables like 'slow_query_log';
    
    - 查看所有log的参数
      
            show variables like '%log%';

- 设置没有索引的记录到慢查询日志

        set global log_queries_not_using_indexes=on;

- 查看超过多长时间的sql进行记录到慢查询日志

        show variables like 'long_query_time';
    
    - 设置记录的延迟时间
    
            set global long_query_time=1;

- 开启慢查询日志

        set global slow_query_log=on;
	  
- 查看日志记录位置

        show variables like 'slow_query_log_file';

- 查看日志

        tail -50 /usr/local/mysql/var/localhost-slow.log
        
    ![](http://ww4.sinaimg.cn/bmiddle/697dc689gw1epik1sos5sj21460igwin.jpg)
        
###2. MySQL慢查日志分析工具之mysqldumpslow

- 用mysql官方提供的日志分析工具查看TOP3慢日志

        mysqldumpslow -t 3 /usr/local/mysql/var/localhost-slow.log | more
        
###3. MySQL慢查日志分析工具之pt-query-digest

![](http://ww1.sinaimg.cn/bmiddle/697dc689gw1epikqdokfyj21560f60v0.jpg)

- 用pt-query-digest分析慢日志

        pt-query-digest /usr/local/mysql/var/localhost-slow.log | more
        
###4. 如何通过慢查日志发现有问题的SQL

1. 查询次数多且每次查询占用时间长的SQL

        通常为pt-query-digest分析的前几个查询

1. IO大的SQL
    
        注意pt-query-digest分析的Rows examine项

1. 未命中索引的SQL
        
        注意pt-query-digest分析的Rows examine（扫描行数） 和 Rows Send（发送行数）的对比

###5. 通过explain查询和分析SQL的执行计划

![](http://ww3.sinaimg.cn/large/697dc689gw1epil43splvj215o0fmjuk.jpg)

`explain`返回各项的含义：

-  table: 显示这一行的数据是关于哪一张表
-  type: 这是重要的列, 显示连接使用了何种类型。从最好到最差的连接类型为: `const`, `eq_reg`, `ref`, `range`, `index` 和 `ALL`。
    - index 基于索引的扫描
    - ALL 表扫描
-  possible_keys: 显示可能应用在这张表里的索引，如果为空则表示没用可能的索引。
-  key: 实际使用的索引, 如果为空表示没有使用索引。
-  key_len: 使用索引的长度，在不损失精确性的前提下，长度越短越好。
-  ref: 显示索引的哪一列被使用了，如果可能的话，是一个常数。
-  rows: MYSQL认为必须检查的用来返回请求数据的行数（表扫描的行数）。

![](http://ww3.sinaimg.cn/large/697dc689gw1epilnaz9naj21b009c0wd.jpg)

###6. Count()和Max()的优化





