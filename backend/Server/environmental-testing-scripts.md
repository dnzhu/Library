##环境测试脚本

###1. 测试php安装是否正确

    <?php  
    phpinfo();  
    ?> 

###2. 测试php mysql扩展安装是否正确

    <?php
    $username = "your_name";
    $password = "your_password";
    $hostname = "localhost"; 
    $dbname = "examples";
    //connection to the database
    $dbhandle = mysql_connect($hostname, $username, $password) 
     or die("Unable to connect to MySQL");
    echo "Connected to MySQL<br>";
    //select a database to work with
    $selected = mysql_select_db($dbname,$dbhandle) 
      or die("Could not select $dbname");
    //execute the SQL query and return records
    $result = mysql_query("SELECT id, model,year FROM cars");
    //fetch tha data from the database 
    while ($row = mysql_fetch_array($result)) {
       echo "ID:".$row{'id'}." Name:".$row{'model'}."Year: ". //display the results
       $row{'year'}."<br>";
    }
    //close the connection
    mysql_close($dbhandle);
    ?>

###3. 测试php redis扩展安装是否正确

    <?php
    $redis = new Redis();
    $redis->connect('127.0.0.1',6379);
    $redis->set('testkey','hello world!');
    echo $redis->get('testkey');
    ?>

###4. 测试php memcache扩展安装是否正确

    <?php
    //连接
    $mem = new Memcache;
    $mem->connect("127.0.0.1", 11211) or die ("Could not connect");
    
    //显示版本
    $version = $mem->getVersion();
    echo "Memcached Server version:  ".$version."<br>";
    
    //保存数据
    $mem->set('key1', 'This is first value', 0, 60);
    $val = $mem->get('key1');
    echo "Get key1 value: " . $val ."<br>";
    
    //替换数据
    $mem->replace('key1', 'This is replace value', 0, 60);
    $val = $mem->get('key1');
    echo "Get key1 value: " . $val . "<br>";
    
    //保存数组
    $arr = array('aaa', 'bbb', 'ccc', 'ddd');
    $mem->set('key2', $arr, 0, 60);
    $val2 = $mem->get('key2');
    echo "Get key2 value: ";
    print_r($val2);
    echo "<br>";
    
    //删除数据
    $mem->delete('key1');
    $val = $mem->get('key1');
    echo "Get key1 value: " . $val . "<br>";
    
    //清除所有数据
    $mem->flush();
    $val2 = $mem->get('key2');
    echo "Get key2 value: ";
    print_r($val2);
    echo "<br>";
    
    //关闭连接
    $mem->close();
    ?>
