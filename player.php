<?php
$mac = $_POST['mac'];
$ip = $_POST['ip'];
$username = $_POST['username'];
$password = $_POST['password'];
$linklogin = $_POST['link-login'];
$linkorig = $_POST['link-orig'];
$error = $_POST['error'];
$chapid = $_POST['chap-id'];
$chapchallenge = $_POST['chap-challenge'];
$linkloginonly = $_POST['link-login-only'];
$linkorigesc = $_POST['link-orig-esc'];
$macesc = $_POST['mac-esc'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Hotspot : login</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="expires" content="-1" />


<!-- BEGIN CORE PLUGINS -->
<script src="/wifi_hm/assets/global/plugins/jquery.min.js"
	type="text/javascript"></script>
<link rel="stylesheet" href="css/style.css"></link>

<script type="text/javascript" src="./js/md5.js"></script>
<script type="text/javascript">
 		var host = 'http://122.155.32.5/wifi_hm';
		
		
		$(document).ready(function() {
			$("#div-register").hide();
			$("#div-vedio").hide();
			checkRegister();
				     	
			var video = document.getElementById('my-video');
			video.addEventListener('ended',loadVedioHandler,false);
			video.addEventListener('loadeddata', function() {
				   // Video is loaded and can be played
				console.log("Video Duration: "+ video.duration);
				}, false);

			var supposedCurrentTime = 0;
			video.addEventListener('timeupdate', function() {
			  if (!video.seeking) {
			        supposedCurrentTime = video.currentTime;
			  }
			});
			// prevent user from seeking
			video.addEventListener('seeking', function() {
			  // guard agains infinite recursion:
			  // user seeks, seeking is fired, currentTime is modified, seeking is fired, current time is modified, ....
			  var delta = video.currentTime - supposedCurrentTime;
			  if (Math.abs(delta) > 0.01) {
			    console.log("Seeking is disabled");
			    video.currentTime = supposedCurrentTime;
			  }
			});
			// delete the following event handler if rewind is not required
			video.addEventListener('ended', function() {
			  // reset state in order to allow for rewind
			    supposedCurrentTime = 0;
			});
		    
		});

		function enterFullScreen(id) {
		    var element = document.getElementById(id);
		    element.parentNode.webkitRequestFullScreen();           
		    element.style.height = screen.height;
		    element.style.width = screen.width;
		}


		function checkRegister(){
			$
			.ajax({
				url : host+"/index.php/AjaxRequest/CheckRegister",
				type : "GET",
				
				data: { mac: '<?php echo $mac; ?>'},
				dataType : "json",
				success : function(result) {
					if(result.id == null){
						$("#div-register").show();
						$("#div-vedio").hide();
					}else{
						$("#div-register").hide();
						$("#div-vedio").show();
						loadVedio();
					}
				},
				error : function(xhr, ajaxOptions, thrownError) {
				}
			});
		}
		function doRegsiter() {

		    var _cid = $("#txtCid").val();
		    var _phone = $("#txtPhone").val();
		    if(_cid == ''){
		        alert('ID Card No., Pls./โปรดระบุเลขบัตรประจำตัวประชาชน');
				return false;
		    }
		    if(_phone == ''){
		    	alert('Mobile No., Pls.โปรดระบุหมายเลขโทรศัพท์');
				return false;
		    }
		    
			$.ajax({
				url : host+"/index.php/AjaxRequest/Register",
				type : "GET",
				data: { mac: '<?php echo $mac; ?>',cid:$("#txtCid").val(), phone: $("#txtPhone").val() },
				dataType : "json",
				success : function(result) {
					alert('Success/ลงทะเบียนเรียบร้อยแล้ว');
					$("#div-register").hide();
					$("#div-vedio").show();
					loadVedio();

					
				},
				error : function(xhr, ajaxOptions, thrownError) {
				}
			});


		}
		function loadVedio(){
			$
			.ajax({
				url : host+"/index.php/AjaxRequest/MovieContent",
				type : "GET",
				data: { mac: '<?php echo $mac; ?>', phone: 'HOT-SPOT-01' },
				dataType : "json",
				success : function(result) {
					var src = result.file_path.replace("\","/ "");
					
					var video = document.getElementById('my-video');
					video.setAttribute("src", host+src);
					video.load();
					play();
					
				},
				error : function(xhr, ajaxOptions, thrownError) {
				}
			});
		}
		
		function play(){
	
					var video = document.getElementById('my-video');
					video.play();
		}
		
		function loadVedioHandler(e) {
			if (!e) {
				e = window.event;
			}
			doLogin();
			return false;
		}
		
	    function doLogin() {
		    
	    	<?php if(strlen($chapid) < 1) echo "return true;\n"; ?>
		document.sendin.username.value = "peera";
		document.sendin.password.value = hexMD5('<?php echo $chapid; ?>' +'peera' + '<?php echo $chapchallenge; ?>');
		document.sendin.submit();
		return false;
	    }


	    
	    



	</script>
</head>

<body class=" login">

	<form name="sendin" action="<?php echo $linkloginonly; ?>"
		method="post">
		<input type="hidden" name="username" /> <input type="hidden"
			name="password" /> <input type="hidden" name="dst"
			value="<?php echo $linkorig; ?>" /> <input type="hidden" name="popup"
			value="true" />
	</form>





	<div class="row">
		<div id="div-register">
			<h1>ADS Wi-Fi Hotspot Register</h1>
			<h1>ลงทะเบียนใช้งานระบบ</h1>
			<form name="reg" method="post" action="player.php">
				<p>
					ID Card No./เลขบัตรประชาชน<font size="3" color="red">*</font><br> <input
						type="text" id="txtCid" name="txtCid" value=""
						placeholder="">
				
				</p>
				<p>
					Mobile No./หมายเลขโทรศัพท์<font size="3" color="red">*</font><br> <input
						type="text" id="txtPhone" name="txtPhone" value="" placeholder="">
				
				</p>

				<p class="submit">
					<input type="button" onClick="doRegsiter()" value="Submit">
					<input type="reset" value="Clear">
				
				</p>
			</form>
		</div>
		<div class="col-md-12" id="div-vedio">
			<div class="note note-success">
				<p style="font-size: 180%; color:orange;">ADS Wi-Fi Hotspot</p>
				</div>
			<!-- BEGIN SAMPLE TABLE PORTLET-->
			<div class="portlet box green">

				<video id="my-video" width="100%" controls="false"
					webkit-playsinline controls controlsList="nodownload"> </video>
				<br></br>
				<p style="font-size: 180%; color:orange;">Pls watch VDO for internet access/กรุณาดูวิดีโอเพื่อเข้าใช้งานอินเตอร์เน็ต</p>
			
				<div class="form-actions">
					<button id="register-submit-btn" name="register-submit-btn"
						class="btn btn-success uppercase pull-right" onclick="play()">PLAY</button>
				</div>
			</div>
		</div>
	</div>

</body>
</html>