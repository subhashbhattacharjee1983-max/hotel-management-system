<?php 
	$this->assign('title','Dashboard');
	$this->assign('heading','Dashboard');
	$this->assign('breadcrumb','Dashboard'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Admins', 'action'=>'dashboard'])); 
	$booking_date = [];
	if(!empty($booking_reserve)){
		foreach($booking_reserve as $booking_val){
			$startDate = new DateTime($booking_val->check_in_date);
			$endDate = new DateTime($booking_val->check_out_date);

			// Add 1 day to include the end date
			$endDate->modify('+1 day');

			$interval = new DateInterval('P1D'); // 1-day interval
			$dateRange = new DatePeriod($startDate, $interval, $endDate);
			$show_rooms = $this->Common->show_rooms($booking_val->id);

			foreach ($dateRange as $date) {
				$booking_date[] = $date->format("Y-m-d")."@Rooms: ".$show_rooms;
			}
		}
	}
?>
<style type="text/css">
	.panel.btn-success > .panel-heading {
	  color: #FFFFFF;
	  background: #5cb85c;
	  border-color: #5cb85c !important;
	}
	.panel.btn-danger > .panel-heading {
	  color: #FFFFFF;
	  background: #d9534f;
	  border-color: #d9534f !important;
	}
	.dashboa-panel-heading {
		padding: 14% 0 !important;
		height: 107px;
	}
	.dashboa-panel-heading span {
		font-size: 14px;
	}
	.dashboa-panel-multiple {
		background: #f76600 !important;
		border-color: #f76600 !important;
	}
	.dashboard-panel-maintanance {
		background: #0dcaf0 !important;
		border-color: #0dcaf0 !important;
	}
</style>
<script type="text/javascript">
<!--
	$(function(){
		$(".view-booking").click(function(e){
		e.preventDefault();
		var booking_id = $(this).attr('data-id');
		var room_number = $(this).attr('data-room');
		//alert(booking_id);
		$('#myModal').modal('show');
			$.ajax({
				type:'post',
				url:"<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'showBooking'])?>",
				data:{
					booking_id:booking_id
				},
				dataType:'json',
				beforeSend:function(){
				},
				headers : {
					'X-CSRF-Token': "<?php echo $this->request->getParam('_csrfToken');?>"
				},
				success:function(response){
					//console.clear();
					//alert(response.show_view);
					
					$("#full_name").html(response.full_name);
					$("#mobile_number").html(response.mobile_number);
					$("#room_number").html(room_number);
					$("#email_address").html(response.email_address);
					$("#guest_category").html(response.guest_category);
					$("#address").html(response.address);
					$("#id_type").html(response.id_type);
					$("#id_number").html(response.id_number);
					$("#check_in_date").html(response.check_in_date);
					$("#check_out_date").html(response.check_out_date);
					$("#adults").html(response.adults);
					$("#children").html(response.children);
					$("#number_of_night").html(response.number_of_night);
					$("#room_booking_price").html(response.room_booking_price);
					$("#total_food_item_order_price").html(response.total_food_item_order_price);
					$("#total_bavarage_item_order_price").html(response.total_bavarage_item_order_price);
					$("#total_house_keeping_order_price").html(response.total_house_keeping_order_price);
					$("#total_booking_amount").html(response.total_booking_amount);
					$("#bst_tax").html(response.bst_tax);
					$("#service_tax").html(response.service_tax);
					$("#grand_total_booking_amount").html(response.grand_total_booking_amount);
					$("#total_booking_payments").html(response.total_booking_payments);
					$("#remaining_amount").html(response.remaining_amount);
					$("#show_view").html(response.show_view);
				},
				error:function(){
					//alert('ERROR');
				},
				complete: function() {
				}
			});
		});

		$(".iCheck-helper").click(function(){
			var verify_booking = $('input[type="checkbox"]:checked').length;
			if(verify_booking == 7)
			{
				$('#myButton').prop('disabled', false);
			}
			else
			{
				$('#myButton').prop('disabled', true);
			}
		});
	});

	function success_verfication(){
		var url = "<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'verify', base64_encode($booking_id), 'all_verified'])?>";
		setTimeout(function() {
		   $("#loader_section").show();
		   window.location.href=url;
		}, 1000);
	}

	function verfication_force_checkout(){
		var url = "<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'verify', base64_encode($booking_id), 'force_checkout'])?>";
		setTimeout(function() {
		   $("#loader_section").show();
		   window.location.href=url;
		}, 1000);
	}
	
//-->
</script>
<?php 
if(isset($booking_id) && $booking_id!="")
{ 
	if(!empty($booking_verify) && !empty($room_verify))
	{
?>
<script type="text/javascript">
<!--
	$(function(){
		$('#myModalVerify').modal('show');
	});
	
	function master_bill()
	{
		$('#myModalMasterBill').modal('show');
	}
//-->
</script>
<?php 
	} 
}
?>
<div id="tab-general">
	<div class="row mbl">
		<div class="col-lg-12">
		<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'add']);?>">
			<div class="col-lg-2" style="text-align:center;">
				 <div class="panel panel-grey dashboa-panel-multiple" style="border-radius: 7px !important;">
					<div class="panel-heading dashboa-panel-heading dashboa-panel-multiple" style="border-color: #f76600 !important;">Multiple Room <br /><span>Available</div>
				</div>
			</div>
		</a>
		<?php
		if(!empty($rooms))
		{
			foreach($rooms as $key => $val)
			{
				if($val->room_status == "A")
				{
		?>
		<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'add', $val->id]);?>">
			<div class="col-lg-2" style="text-align:center;">
				 <div class="panel btn-success" style="border: 5px solid #5cb85c; border-radius: 7px !important;">
					<div class="panel-heading dashboa-panel-heading">Room No: <?php echo $val->room_number ?> <br /><span><?php echo $room_status[$val->room_status] ?></span></div>
				</div>
			</div>
		</a>
		<?php
				}
				else if($val->room_status == "O")
				{
		?>
		<a href="javascript:void(0);" class="view-booking" data-id="<?php echo $val->booking_id ?>" data-room="<?php echo $val->room_number ?>">
			<div class="col-lg-2" style="text-align:center;">
				 <div class="panel btn-danger" style="border: 5px solid #d9534f; border-radius: 7px !important;">
					<div class="panel-heading dashboa-panel-heading">Room No: <?php echo $val->room_number ?> <br /><span><?php echo $room_status[$val->room_status] ?></span></div>
				</div>
			</div>
		</a>
		<?php
				}
				else if($val->room_status == "M")
				{
		?>
		<a href="javascript:void(0);">
			<div class="col-lg-2" style="text-align:center;">
				 <div class="panel panel-grey dashboard-panel-maintanance" style="border: 5px solid #d9534f;">
					<div class="panel-heading dashboa-panel-heading dashboard-panel-maintanance" style="border-color: #0dcaf0 !important;">Room No: <?php echo $val->room_number ?> <br /><span><?php echo $room_status[$val->room_status] ?></span></div>
				</div>
			</div>
		</a>
		<?php
				}
			}
		}
		?>
		</div>
	    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
	    <style type="text/css">
			#calendar {
			  max-width: 95%;
			  margin: auto;
			}
			.fc-event {
			  background-color: #e74c3c !important;
			  border: none;
			  color: white;
			  font-size: 1.2rem;
			}
			.fc .fc-toolbar-title {
				font-weight: bold;
				color: #4f158c;
			}
	    </style>
		<div class="col-lg-12">
			<h2 style="text-align:center; margin-top: 45px; color: #4f158c; font-weight: bold;">Hotel Booking Calendar</h2>
			<div id="calendar"></div>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
		<script type="text/javascript">
			document.addEventListener('DOMContentLoaded', function () {
			  const calendarEl = document.getElementById('calendar');

			  const bookedDates = [
				<?php 
				  if(!empty($booking_date)){
					foreach($booking_date as $val){
						$room_val = explode("@",$val);
				?>
					{ title: 'Booked <?php echo $room_val[1] ?>', start: '<?php echo $room_val[0] ?>' },
				<?php
					}
				}
				?>
			  ];

			  const calendar = new FullCalendar.Calendar(calendarEl, {
				initialView: 'dayGridMonth',
				height: 'auto',
				selectable: false,
				events: bookedDates
			  });

			  calendar.render();
			});
		</script>	  
	</div>
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header" style="background: #5cb85c;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-weight:bold; font-size:17px; color:#FFF;">Guest Details Room Number <span id="room_number"></span></h4>
      </div>
      <div class="modal-body">	
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-6">
					<div class="col-md-12">
						<div class="form-group" style="color: #f2994b;font-size: 19px;">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							Guest Information
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							Name: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputName" class="control-label">
								<span id="full_name"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div> 
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							Mobile Number: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputName" class="control-label">
								<span id="mobile_number"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div> 
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							Email Address: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputName" class="control-label">
								<span id="email_address"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div> 
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							Guest Category: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputName" class="control-label">
								<span id="guest_category"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div> 
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							Address: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputName" class="control-label">
								<span id="address"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div> 
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							ID Type: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputName" class="control-label">
								<span id="id_type"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div> 
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							ID Number: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputName" class="control-label">
								<span id="id_number"></span>
							</label>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="col-md-12">
						<div class="form-group" style="color: #f2994b;font-size: 19px;">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							Booking Details
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							Check In Date: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputName" class="control-label">
								<span id="check_in_date"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							Check Out Date: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputName" class="control-label">
								<span id="check_out_date"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							Adults: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputName" class="control-label">
								<span id="adults"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							Children: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputName" class="control-label">
								<span id="children"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							Number Of Night: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputName" class="control-label">
								<span id="number_of_night"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							Room Booking: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputName" class="control-label">
								<span id="room_booking_price"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							Kitchen Order: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputName" class="control-label">
								<span id="total_food_item_order_price"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							Bar Order: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputName" class="control-label">
								<span id="total_bavarage_item_order_price"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							House Keeping Order: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputName" class="control-label">
								<span id="total_house_keeping_order_price"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							Total Booking Amount: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputName" class="control-label">
								<span id="total_booking_amount"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							BST (<?php echo $site_general_settings->service_tax; ?>%): 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputName" class="control-label">
								<span id="bst_tax"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold;" for="inputName" class="control-label">
							Service Charge (<?php echo $site_general_settings->service_tax; ?>%): 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="inputName" class="control-label">
								<span id="service_tax"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold; color: #bf3773;" for="inputName" class="control-label">
							Grand Total Amount: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold; color: #bf3773;" for="inputName" class="control-label">
								<span id="grand_total_booking_amount"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold; color: #f2994b;" for="inputName" class="control-label">
							Total Payment: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold; color: #f2994b;" for="inputName" class="control-label">
								<span id="total_booking_payments"></span>
							</label>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold; color: #d9534f;" for="inputName" class="control-label">
							Balance Due: 
							</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label style="font-weight: bold; color: #d9534f;" for="inputName" class="control-label">
								<span id="remaining_amount"></span>
							</label>
						</div>
					</div>
				</div>
				<div id="show_view"></div><!-- <a href="javascript:void(0);" style="margin: 5px;" class="btn btn-danger verify">Verify & Check Out</a> -->
			</div>
		</div>
      </div>
    </div>
  </div>
</div>  
<?php 
if(isset($booking_id) && $booking_id!="")
{ 
	if(!empty($booking_verify) && !empty($room_verify))
	{
?>
<div id="myModalVerify" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" style="width:55%;">
    <div class="modal-content">
      <div class="modal-header" style="background: #F44336;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-weight:bold; font-size:17px; color:#FFF;">Checkout Verification - <?php echo $booking_verify->customer->full_name; ?> (Room <?php echo $room_verify->room_number; ?>)</h4>
      </div>
      <div class="modal-body">	
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group" style="background: #fff3cd; padding: 17px 15px; border-radius: 9px; border: 1px solid #f0e4bd;">
						<div style="color: #997404; font-size: 14px; padding: 7px 0;"><strong>Manager/Reception Verification Required</strong></div>
						<p style="color: #997404; font-size: 14px;">Please verify all bills and payments before authorizing checkout. This is a manual process that requires management approval.</p>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-grey" style="border-color: #0d6dfd !important; border: 1px solid #0d6dfd;">
						<div class="panel-heading" style="background: #0d6dfd; border-color: #0d6dfd !important; font-weight: bold;">All Charges (Debit)</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel-body pan">
										<?php echo $this->Common->verify_booking_debit($booking_id); ?>											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-grey" style="border-color: #198754 !important; border: 1px solid #198754;">
						<div class="panel-heading" style="background: #198754; border-color: #198754 !important; font-weight: bold;">All Payment (Credit)</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel-body pan">
										<?php echo $this->Common->verify_booking_payment($booking_id); ?>											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="panel panel-grey" style="border-color: #bf3773 !important; border: 1px solid #bf3773;">
						<div class="panel-heading" style="background: #bf3773; border-color: #bf3773 !important; font-weight: bold;">Final Amount Summary</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel-body pan">
										<?php echo $this->Common->booking_payment($booking_id); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php 
					$final_tally_summery = $this->Common->final_tally_summery($booking_id); 
					$tally_summery = explode("@",$final_tally_summery);
					$amount_payble = round($tally_summery[0]);
					$amount_received = round($tally_summery[1]);
					$outstanding = round($tally_summery[2]);
					$style = "#ffc107";
					$style_outstanding = "#fff3cd";
					$unbalanced = "UNBALANCED";
					$summery_status = "Payment Required";
					if($outstanding == 0){
						$summery_status = "Ready for Checkout";
						$unbalanced = "BALANCED";
						$style = "#198754";
						$style_outstanding = "#d1e7dd";
					}					
				?>
				<div class="col-md-12">
					<div class="panel panel-grey" style="border-color: <?php echo $style ?> !important; border: 1px solid <?php echo $style ?>;">
						<div class="panel-heading" style="background: <?php echo $style ?>; border-color: <?php echo $style ?> !important; font-weight: bold;">Final Tally Summary <span style="background: #FFF; padding: 5px 9px; color: <?php echo $style ?>;"><?php echo $unbalanced ?></span></div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel-body pan">
										<div class="col-lg-3" style="text-align:center;">
											 <div class="panel" style="background: #f8f9fa; border: 1px solid #d4d9dd;border-radius: 5px !important;">
												<div class="panel-heading dashboa-panel-heading" style="padding: 7% 0 !important; border: none;">
												<span style="font-weight: bold;">Total Debit (Bill)</span> <br />
												<span style="color: #0d6efd; font-size: 19px; font-weight: bold;"><?php echo $site_general_settings->currency; ?><?php echo round($amount_payble) ?></span> <br /> 
												<span>Amount Payable</span></div>
											</div>
										</div>
										<div class="col-lg-3" style="text-align:center;">
											 <div class="panel" style="background: #f8f9fa; border: 1px solid #d4d9dd;border-radius: 5px !important;">
												<div class="panel-heading dashboa-panel-heading" style="padding: 7% 0 !important; border: none;">
												<span style="font-weight: bold;">Total Credit (Paid)</span> <br />
												<span style="color: #198754; font-size: 19px; font-weight: bold;"><?php echo $site_general_settings->currency; ?><?php echo round($amount_received) ?></span> <br /> 
												<span>Amount Received</span></div>
											</div>
										</div>
										<div class="col-lg-3" style="text-align:center;">
											 <div class="panel" style="background: <?php echo $style_outstanding ?>; border: 1px solid #d4d9dd;border-radius: 5px !important;">
												<div class="panel-heading dashboa-panel-heading" style="padding: 7% 0 !important; border: none;">
												<span style="font-weight: bold;">Outstanding</span> <br />
												<span style="color: #dc3545; font-size: 19px; font-weight: bold;"><?php echo $site_general_settings->currency; ?><?php echo round($outstanding) ?></span> <br /> 
												<span>Balance Due</span></div>
											</div>
										</div>
										<div class="col-lg-3" style="text-align:center;">
											 <div class="panel" style="background: <?php echo $style ?>; border: 1px solid #d4d9dd;border-radius: 5px !important;">
												<div class="panel-heading dashboa-panel-heading" style="padding: 7% 0 !important; border: none;">
												<span style="font-weight: bold; color: #FFF;">Status</span> <br />
												<span style="font-weight: bold; color: #FFF; font-size: 19px; font-weight: bold;"><?php echo $unbalanced ?></span> <br /> 
												<span style="color: #FFF;"><?php echo $summery_status ?></span></div>
											</div>
										</div>
									</div>
									<div class="col-lg-12">
									<div class="form-group" style="background: <?php echo $style_outstanding ?>; padding: 17px 15px; border-radius: 9px; border: 1px solid <?php echo $style ?>;">
										<div style="color: <?php echo $style ?>; font-size: 14px; padding: 7px 0;">
											<?php if($outstanding == 0){ ?>
											<strong>Perfect!</strong> All bills have been settled. Ready for final verification and checkout authorization.
											<?php }else{ ?>
											<strong>Action Required:</strong> Outstanding balance of <?php echo $site_general_settings->currency; ?><?php echo $outstanding ?> must be settled before final checkout authorization.
											<?php } ?>
										</div>
									</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="panel panel-grey" style="border-color: #F44336 !important; border: 1px solid #F44336;">
						<div class="panel-heading" style="background: #F44336; border-color: #F44336 !important; font-weight: bold;">Manager Authorization</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-6">
									<div class="panel-body pan">
										<div class="col-lg-12" style="padding: 5px 0; font-weight: bold; color: #0d6efd; font-size: 17px;">
											Bill Verification
										</div>										
										<div class="col-lg-12" style="padding: 5px 0;">
											 <input type="checkbox" class="verify_booking"> <strong>Room Bill Verified:</strong> All room charges and payments cross-checked
										</div>
										<div class="col-lg-12" style="padding: 5px 0;">
											 <input type="checkbox" class="verify_booking"> <strong>KOT Bill Verified:</strong> Food orders and payments verified with kitchen
										</div>
										<div class="col-lg-12" style="padding: 5px 0;">
											 <input type="checkbox" class="verify_booking"> <strong>BOT Bill Verified:</strong> Beverage orders and payments verified with bar
										</div>
										<div class="col-lg-12" style="padding: 5px 0;">
											 <input type="checkbox" class="verify_booking"> <strong>Master Bill Generated:</strong> Final consolidated bill prepared and verified
										</div>
									</div>									
								</div>
								<div class="col-lg-6">
									<div class="panel-body pan">
										<div class="col-lg-12" style="padding: 5px 0; font-weight: bold; color: #0d6efd; font-size: 17px;">
											Financial Verification
										</div>
										<div class="col-lg-12" style="padding: 5px 0;">
											 <input type="checkbox" class="verify_booking"> <strong>Tally Balance:</strong>  Outstanding balance must be cleared first
										</div>
										<div class="col-lg-12" style="padding: 5px 0;">
											 <input type="checkbox" class="verify_booking"> <strong>No Pending Bills:</strong> All bill statuses verified as complete or settled
										</div>
										<div class="col-lg-12" style="padding: 5px 0;">
											 <input type="checkbox" class="verify_booking"> <strong>Manager Approval:</strong> I authorize this checkout as Manager/Reception
										</div>
									</div>									
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<a href="javascript:void(0);" onclick="master_bill()" style="margin: 5px;" class="btn btn-info">Generate Master Bill Receipt</a>
				</div>				
				<div class="col-md-6 text-right">
					<button type="button" onclick="verfication_force_checkout()" style="margin: 5px;" class="btn btn-warning">Force Check Out</button>
					<button type="button" id="myButton" class="btn btn-success" onclick="success_verfication()" disabled> Complete All Verifications First</button>
				</div>
			</div>
		</div>
      </div>
    </div>
  </div>
</div>
<div id="myModalMasterBill" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" style="width:40%;">
    <div class="modal-content">
      <div class="modal-header" style="background: #0d6efd;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="font-weight:bold; font-size:17px; color:#FFF;">Master Bill Receipt Options</h4>
      </div>
      <div class="modal-body">	
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="form-group" style="background: #cff4fc; padding: 17px 15px; border-radius: 9px; border: 1px solid #f0e4bd;">
							<div style="color: #087990; font-size: 14px; padding: 7px 0;"><strong>Choose Receipt Format</strong></div>
							<p style="color: #087990; font-size: 14px;">Select the type of master bill receipt you want to generate for <strong><?php echo $booking_verify->customer->full_name; ?></strong> (Room <?php echo $room_verify->room_number; ?>).</p>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="row">
						<div class="col-lg-6" style="text-align:center;">
							 <div class="row">
								<div class="col-lg-12">
									 <div class="panel" style="padding: 0 45px 15px; border: 1px solid #0d6efd; border-radius: 5px !important; height: 210px;">
										<div class="panel-heading dashboa-panel-heading" style="padding: 7% 0 !important; border: none;">
											<?php echo $this->Html->image('/images/standard_receipt.png', ['alt' => 'standard_receipt.png', 'border' => '0']); ?> <br />
											<span style="font-weight: bold;">Standard Receipt</span> <br />
											<span>Detailed breakdown with full billing information</span> <br />
											<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'masterbillprint', $booking_id]);?>" target="_blank" style="margin: 10px; background: #0d6efd;" class="btn btn-info">Generate</a> <br />
										</div>
									 </div>
								 </div>
							</div>
						</div>
						<div class="col-lg-6" style="text-align:center;">
							 <div class="row">
								<div class="col-lg-12">
									 <div class="panel" style="padding: 0 45px 15px; border: 1px solid #198754; border-radius: 5px !important; height: 210px;">
										<div class="panel-heading dashboa-panel-heading" style="padding: 7% 0 !important; border: none;">
											<?php echo $this->Html->image('/images/bill_print.png', ['alt' => 'bill_print.png', 'border' => '0']); ?> <br />
											<span style="font-weight: bold;">Compact + Carbon Copy</span> <br />
											<span>A4 optimized with customer & hotel copies</span> <br />
											<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'masterbillrceiptprint', $booking_id]);?>" target="_blank" style="margin: 10px;" class="btn btn-success">Generate</a>
										</div>
									 </div>
								 </div>
							 </div>
						</div>	
						<div class="col-md-12">
							<a href="javascript:void(0);" style="margin: 15px 0; width: 100%" class="btn btn-info">Send via email</a>
						</div>
					</div>
				</div>
			</div>
		</div>
      </div>
    </div>
  </div>
</div>
<?php
	}
}
?>