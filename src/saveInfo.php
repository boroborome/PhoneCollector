<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <title>登记结果</title>
  </head>
  <body>
    <?php
    $mysqli = new mysqli("qdm210374521.my3w.com", "qdm210374521", "db1600online", "qdm210374521_db");
    if (mysqli_connect_errno()) {
      echo '数据库连接错误'.mysqli_connect_error();
      exit();
    }
    mysqli_query($mysqli, "set character set 'utf8'");
    mysqli_query($mysqli, "set names 'utf8'");

    $parent_name=trim($_POST['parent_name']);
    $phone_num=trim($_POST['phone_num']);
    $baby_name=trim($_POST['baby_name']);
    $baby_age=$_POST['baby_age'];
    $referrer=trim($_POST['referrer']);

    $stmt = $mysqli->prepare("select count(1) from students where phone_num=?");
    $stmt->bind_param("s", $phone_num);
    $stmt->execute();
    $stmt->bind_result($C);
    $stmt->fetch();
    $stmt->close();
    ?>
    <table border="0">
      <tr>
        <td>家长称呼：</td><td><?php echo $parent_name ?></td>
      </tr>
      <tr>
        <td>联系方式：</td><td><?php echo $phone_num ?></td>
      </tr>
      <tr>
        <td>宝贝名称：</td><td><?php echo $baby_name ?></td>
      </tr>
      <tr>
        <td>宝贝年龄：</td><td><?php echo $baby_age ?></td>
      </tr>
    </table>
    <?php

    if ($C > 0) {
      echo "<h1>电话号码$phone_num 已经存在了<br><a href='#' onclick='window.history.go(-1)'>重新填写</a></h1>";
    } else {
      $stmt = $mysqli->prepare("insert into students(parent_name,baby_name,phone_num,baby_age,updater) values(?,?,?,?,?)");
      $stmt->bind_param("sssds", $parent_name, $baby_name, $phone_num, $baby_age, $referrer);
      $stmt->execute();
      echo "<h1>恭喜注册成功</h1>";
    }
    $mysqli->close();
    ?>
  </body>
</html>
