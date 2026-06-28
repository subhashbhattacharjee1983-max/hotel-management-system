<?php 
	$this->assign('title','Assign Booking to Customer / Travel Agency');
	$this->assign('heading','Assign Booking to Customer / Travel Agency');
	$this->assign('breadcrumb','Assign Booking to Customer / Travel Agency'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Bookings', 'action'=>'index'])); 
	$day = date('d') + 3;
?>
<script type="text/javascript">
<!--
	$(function(){
		var slug = "<?php echo $slug ?>";
		if(slug == "deleteRoom"){
			$("#loader_section").show();
			setTimeout(function() {
			   $("#edit-form").submit();
			}, 5000);
		}
		$("#edit-form").validationEngine();
		$( "#check-in-date, #check-out-date" ).datepicker({
			dateFormat : 'yy-mm-dd',
			minDate: 0,
			maxDate: "+30D",
			onSelect: function(selectedDate) {
				calculateDays();
			}
		});
		calculateDays();

		function calculateDays() {
			var startDate = $('#check-in-date').datepicker('getDate');
			var endDate = $('#check-out-date').datepicker('getDate');
			var timeDifference = endDate.getTime() - startDate.getTime();
			var daysDifference = timeDifference / (1000 * 3600 * 24);
			var numberOfDays = Math.round(daysDifference);
			$('#number-of-night').val(numberOfDays);
		}

		function calcSum() {
			var bamt = 0; 
			var ramt = 0;
			var damt = 0;
			$("#wrap .bamt").each(function() {
			   bamt += parseInt($(this).val()) || 0; 
			});
			$("#booking-price").val(parseInt(bamt));

			$("#wrap .ramt").each(function() {
			   ramt += parseInt($(this).val()) || 0; 
			});
			$("#room-price").val(parseInt(ramt));

			$("#wrap .damt").each(function() {
			   damt += parseInt($(this).val()) || 0; 
			});
			$("#room-discount").val(parseInt(damt));
		}    
		$("#wrap").keyup(calcSum);
		calcSum();
	});
	function number(evt){
	 var charCode = (evt.which) ? evt.which : event.keyCode;
	 if(charCode>31 && (charCode<48 || charCode>57))
	  return false;
	 return true;
	}
    function is_amount(evt, element) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (
			//(charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
			(charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
			(charCode < 48 || charCode > 57))
			return false;
		return true;
	}
	function checkNumberFieldLength(elem){
		if (elem.value.length > 2) {
			elem.value = elem.value.slice(0,2); 
		}
	}
	function tot_bill_amt(id)
	{
		var booking_price = 0;
		var discount_amount = 0;
		var booking_price = $('#booking_room_price'+id).val() || 0;
		var discount = $('#booking_room_discount'+id).val() || 0;
		var discount_amount = (booking_price * discount)/100;
		var room_booking_price = parseInt(booking_price) - parseInt(discount_amount);
		$("#room_booking_price"+id).val(parseInt(room_booking_price));
	}
//-->
</script>
<style type="text/css">
	.chosen-container {
		border: 0px solid #999;
	}
</style>
<div id="tab-general">
	<div class="row mbl">
		<div class="col-lg-12">
			<div class="col-md-12">
				<div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
				</div>
			</div>
		</div>
		<?php echo $this->Form->create($booking, ["name" => "edit-form", "id" => "edit-form",  "method" => "POST", 'enctype'=>'multipart/form-data']); ?>
		<div class="col-lg-4">
			<div class="panel panel-grey">
				<div class="panel-heading">Customer / Travel Agency Information</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Full Name
												</label>
												<div class="input-icon right">
													<?php echo $booking->customer->full_name; ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Mobile Number
												</label>
												<div class="input-icon right">
													<?php echo $booking->customer->mobile_number; ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Email Address
												</label>
												<div class="input-icon right">
													<?php echo $booking->customer->email_address; ?>
												</div>
											</div>
										</div>										
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
													Guest Category
												</label>
												<div class="input-icon right">
													<?php echo $booking->customer->guest_category; ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Address
												</label>
												<div class="input-icon right">
													<?php echo $booking->customer->address; ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
													ID Type
												</label>
												<div class="input-icon right">
													<?php echo $booking->customer->id_type; ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Id Number
												</label>
												<div class="input-icon right">
													<?php echo $booking->customer->id_number; ?>
												</div>
											</div>
										</div>
									</div>								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="panel panel-grey">
				<div class="panel-heading">Booking Details</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Booking Package
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('booking_package',['type'=>'select','options'=>$booking_package, 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Booking Food Plan
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('food_plan',['type'=>'select','options'=>$food_plan, 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group attr_field">
												<label for="inputName" class="control-label">
												Room Details
												</label>
												<div class="input-icon right">
													<div class="form-group col-md-12" style="padding:0px" id="wrap">
														<table width="100%" border="1">
															<tr style="background: #4f158c;">
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Room Number</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Room Category</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Room Price (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Discount (%)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Booking Price (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px;">&nbsp;</th>
															</tr>
															<?php
															if(!empty($booking->booking_room_details))
															{
																foreach($booking->booking_room_details as $key_dtls => $val)
																{
																	$key = $key_dtls + 1;
															?>
															<tr>
																<td>
																	<input name="edit_id[]" value="<?php echo $val->id?>" type="hidden">
																	<div class="input-icon right">
																		<select style="width:270px; border:0;" name="booking_room_name[]" id="booking_room_name<?php echo $key ?>" class="chosen form-control validate[required]" required>
																			<option value="">Select Room</option>
																			<?php 
																			  if($rooms){
																				foreach($rooms as $room_key=>$rval){
																			  ?>
																			  <option value="<?php echo $rval->room_number ?>" <?php echo $rval->room_number == $val->booking_room_name ? 'selected' : '' ?>><?php echo $rval->room_number.' - '.$rval->room_category->room_category_name.' - '.$site_general_settings->currency.$rval->room_category->price_per_night; ?></option>
																			  <?php 
																				}
																			  }
																			  ?>
																		</select>
																	</div>
																	<!-- <div class="input-icon right text-center">
																		<input name="booking_room_name[]" value="<?php //echo $val->booking_room_name?>" type="hidden">
																		<?php //echo $val->booking_room_name; ?>
																	</div> -->
																</td>																
																<td>
																	<div class="input-icon right text-center">
																		<select style="width:170px; border:0;" name="booking_room_category[]" id="booking_room_category<?php echo $key ?>" class="chosen form-control validate[required]" required>
																			<?php 
																			  if($roomCategories){
																				foreach($roomCategories as $tkey=>$tval){
																			  ?>
																			  <option value="<?php echo $tval->room_category_name?>" <?php echo $tval->room_category_name == $val->booking_room_category ? 'selected' : '' ?>><?php echo $tval->room_category_name; ?></option>
																			  <?php 
																				}
																			  }
																			  ?>
																		</select>
																	</div>
																	<!-- <div class="input-icon right text-center">
																		<input name="booking_room_category[]" value="<?php //echo $val->booking_room_category?>" type="hidden">
																		<?php //echo $val->booking_room_category; ?>
																	</div> -->
																</td>
																<td>
																	<div class="input-icon right">
																		<input name="booking_room_price[]" id="booking_room_price<?php echo $key ?>" class="form-control ramt" value="<?php echo round($val->booking_room_price) ?>" type="text" autocomplete="off" onKeyUp="tot_bill_amt(<?php echo $key ?>)" style="border:0; background:#FFFFFF;" onKeyPress="return is_amount(event, this)">
																	</div>
																</td>
																<td>
																	<div class="input-icon right">
																		<input name="booking_room_discount[]" id="booking_room_discount<?php echo $key ?>" class="form-control damt" value="<?php echo $val->booking_room_discount; ?>" type="text" autocomplete="off" onKeyUp="tot_bill_amt(<?php echo $key ?>)" style="border:0; background:#FFFFFF;" onKeyPress="return number(event, this)" oninput="checkNumberFieldLength(this)">
																	</div>
																</td>
																<td>
																	<div class="input-icon right">																		
																		<input name="room_booking_price[]" id="room_booking_price<?php echo $key ?>" class="form-control bamt" value="<?php echo round($val->room_booking_price); ?>" type="text" autocomplete="off" style="border:0; background:#FFFFFF;" onKeyPress="return is_amount(event, this)" readonly>
																	</div>
																</td>
																<td>
																	&nbsp;<a onclick="return confirm('Are you sure you want to delete this room?')" href='<?=$this->Url->build(array('controller'=>'Bookings', "action" => 'deleteroom', base64_encode($val->id), $booking->id, $val->booking_room_name));?>'><?=$this->Html->image('/img/icons/delete.png', array('alt' => 'Delete', 'border' => '0',  ))?></a>&nbsp;
																</td>
																<input type="hidden" name="slider_count" id="slider_count" value="<?php echo $key ?>">
															</tr>
															<?php
																}
															}
															?>
														</table>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Check In Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('check_in_date', ['autocomplete' => 'off', 'placeholder' => 'Check In Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => date("Y-m-d",strtotime($booking->check_in_date)), 'data-errormessage-value-missing'=>'Check In Date is required', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Check Out Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('check_out_date', ['autocomplete' => 'off', 'placeholder' => 'Check Out Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => date("Y-m-d",strtotime($booking->check_out_date)), 'data-errormessage-value-missing'=>'Check Out Date is required', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Adults <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('adults', ['autocomplete' => 'off', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Adults is required', 'type' => 'text', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'oninput' => "checkNumberFieldLength(this);"]);?>
												</div>
											</div>
										</div>										
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Children <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('children', ['autocomplete' => 'off', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Children is required', 'type' => 'text', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'oninput' => "checkNumberFieldLength(this);"]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Number Of Night <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('number_of_night', ['autocomplete' => 'off', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Number Of Night is required', 'type' => 'text', 'readonly' => true, 'style' => 'background: transparent;', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'oninput' => "checkNumberFieldLength(this);"]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Room Price (<?php echo $site_general_settings->currency; ?>)
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('room_price', ['autocomplete' => 'off', 'placeholder' => 'Room Price', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Room Price is required', 'type' => 'text', 'style' => 'background:#FFFFFF;', 'readonly' => true, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Booking Price (<?php echo $site_general_settings->currency; ?>)
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('booking_price', ['autocomplete' => 'off', 'placeholder' => 'Booking Price', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Booking Price is required', 'type' => 'text', 'style' => 'background:#FFFFFF;', 'readonly' => true, 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Room Discount (%)
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('room_discount', ['autocomplete' => 'off', 'placeholder' => 'Room Discount', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Room Discount is required', 'type' => 'text', 'style' => 'background:#FFFFFF;', 'readonly' => true, 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'oninput' => "checkNumberFieldLength(this);"]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Allow BST
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('allow_bst',['type'=>'select','options'=>$tax_allow, 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Allow Service Charge
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('allow_service_charge',['type'=>'select','options'=>$tax_allow, 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Allow GST
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('allow_gst',['type'=>'select','options'=>$tax_allow, 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Allow Bank Transfer Charge
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('allow_bank_transfer_charge',['type'=>'select','options'=>$tax_allow, 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
									</div>								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4"></div>
		<div class="col-lg-8">
			<div class="form-body">
				<div class="row">
					<div class="col-md-12">
						<div class="text-right" style="padding-top: 7%;">
							<?=$this->Form->button('Assign Booking', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'style' => 'width: 100%; padding: 9px;', 'class'=>'btn btn-booking','value'=>'Login']);?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<script type="text/javascript">
<!--
$(".delete").on('click', function() {
	$('.case:checkbox:checked').parents("tr").remove();
	function calcSum() {
		var bamt = 0; 
		var ramt = 0;
		var damt = 0;
		$("#wrap .bamt").each(function() {
		   bamt += parseFloat($(this).val()) || 0; 
		});
		$("#booking-price").val(parseFloat(bamt).toFixed(2));

		$("#wrap .ramt").each(function() {
		   ramt += parseFloat($(this).val()) || 0; 
		});
		$("#room-price").val(parseFloat(ramt).toFixed(2));

		$("#wrap .damt").each(function() {
		   damt += parseInt($(this).val()) || 0; 
		});
		$("#room-discount").val(parseInt(damt));
	}    
	$("#wrap").keyup(calcSum);
	calcSum();
});
var i=2;
$(".addmore").on('click',function(){
	var slider_count = $('#slider_count').val();
	var slider_count_new = eval(slider_count)+1;
    var data="<tr><td>&nbsp;<input type='checkbox' class='case'/></td>";  
	data +="<td><div class='input-icon right'><select style='width:100%;border:0;' name='booking_room_name[]' id='booking_room_name"+i+"' class='form-control validate[required]' required><?php if($rooms){foreach($rooms as $key=>$val){?><option value='<?php echo $val->room_number ?>'><?php echo $val->room_number.' - '.$val->room_category->room_category_name.' - '.$site_general_settings->currency.$val->room_category->price_per_night; ?></option><?php }}?></select></div></td>";
	data +="<td><div class='input-icon right'><select style='width:100%;border:0;' name='booking_room_category[]' id='booking_room_category"+i+"' class='form-control validate[required]' required><?php if($roomCategories){foreach($roomCategories as $key=>$val){?><option value='<?php echo $val->room_category_name?>'><?php echo $val->room_category_name; ?></option><?php }}?></select></div></td>";
	data +="<td><div class='input-icon right'><input name='booking_room_price[]' id='booking_room_price"+i+"' placeholder='' class='form-control validate[required] ramt' value='' type='text' onKeyUp='tot_bill_amt("+i+")' style='border:0; background:#FFFFFF;' autocomplete='off' onKeyPress='return is_amount(event, this)'></div></td>";
	data +="<td><div class='input-icon right'><input name='booking_room_discount[]' id='booking_room_discount"+i+"' placeholder='' class='form-control validate[required] damt' value='' type='text' onKeyUp='tot_bill_amt("+i+")' style='border:0; background:#FFFFFF;' autocomplete='off' onKeyPress='return number(event, this)' oninput='checkNumberFieldLength(this)'></div></td>";
	data +="<td><div class='input-icon right'><input name='room_booking_price[]' id='room_booking_price"+i+"' placeholder='' class='form-control validate[required] bamt' value='' type='text' style='border:0; background:#FFFFFF;' autocomplete='off' onKeyPress='return is_amount(event, this)' readonly></div></td>";
	$('#slider_count').val(slider_count_new);
	$('table').append(data);
	i++;
	//$(".chosen").chosen();
});
function select_all() {
	$('input[class=case]:checkbox').each(function(){ 
		if($('input[class=check_all]:checkbox:checked').length == 0){ 
			$(this).prop("checked", false); 
		} else {
			$(this).prop("checked", true); 
		} 
	});
}
$(".chosen").chosen();
//-->
</script>