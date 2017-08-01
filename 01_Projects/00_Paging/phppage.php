	1. 数据库连接及参数设定
	//数据库连接
	$mysqli = new mysqli("localhost","root","91392821","php");
	$mysqli -> query("SET CHARACTER SET 'utf8'");

	//每页显示的留言数
	$pagesize = 4;
	
	2. 输出当前页数据
	//确定当前页数$p参数
	$p = $_GET['p']?$_GET['p']:1;

	//数据指针
	$offset = ($p-1)*$pagesize;

	//查询本页显示的数据
	$query_sql = "SELECT * FROM GUESTTABLE ORDER BY IDS DESC LIMIT $offset, $pagesize";
	$result = $mysqli -> query($query_sql);

	//报错追踪
	if (!$result) {
		printf("Error: %s\n", mysqli_error($mysqli));
		exit();
	}
	
	//循环输出
	while ($gblist = mysqli_fetch_array($result)) {
		echo '<a href = "',$gblist["NICKNAME"],'">',$gblist["NICKNAME"],'</a>';
		echo '发表于：',date("Y-m-d H:i",$gblist["CREATETIME"]),'<br/>';
		echo '内容：',$gblist["CONTENT"],'<br/><hr/>';
	}
	
	
	3. 输出分页格式
	//分页代码
	//计算留言总数
	$count_result = $mysqli -> query('SELECT COUNT(*) AS COUNT FROM GUESTTABLE');
	$count_array = mysqli_fetch_array($count_result);

	//计算总页数
	$pagenum = ceil($count_array['COUNT']/$pagesize);
	echo '共 ',$count_array['COUNT'],' 条留言';

	//循环输出各页数目及连接
	if ($pagenum > 1) {
		for ($i=0; $i <= $pagenum; $i++) { 
			if ($i == $p) {
				echo '[',$i,']';
			}else {
				echo '<a href="',htmlspecialchars($_SERVER['PHP_SELF']),'?p=',$i,'">',$i,'</a>';
			}
		}
}
