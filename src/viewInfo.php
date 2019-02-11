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

    $phone_num=trim($_GET['phone_num']);

    $stmt = $mysqli->prepare("select parent_name,baby_name,phone_num,baby_age,updater,create_time from students where phone_num=?");
    $stmt->bind_param("s", $phone_num);
    $stmt->execute();
    $stmt->bind_result($parent_name, $baby_name, $phone_num, $baby_age, $referrer, $create_time);
    $stmt->fetch();
    $stmt->close();
    $mysqli->close();
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
      <tr>
        <td>记录时间：</td><td><?php echo $create_time ?></td>
      </tr>
    </table>
  </body>
</html>
