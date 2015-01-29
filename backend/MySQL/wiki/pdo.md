##php PDO 连接 mysql

PDO是PHP 5新加入的一个重大功能，因为在PHP 5以前的php4/php3都是一堆的数据库扩展来跟各个数据库的连接和处理，什么php_mysql.dll、php_pgsql.dll、php_mssql.dll、php_sqlite.dll等等扩展来连接MySQL、PostgreSQL、MS SQL Server、SQLite，同样的，我们必须借助 ADOdb、PEAR::DB、PHPlib::DB之类的数据库抽象类来帮助我们，无比烦琐和低效，毕竟，php代码的效率怎么能够我们直接用C/C++写的扩展效率高捏？所以嘛，PDO的出现是必然的，大家要平静学习的心态去接受使用，也许你会发现能够减少你不少功夫哦。

###PDO如何使用：

PDO_MYSQL：PDO_MYSQL是PDO接口能够完成连接mysql数据库的驱动（注：仅使用于mysql 3.x以上版本）。

**安装：**

打开php.ini文件，可以找到如下代码，这里可以看到mysql的驱动默认已经打开（前面没有用于注释的分号），如有连接其他数据库的需要，自行添加其他数据库的驱动程序（取出相应的项前面的分号，没有的添上）。

    //各数据库的PDO驱动  
    extension=php_pdo.dll   
    extension=php_pdo_firebird.dll //Firebird  
    extension=php_pdo_informix.dll //Informix  
    extension=php_pdo_mssql.dll    //sql server  
    extension=php_pdo_mysql.dll    //mysql  
    extension=php_pdo_oci.dll      //Oracle  
    extension=php_pdo_oci8.dll   
    extension=php_pdo_odbc.dll     //DB2  
    extension=php_pdo_pgsql.dll    //PostgreSQL  
    extension=php_pdo_sqlite.dll   //SQLite
    
**连接：**

通过创建PDO基类的实例创建连接。

    //连接到数据库  
    $db = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
    
**简单的查询方法：**

    <?php
    header('content-type:text/html;charset=utf-8');
    try {  
        $db = new PDO('mysql:host=127.0.0.1;dbname=test', 'root', '');  
        //查询  
        $rows = $db->query('SELECT * from members')->fetchAll(PDO::FETCH_ASSOC);
        $rs = array();
        foreach($rows as $row) {  
            $rs[] = $row; 
        }  
        $db = null;  
    } catch (PDOException $e) {  
        print "Error!: " . $e->getMessage() . "<br/>";  
        die();  
    }
    print_r($rs);
    ?>
    
    [详解]
    $dsn = "mysql:host=127.0.0.1;dbname=test";
    就是构造我们的DSN（数据源），看看里面的信息包括：数据库类型是mysql，主机地址是localhost，数据库名称是test，就这么几个信息。不同数据库的数据源构造方式是不一样的。

    $db = new PDO($dsn, 'root', '');
    初始化一个PDO对象，构造函数的参数第一个就是我们的数据源，第二个是连接数据库服务器的用户，第三个参数是密码。我们不能保证连接成功，后面我们会讲到异常情况，这里我们姑且认为它是连接成功的。

    $count = $db->exec("INSERT INTO foo SET name = 'heiyeluren',gender='男',time=NOW()");
    echo $count;
    调用我们连接成功的PDO对象来执行一个查询，这个查询是一个插入一条记录的操作，使用PDO::exec() 方法会返回一个影响记录的结果，所以我们输出这个结果。最后还是需要结束对象资源：
    $db = null;

    默认这个不是长连接，如果需要数据库长连接，需要最后加一个参数：array(PDO::ATTR_PERSISTENT => true)变成这样：
    $db = new PDO($dsn, 'root', '', array(PDO::ATTR_PERSISTENT => true));

    使用setFetchMode方法来设置获取结果集的返回值的类型，同样类型还有：
    PDO::FETCH_ASSOC -- 关联数组形式
    PDO::FETCH_NUM -- 数字索引数组形式
    PDO::FETCH_BOTH -- 两者数组形式都有，这是缺省的
    PDO::FETCH_OBJ -- 按照对象的形式，类似于以前的 mysql_fetch_object()
    
    $db->query($sql); 当$sql 中变量可以用$dbh->quote($params); //转义字符串的数据
    
**php pdo statement**

    PDOStatement::bindColumn — 绑定一列到一个 PHP 变量  
    PDOStatement::bindParam — 绑定一个参数到指定的变量名  
    PDOStatement::bindValue — 把一个值绑定到一个参数  
    PDOStatement::closeCursor — 关闭游标，使语句能再次被执行。  
    PDOStatement::columnCount — 返回结果集中的列数  
    PDOStatement::debugDumpParams — 打印一条 SQL 预处理命令  
    PDOStatement::errorCode — 获取跟上一次语句句柄操作相关的 SQLSTATE  
    PDOStatement::errorInfo — 获取跟上一次语句句柄操作相关的扩展错误信息  
    PDOStatement::execute — 执行一条预处理语句  
    PDOStatement::fetch — 从结果集中获取下一行  
    PDOStatement::fetchAll — 返回一个包含结果集中所有行的数组  
    PDOStatement::fetchColumn — 从结果集中的下一行返回单独的一列。  
    PDOStatement::fetchObject — 获取下一行并作为一个对象返回。  
    PDOStatement::getAttribute — 检索一个语句属性  
    PDOStatement::getColumnMeta — 返回结果集中一列的元数据  
    PDOStatement::nextRowset — 在一个多行集语句句柄中推进到下一个行集  
    PDOStatement::rowCount — 返回受上一个 SQL 语句影响的行数  
    PDOStatement::setAttribute — 设置一个语句属性  
    PDOStatement::setFetchMode — 为语句设置默认的获取模式。

**插入、更新、删除数据**

    $db->exec("DELETE FROM `xxxx_menu` where mid=43");
    
---

**PDO中的事务**

PDO->beginTransaction()，PDO->commit()，PDO->rollBack()这三个方法是在支持回滚功能时一起使用的。PDO->beginTransaction()方法标明起始点，PDO->commit()方法标明回滚结束点，并执行SQL，PDO->rollBack()执行回滚。
    
    <?php
    try {
    $dbh = new PDO('mysql:host=localhost;dbname=test', 'root', ");
    $dbh->query('set names utf8;');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
    $dbh->beginTransaction();
    $dbh->exec("INSERT INTO `test`.`table` (`name` ,`age`)VALUES ('mick', 22);");
    $dbh->exec("INSERT INTO `test`.`table` (`name` ,`age`)VALUES ('lily', 29);");
    $dbh->exec("INSERT INTO `test`.`table` (`name` ,`age`)VALUES ('susan', 21);");
    $dbh->commit();
     
    } catch (Exception $e) {
    $dbh->rollBack();
    echo "Failed: " . $e->getMessage();
    }
    ?>
    
**PDOException**

PDO 提供了3中不同的错误处理策略。

>1. PDO::ERRMODE_SILENT

这是默认使用的模式。PDO会在statement和database对象上设定简单的错误代号，你可以使用PDO->errorCode() 和 PDO->errorInfo() 方法检查错误；如果错误是在对statement对象进行调用时导致的，你就可以在那个对象上使用 PDOStatement->errorCode() 或 PDOStatement->errorInfo() 方法取得错误信息。而如果错误是在对database对象调用时导致的，你就应该在这个database对象上调用那两个方法。

>2. PDO::ERRMODE_WARNING

作为设置错误代号的附加，PDO将会发出一个传统的E_WARNING信息。这种设置在除错和调试时是很有用的，如果你只是想看看发生了什么问题而不想中断程序的流程的话。

>3. PDO::ERRMODE_EXCEPTION

作为设置错误代号的附件，PDO会抛出一个PDOException异常并设置它的属性来反映错误代号和错误信息。这中设置在除错时也是很有用的，因为他会有效的“放大（blow up）”脚本中的出错点，非常快速的指向一个你代码中可能出错区域。（记住：如果异常导致脚本中断，事务处理回自动回滚。）
异常模式也是非常有用的，因为你可以使用比以前那种使用传统的PHP风格的错误处理结构更清晰的结构处理错误，比使用安静模式使用更少的代码及嵌套，也能够更加明确地检查每个数据库访问的返回值。

    <?php
    // 修改默认的错误显示级别
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    ?>
    
---

**PDO常用方法：**

    PDO::query() 主要用于有记录结果返回的操作，特别是select操作。
    PDO::exec()主要是针对没有结果集合返回的操作。如insert,update等操作。返回影响行数。
    PDO::lastInsertId()返回上次插入操作最后一条ID，但要注意：如果用insert into tb(col1,col2)values(v1,v2),(v11,v22)..的方式一次插入多条记录，lastinsertid()返回的只是第一条(v1,v2)插入时的ID,而不是最后一条记录插入的记录ID。
    PDOStatement::fetch()是用来获取一条记录。配合while来遍历。
    PDOStatement::fetchAll()是获取所有记录集到一个中。
    PDOStatement::fetchcolumn([intcolumn_indexnum])用于直接访问列，参数column_indexnum是该列在行中的从0开始索引值，但是，这个方法一次只能取得同一行的一列，只要执行一次，就跳到下一行。因此，用于直接访问某一列时较好用，但要遍历多列就用不上。
    PDOStatement::rowcount()适用于当用query("select...")方法时，获取记录的条数。也可以用于预处理中。$stmt->rowcount();
    PDOStatement::columncount()适用于当用query("select...")方法时，获取记录的列数。
    
**注解：**

1. 选fetch还是fetchall？

    小记录集时，用fetchall效率高，减少从数据库检索次数，但对于大结果集，用fetchall则给系统带来很大负担。数据库要向WEB前端传输量太大反而效率低。

2. fetch()或fetchall()有几个参数：

    mixed pdostatement::fetch([int fetch_style[,int cursor_orientation [,int cursor_offset]]])
    array pdostatement::fetchAll(int fetch_style)
    
---

**更多的PDO方法：**

    PDO::beginTransaction — 启动一个事务  
    PDO::commit — 提交一个事务  
    PDO::__construct — 创建一个表示数据库连接的 PDO 实例  
    PDO::errorCode — 获取跟数据库句柄上一次操作相关的 SQLSTATE  
    PDO::errorInfo — Fetch extended error information associated with the last operation on the database handle  
    PDO::exec — 执行一条 SQL 语句，并返回受影响的行数  
    PDO::getAttribute — 取回一个数据库连接的属性  
    PDO::getAvailableDrivers — 返回一个可用驱动的数组  
    PDO::inTransaction — 检查是否在一个事务内  
    PDO::lastInsertId — 返回最后插入行的ID或序列值  
    PDO::prepare — Prepares a statement for execution and returns a statement object  
    PDO::query — Executes an SQL statement, returning a result set as a PDOStatement object  
    PDO::quote — Quotes a string for use in a query.  
    PDO::rollBack — 回滚一个事务  
    PDO::setAttribute — 设置属性
    
    Exception::getMessage — 获取异常消息内容。  
    Exception::getPrevious — 返回异常链中的前一个异常  
    Exception::getCode — 获取异常代码  
    Exception::getFile — 获取发生异常的程序文件名称  
    Exception::getLine — 获取发生异常的代码在文件中的行号  
    Exception::getTrace — 获取异常追踪信息  
    Exception::getTraceAsString — 获取字符串类型的异常追踪信息  
    Exception::toString — 将异常对象转换为字符串  
    Exception::clone — 异常克隆
    
**属性列表：**

    PDO::PARAM_BOOL
    表示一个布尔类型
    PDO::PARAM_NULL
    表示一个SQL中的NULL类型
    PDO::PARAM_INT
    表示一个SQL中的INTEGER类型
    PDO::PARAM_STR
    表示一个SQL中的SQL CHAR，VARCHAR类型
    PDO::PARAM_LOB
    表示一个SQL中的large object类型
    PDO::PARAM_STMT
    表示一个SQL中的recordset类型，还没有被支持
    PDO::PARAM_INPUT_OUTPUT
    Specifies that the parameter is an INOUT parameter for a stored procedure. You must bitwise-OR this value with an explicit PDO::PARAM_* data type.
    PDO::FETCH_LAZY
    将每一行结果作为一个对象返回
    PDO::FETCH_ASSOC
    仅仅返回以键值作为下标的查询的结果集，名称相同的数据只返回一个
    PDO::FETCH_NAMED
    仅仅返回以键值作为下标的查询的结果集，名称相同的数据以数组形式返回
    PDO::FETCH_NUM
    仅仅返回以数字作为下标的查询的结果集
    PDO::FETCH_BOTH
    同时返回以键值和数字作为下标的查询的结果集
    PDO::FETCH_OBJ
    以对象的形式返回结果集
    PDO::FETCH_BOUND
    将PDOStatement::bindParam()和PDOStatement::bindColumn()所绑定的值作为变量名赋值后返回
    PDO::FETCH_COLUMN
    表示仅仅返回结果集中的某一列
    PDO::FETCH_CLASS
    表示以类的形式返回结果集
    PDO::FETCH_INTO
    表示将数据合并入一个存在的类中进行返回
    PDO::FETCH_FUNC
    PDO::FETCH_GROUP
    PDO::FETCH_UNIQUE
    PDO::FETCH_KEY_PAIR
    以首个键值下表，后面数字下表的形式返回结果集
    PDO::FETCH_CLASSTYPE
    PDO::FETCH_SERIALIZE
    表示将数据合并入一个存在的类中并序列化返回
    PDO::FETCH_PROPS_LATE
    Available since PHP 5.2.0
    PDO::ATTR_AUTOCOMMIT
    在设置成true的时候，PDO会自动尝试停止接受委托，开始执行
    PDO::ATTR_PREFETCH
    设置应用程序提前获取的数据大小，并非所有的数据库哦度支持
    PDO::ATTR_TIMEOUT
    设置连接数据库超时的值
    PDO::ATTR_ERRMODE
    设置Error处理的模式
    PDO::ATTR_SERVER_VERSION
    只读属性，表示PDO连接的服务器端数据库版本
    PDO::ATTR_CLIENT_VERSION
    只读属性，表示PDO连接的客户端PDO驱动版本
    PDO::ATTR_SERVER_INFO
    只读属性，表示PDO连接的服务器的meta信息
    PDO::ATTR_CONNECTION_STATUS
    PDO::ATTR_CASE
    通过PDO::CASE_*中的内容对列的形式进行操作
    PDO::ATTR_CURSOR_NAME
    获取或者设定指针的名称
    PDO::ATTR_CURSOR
    设置指针的类型，PDO现在支持PDO::CURSOR_FWDONLY和PDO::CURSOR_FWDONLY
    PDO::ATTR_DRIVER_NAME
    返回使用的PDO驱动的名称
    PDO::ATTR_ORACLE_NULLS
    将返回的空字符串转换为SQL的NULL
    PDO::ATTR_PERSISTENT
    获取一个存在的连接
    PDO::ATTR_STATEMENT_CLASS
    PDO::ATTR_FETCH_CATALOG_NAMES
    在返回的结果集中，使用自定义目录名称来代替字段名。
    PDO::ATTR_FETCH_TABLE_NAMES
    在返回的结果集中，使用自定义表格名称来代替字段名。
    PDO::ATTR_STRINGIFY_FETCHES
    PDO::ATTR_MAX_COLUMN_LEN
    PDO::ATTR_DEFAULT_FETCH_MODE
    Available since PHP 5.2.0
    PDO::ATTR_EMULATE_PREPARES
    Available since PHP 5.1.3.
    PDO::ERRMODE_SILENT
    发生错误时不汇报任何的错误信息，是默认值
    PDO::ERRMODE_WARNING
    发生错误时发出一条php的E_WARNING的信息
    PDO::ERRMODE_EXCEPTION
    发生错误时抛出一个PDOException
    PDO::CASE_NATURAL
    回复列的默认显示格式
    PDO::CASE_LOWER
    强制列的名字小写
    PDO::CASE_UPPER
    强制列的名字大写
    PDO::NULL_NATURAL
    PDO::NULL_EMPTY_STRING
    PDO::NULL_TO_STRING
    PDO::FETCH_ORI_NEXT
    获取结果集中的下一行数据，仅在有指针功能时有效
    PDO::FETCH_ORI_PRIOR
    获取结果集中的上一行数据，仅在有指针功能时有效
    PDO::FETCH_ORI_FIRST
    获取结果集中的第一行数据，仅在有指针功能时有效
    PDO::FETCH_ORI_LAST
    获取结果集中的最后一行数据，仅在有指针功能时有效
    PDO::FETCH_ORI_ABS
    获取结果集中的某一行数据，仅在有指针功能时有效
    PDO::FETCH_ORI_REL
    获取结果集中当前行后某行的数据，仅在有指针功能时有效
    PDO::CURSOR_FWDONLY
    建立一个只能向后的指针操作对象
    PDO::CURSOR_SCROLL
    建立一个指针操作对象，传递PDO::FETCH_ORI_*中的内容来控制结果集
    PDO::ERR_NONE (string)
    设定没有错误时候的错误信息
    
    <?php  
    $dbh = new PDO('mysql:host=localhost;dbname=access_control', 'root', '');    
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
    $dbh->exec('set names utf8');   
    /*添加*/ 
    //$sql = "INSERT INTO `user` SET `login`=:login AND `password`=:password";   
    $sql = "INSERT INTO `user` (`login` ,`password`)VALUES (:login, :password)";  $stmt = $dbh->prepare($sql);  $stmt->execute(array(':login'=>'kevin2',':password'=>''));    
    echo $dbh->lastinsertid();    
    /*修改*/ 
    $sql = "UPDATE `user` SET `password`=:password WHERE `user_id`=:userId";    
    $stmt = $dbh->prepare($sql);    
    $stmt->execute(array(':userId'=>'7', ':password'=>'4607e782c4d86fd5364d7e4508bb10d9'));    
    echo $stmt->rowCount();   
    /*删除*/ 
    $sql = "DELETE FROM `user` WHERE `login` LIKE 'kevin_'"; //kevin%    
    $stmt = $dbh->prepare($sql);    
    $stmt->execute();    
    echo $stmt->rowCount();    
    /*查询*/ 
    $login = 'kevin%';    
    $sql = "SELECT * FROM `user` WHERE `login` LIKE :login";    
    $stmt = $dbh->prepare($sql);    
    $stmt->execute(array(':login'=>$login));    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){       
     print_r($row);    
    }    
    print_r( $stmt->fetchAll(PDO::FETCH_ASSOC));   
    ?>
