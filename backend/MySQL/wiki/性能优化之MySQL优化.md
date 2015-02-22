###1.1 MySQL慢查日志的开启方式和存储格式 

- 查看mysql是否开启慢查询日志

    show variables like 'slow_query_log';
    
    - 查看所有log的参数
      
          show variables like '%log%';

- 设置没有索引的记录到慢查询日志

	  set global log_queries_not_using_indexes=on;



- 查看超过多长时间的sql进行记录到慢查询日志

	  show variables like 'long_query_time'

- 开启慢查询日志

	  set global slow_query_log=on
	  
- 查看日志记录位置

	  show variables like 'slow_query_log_file'

- 查看日志

	  tail -50 /home/mysql/data/mysql-slow.log

