<?php
$mysqli = new mysqli("qdm210374521.my3w.com", "qdm210374521", "db1600online", "qdm210374521_db");
if (mysqli_connect_errno()) {
  echo '数据库连接错误'.mysqli_connect_error();
  exit();
}

$stmt = $mysqli->prepare("select count(1) from students where phone_num=?");
$stmt->bind_param("s", trim($_GET['phone_num']));
$stmt->execute();
$stmt->bind_result($C);
$stmt->fetch();
$mysqli->close();

if ($C > 0) {
  $valid = true;
} else {
  $valid = false;
}
echo "{valid: $valid }";
?>
