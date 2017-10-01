<form id="Form1" method="POST" enctype="multipart/form-data"
	class="form-horizontal">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<?php echo  MenuUtil::getMenuName($_SERVER['REQUEST_URI'])?>
					</div>
					<div class="actions"></div>
				</div>
				<div class="portlet-body">

					<table class="table table-striped table-hover table-bordered" id="gvResult">
						<thead>
							<tr>
								<th width="5%">#</th>
								<th width="20%">video ที่เล่น</th>
								<th width="10%">Mac Address</th>
								<th width="20%">Hot SpotName</th>
								<th width="20%">Create Date</th>
							</tr>
						</thead>
						<tbody>
	<?php
	$counter = 1;
	$dataProvider = $data->search ();
	
	foreach ( $dataProvider->data as $data ) {
		?>
				<tr class="line-<?php echo $counter%2 == 0 ? '1' : '2'?>">
								<td class="center"><?php echo $counter;?></td>
								<td class="center"><?php echo $data->ad_plan->name?></td>
								<td class="center"><?php echo $data->play_from_mac?></td>
								<td class="center"><?php echo $data->hotspot_name?></td>
								<td class="center"><?php echo $data->create_date?></td>

							</tr>
			<?php
		$counter ++;
	}
	?>
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>

	<script
		src="<?php echo ConfigUtil::getAppName();?>/assets/global/plugins/jquery.min.js"
		type="text/javascript"></script>
	<script>
jQuery(document).ready(function () {
	var table = $('#gvResult');
	
	var oTable = table.dataTable({

	    // Internationalisation. For more info refer to http://datatables.net/manual/i18n
	    "language": {
	        "aria": {
	            "sortAscending": ": activate to sort column ascending",
	            "sortDescending": ": activate to sort column descending"
	        },
	        "emptyTable": "ไม่พบข้อมูล",
	        "info": "แสดง  _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
	        "infoEmpty": "No entries found",
	        "infoFiltered": "(filtered1 from _MAX_ total entries)",
	        "lengthMenu": "แสดงข้อมูล  _MENU_ รายการ",
	        "search": "ใส่คำที่ต้องการค้นหา:",
	        "zeroRecords": "ไม่พบรายการที่ค้นหา"
	    },
//         buttons: [
//                   { extend: 'print', className: 'btn dark btn-outline' },
//                   { extend: 'pdf', className: 'btn green btn-outline' },
//                   { extend: 'excel', className: 'btn yellow btn-outline ' },
//               ],

	    // setup responsive extension: http://datatables.net/extensions/responsive/
	    responsive: true,

	    //"ordering": false, disable column ordering 
	    //"paging": false, disable pagination

	    "order": [
	        [0, 'asc']
	    ],
	    
	    "lengthMenu": [
	        [5, 10, 15, 20, -1],
	        [5, 10, 15, 20, "ทั้งหมด"] // change per page values here
	    ],
	    // set the initial value
	    "pageLength": 10 ,
	    "columnDefs": [ {
	        "targets": 'no-sort',
	        "orderable": false,
	  } ]
		});

});

</script>

</form>

