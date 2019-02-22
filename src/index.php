<!doctype html>
<?php
$status = "";
function saveInfoToDb($parent_name, $phone_num, $baby_name, $baby_age, $try_class, $referrer) {
  global $status;
  define('ABSPATH', dirname(__FILE__) . '/');
  require_once(ABSPATH . 'config.php');
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
  if (mysqli_connect_errno()) {
    echo '数据库连接错误'.mysqli_connect_error();
    exit();
  }
  mysqli_query($mysqli, "set character set 'utf8'");
  mysqli_query($mysqli, "set names 'utf8'");

  $stmt = $mysqli->prepare("select count(1) from students where phone_num=?");
  $stmt->bind_param("s", $phone_num);
  $stmt->execute();
  $stmt->bind_result($C);
  $stmt->fetch();
  $stmt->close();

  if ($C > 0) {
    $status = "电话号码已经存在了";
  } else {
    $stmt = $mysqli->prepare("insert into students(parent_name,baby_name,phone_num,baby_age,try_class, updater) values(?,?,?,?,?,?)");
    $stmt->bind_param("sssdss", $parent_name, $baby_name, $phone_num, $baby_age, $try_class, $referrer);
    $stmt->execute();
    $status = "Success";
  }
  $mysqli->close();
}

$parent_name=trim($_POST['parent_name']);
$phone_num=trim($_POST['phone_num']);
$baby_name=trim($_POST['baby_name']);
$baby_age=$_POST['baby_age'];
$try_class=$_POST['try_class'];
$referrer=trim($_POST['referrer']);

if (!empty($parent_name)
  && !empty($phone_num)
  && !empty($baby_name)
  && !empty($baby_age)) {
    saveInfoToDb($parent_name, $phone_num, $baby_name, $baby_age, $try_class, $referrer);
}

?>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>在巴仑思成长</title>
<meta name="keywords" content="巴仑思教育,初中高考辅导">
<meta name="description" content="巴仑思教育辅导报名活动">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- bootstrap -->
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.3.3.7.css">
<!-- css -->
<link type="text/css" rel="stylesheet" href="css/style.css">
</head>

<body onload="initialPage()">
  <script type="text/javascript">
  function getURLParameter(sParam) {
  var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
      var sParameterName = sURLVariables[i].split('=');
      if (sParameterName[0] == sParam) {
        return sParameterName[1];
      }
    }
  }
  function checkform() {
    if (!(checkNotEmpty("parent_name", "家长称呼")
      && checkNotEmpty("phone_num", "联系手机")
      && checkNotEmpty("baby_name", "宝贝名称")
      && checkNotEmpty("baby_age", "宝贝年龄"))) {
      return false;
    }

    var phone_num = document.getElementById("phone_num").value;
    if (!phone_num.match(/(^1\d{10}$)/ig)) {
      alert("请填写有效的联系手机");
      return false;
    }

    var baby_age = document.getElementById("baby_age").value;
    if (!baby_age.match(/(^\d+$)/ig)) {
      alert("请填写有效的宝贝年龄");
      return false;
    }
    var age = parseInt(baby_age);
    if (age > 20) {
      alert("请填写有效的宝贝年龄");
      return false;
    }
    return true;
  }
  function checkNotEmpty(elementName, name) {
    var value = document.getElementById(elementName).value;
    if (value == null || value.trim() == "") {
      alert("请填写有效的：" + name);
      return false;
    }
    return true;
  }
  function initialPage() {
    var referrer = getURLParameter('referrer');
    if (referrer != null && referrer != "") {
      document.getElementById("referrer").value = referrer;
    }
  }
  </script>
  <div class="container">
  	<div class="row">
  		<div class="col-md-12 col-sm-12">
  			<div class="bj">
  				<div class="a-banner">
  					<img src="images/banner.jpeg">
  				</div>
  				<div class="a-form">
  					<form action="index.php" method="POST" onsubmit="return checkform()">
  					  <div class="a-form-content">
  					    <h3><?php
                $disabled = "";
                if ($status == "") {
                  echo "立即报名";
                } else if ($status == "Success") {
                  echo "恭喜:报名成功!";
                  $disabled = "disabled";
                } else {
                  echo $status;
                }
                ?></h3>
  					  	<input id="parent_name" name="parent_name" type="text" placeholder="家长称呼"
                  value="<?php echo $parent_name ?>"
                  <?php echo $disabled ?>>
  					  	<input id="phone_num" name="phone_num" type="text" placeholder="联系手机"
                  value="<?php echo $phone_num ?>"
                  <?php echo $disabled ?>>
  					  	<input id="baby_name" name="baby_name" type="text" placeholder="宝贝名称"
                  value="<?php echo $baby_name ?>"
                  <?php echo $disabled ?>>
  					  	<input id="baby_age" name="baby_age" type="text" placeholder="宝贝年龄"
                  value="<?php echo $baby_age ?>"
                  <?php echo $disabled ?>>
                <input id="try_class" name="try_class" type="text" placeholder="试听科目"
                  value="<?php echo $try_class ?>"
                  <?php echo $disabled ?>>
                <input type="hidden" id="referrer" name="referrer" value="<?php echo $referrer ?>"/>
  					  	<button class="a-submit" <?php echo $disabled ?>>
                  <?php
                  if ($disabled != "") {
                    echo "已经领取课程";
                  } else {
                    echo "领取免费课程";
                  }
                  ?></button>
  					  </div>
  					</form>
  				</div>
  				<div class="a-footer">
  					<img src="images/footer.png">
  				</div>
  			</div>
  		</div>
  	</div>
  </div>
<?php
if ($disabled != "") {
  ?>
  <div class="white_content">
  	<img src="images/success.png" style="width: 100%;height: auto;">
  </div>
  <div class="black_overlay"></div>
  <?php
}
?>
</body>
</html>
