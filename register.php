<?php 
$mac = $_GET ['player_mac'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Login Form</title>
<link rel="stylesheet" href="css/style.css">
<script src="/wifi_hm/assets/global/plugins/jquery.min.js"
	type="text/javascript"></script>


<script type="text/javascript" src="./js/md5.js"></script>
<script type="text/javascript">
var host = 'http://localhost/wifi_hm';
//	var host = 'http://122.155.32.5/wifi_hm';
$(document).ready(function() {
});

function doLogin() {

    var _cid = $("#txtCid").val();
    var _phone = $("#txtPhone").val();
    if(_cid == ''){
        alert('โปรดระบุเลขบัตรประจำตัวประชาชน');
		return false;
    }
    if(_phone == ''){
    	alert('โปรดระบุเบอร์ติดต่อ');
		return false;
    }
    
	$.ajax({
		url : host+"/index.php/AjaxRequest/Register",
		type : "GET",
		data: { mac: '<?php echo $mac; ?>',cid:$("#txtCid").val(), phone: $("#txtPhone").val() },
		dataType : "json",
		success : function(result) {
			alert('ลงทะเบียนเรียบร้อยแล้ว');
			//window.location.replace(host+"/player.php");
			document.reg.submit();
			
		},
		error : function(xhr, ajaxOptions, thrownError) {
		}
	});


}

</script>

</head>
<body>

		<section class="container">
			<div class="login">
				<h1>ลงทะเบียนใช้งานระบบ</h1>
				<form name="reg" method="post" action="player.php">
					<p>
						เลขบัตรประชาชน<font size="3" color="red">*</font><br> <input type="text" id="txtCid" name="txtCid"
							value="" placeholder="mac:<?php echo $mac; ?>">
					</p>
					<p>
						เบอร์ติดต่อ<font size="3" color="red">*</font><br> <input type="text" id="txtPhone" name="txtPhone"
							value="" placeholder="">
					</p>

					<p class="submit">
						<input type="button" onClick="doLogin()" value="Submit">
					</p>
				</form>
			</div>
		</section>
</body>
</html>
