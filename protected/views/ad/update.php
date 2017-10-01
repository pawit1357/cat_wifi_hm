
<form id="Form1" method="post" enctype="multipart/form-data"
	class="form-horizontal">

	<div class="portlet box blue">
		<div class="portlet-title">
			<div class="caption">
				<?php echo  MenuUtil::getMenuName($_SERVER['REQUEST_URI'])?>

			</div>
			<div class="actions">
			<?php echo CHtml::link('ย้อนกลับ',array('Ad/'),array('class'=>'btn btn-default btn-sm'));?>
			</div>
		</div>
		<div class="portlet-body form">
			<div class="form-body">
				<!-- BEGIN FORM-->
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
							<label class="control-label col-md-3">ชื่อวีดิโอ:<span
								class="required">*</span></label>
							<div class="col-md-8">
								<input class="form-control placeholder-no-fix" type="text"
									placeholder="" name="AdPlan[name]"
									value='<?php echo $model->name?>' />
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
							<label class="control-label col-md-3">ไฟล์วิดีโอ: </label>

							<div class="col-md-3">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="input-group input-large">
										<div
											class="form-control uneditable-input input-fixed input-large"
											data-trigger="fileinput">
											<i class="fa fa-file fileinput-exists"></i>&nbsp; <span
												class="fileinput-filename"></span>
										</div>
										
										<span class="input-group-addon btn default btn-file"> <span
											class="fileinput-new">Select file </span> <span
											class="fileinput-exists">Change </span> <!--<asp:FileUpload ID="btnUpload" runat="server" /> -->
													<input type="file" id="fileUpload" name="fileUpload"
											name="files[]">
										</span> 
										
										<a href="javascript:;"
											class="input-group-addon btn red fileinput-exists"
											data-dismiss="fileinput">Remove </a>

									</div>
								</div>
<a href=""></a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
							<label class="control-label col-md-3">ความยาว (วินาที):<span
								class="required">*</span></label>
							<div class="col-md-8">
								<input class="form-control placeholder-no-fix" type="text"
									placeholder="" name="AdPlan[vedio_time]"
									value='<?php echo $model->vedio_time?>' />
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
							<label class="control-label col-md-3">เวลาเริ่มต้น:<span
								class="required">*</span></label>
							<div class="col-md-8">
								<input type="text" id="start_date" name="AdPlan[start_date]"
									value="<?php echo CommonUtil::getDateThai($model->start_date);?>" />

							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
							<label class="control-label col-md-3">เวลาสิ้นสุด:<span
								class="required">*</span></label>
							<div class="col-md-8">
								<input type="text" id="end_date" name="AdPlan[end_date]"
									value="<?php echo CommonUtil::getDateThai($model->end_date);?>" />


							</div>
						</div>
					</div>
				</div>
				<br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>
			</div>
			<div class="form-actions">
				<div class="row">
					<div class="col-md-8">
						<div class="row">
							<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn green uppercase"><?php echo ConfigUtil::getBtnSaveButton();?></button>
								<?php echo CHtml::link(ConfigUtil::getBtnCancelButton(),array('Ad/'),array('class'=>'btn btn-default uppercase'));?>
								
<!-- 								<button type="reset" class="btn default uppercase">Cencel</button> -->
							</div>
						</div>
					</div>
					<div class="col-md-8"></div>
				</div>
			</div>
			<!-- END FORM-->
		</div>
	</div>
	<script
		src="<?php echo ConfigUtil::getAppName();?>/assets/global/plugins/jquery.min.js"
		type="text/javascript"></script>

	<script>
// 	var host = 'http://localhost:81/mu_rad';
    jQuery(document).ready(function () {

		 $.datepicker.regional['th'] ={
			        changeMonth: true,
			        changeYear: true,
			        //defaultDate: GetFxupdateDate(FxRateDateAndUpdate.d[0].Day),
			        yearOffSet: 543,
			        showOn: "button",
			        buttonImage: '/wifi_hm/images/calendar.gif',
			        buttonImageOnly: true,
			        dateFormat: 'dd/mm/yy',
			        dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
			        dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
			        monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
			        monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
			        constrainInput: true,
			       
			        prevText: 'ก่อนหน้า',
			        nextText: 'ถัดไป',
			        yearRange: '-20:+20',
			        buttonText: 'เลือก',
			      
			    };
		    
			$.datepicker.setDefaults($.datepicker.regional['th']);
			
	    $( "#start_date" ).datepicker( $.datepicker.regional["th"] ); // Set ภาษาที่เรานิยามไว้ด้านบน
	    $( "#end_date" ).datepicker( $.datepicker.regional["th"] ); // Set ภาษาที่เรานิยามไว้ด้านบน

    });
	    </script>
</form>