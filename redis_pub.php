<?php
set_time_limit(0);
$redis = new \Redis();
$redis->connect("192.168.47.215",6379);
$redis->setOption(Redis::OPT_READ_TIMEOUT, -1);

$channel = $argv[1];
if(empty($channel))
{
	echo "argument missing : need channel nam\r\n";
	exit();
}

try {
    $dbh = new PDO('mysql:host=192.168.47.211;dbname=test', "root", "a123456");
//    foreach($dbh->query('SELECT * from FOO') as $row) {
//        print_r($row);
//    }
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

$redis->subscribe(array($channel),function($redis,$channel,$message){
	echo $channel,"==>",$message,PHP_EOL;
});
?>
