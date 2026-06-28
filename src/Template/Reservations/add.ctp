<?php 
	$this->assign('title','Assign Reservation to Customer / Travel Agency');
	$this->assign('heading','Assign Reservation to Customer / Travel Agency');
	$this->assign('breadcrumb','Assign Reservation to Customer / Travel Agency'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Reservations', 'action'=>'index'])); 
	$day = date("Y-m-d", strtotime("+2 day"));
?>
<script type="text/javascript">
<!--
	function YourOnSubmitFn()
	{
		if($("#add-form").validationEngine('validate')==true)
		{
			$("#btn_submit").attr("disabled", true);
			$("#loader_section").show();
			$("#add-form").submit();
		}
	}

	$(function(){
		tot_bill_amt(1);
		$( "#check-in-date, #check-out-date" ).datepicker({
			dateFormat : 'yy-mm-dd',
			minDate: 0,
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
			show_food_amt(1);
			show_food_amt(2);
			show_food_amt(3);
			show_food_amt(4);
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
			show_food_amt(1);
			show_food_amt(2);
			show_food_amt(3);
			show_food_amt(4);
		}    
		$("#wrap").keyup(calcSum);
		calcSum();		
	});
	
	function already_user(val)
	{
		$.ajax({		
			type:'POST',
			url:"<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'showUser'])?>",
			data:{
				mobile:val
			},
			dataType:'json',
			headers : {
				'X-CSRF-Token': "<?php echo $this->request->getParam('_csrfToken');?>"
			},
			success:function(response){
				//alert(response);
				if(response.msg == "Success"){
					$("#full-name").val(response.full_name);
					$("#email-address").val(response.email_address);
					$("#guest-category").val(response.guest_category);
					$("#address").val(response.address);
					$("#id-type").val(response.id_type);
					$("#id-number").val(response.id_number);
					showCustomMessage('<div class="message success">This customer has already exists</div>');
				}
			},
			error: function(error){
				// Do nothing
			}
		});
	}

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
	function show_food_amt(id)
	{
		var audult = $('#adults').val() || 0;
		var children = $('#children').val() || 0;
		var no_of_days = $('#number-of-night').val() || 0;
		var no_of_people = parseInt(audult) + parseInt(children);
		var food_price = $('#food-price'+id).val() || 0;
		var grand_price = (food_price * no_of_people) * no_of_days;
		$('#food-total'+id).val(grand_price);
		var all_total_amount = parseInt($('#booking-price').val()) + parseInt($('#food-total1').val()) + parseInt($('#food-total2').val()) + parseInt($('#food-total3').val()) + parseInt($('#food-total4').val());
		$('#all-total-amount').val(all_total_amount * no_of_days);
	}
	function show_food_tot()
	{
		show_food_amt(1);
		show_food_amt(2);
		show_food_amt(3);
		show_food_amt(4);
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
		<?php echo $this->Form->create($reservation, ["name" => "add-form", "id" => "add-form",  "method" => "POST", 'enctype'=>'multipart/form-data']); ?>
		<div class="col-lg-4">
			<div class="panel panel-grey">
				<div class="panel-heading">Customer / Travel Agency Information</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Full Name <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('full_name', ['autocomplete' => 'off', 'placeholder' => 'Full Name', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Full name is required', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Mobile Number <span class="text-danger">*</span> <span style="color: #f90303;">(Enter mobile number to retrieve automatically your existing customer details)</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('mobile_number', ['type'=>'text', 'placeholder' => 'Mobile Number', 'autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false, 'data-errormessage-value-missing'=>'Mobile number is required', 'onBlur' => 'already_user(this.value)', 'onKeyPress' => 'return number(event, this)']);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Email Address
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('email_address', ['autocomplete' => 'off', 'placeholder' => 'Email Address', 'class' => 'form-control validate[custom[email]]', 'data-errormessage-value-missing'=>'Email Address is required', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>										
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Guest Category <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('guest_category',['type'=>'select','options'=>$guest_category, 'class'=>'form-control validate[required]', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Address <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('address', ['type'=>'textarea', 'placeholder' => 'Address', 'autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
													ID Type <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('id_type',['type'=>'select','options'=>$id_type, 'class'=>'form-control validate[required]', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Id Number
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('id_number', ['type'=>'text', 'placeholder' => 'Id Number', 'autocomplete' => 'off', 'class' => 'form-control', 'label'=>false, 'required'=>false, 'div'=>false, 'data-errormessage-value-missing'=>'Id number is required']);?>
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
				<div class="panel-heading">Reservation Details</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Booking Type
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('booking_type',['type'=>'select','options'=>$reservation_type, 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
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
												Rooom Details
												</label>
												<div class="input-icon right">
													<div class="form-group col-md-12" style="padding:0px" id="wrap">
														<table width="100%" border="1">
															<tr style="background: #4f158c;">
																<th style="width:5%;">&nbsp;<!-- <input class='check_all' type='checkbox' onclick="select_all()"/> --></th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Room Number</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Room Category</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Room Price (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Discount (%)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Booking Price (<?php echo $site_general_settings->currency; ?>)</th>
															</tr>
															<tr>
																<td><!-- &nbsp;<input type='checkbox' class='case'/>&nbsp; --></td>
																<td>
																	<div class="input-icon right">
																		<select style="width:270px; border:0;" name="reservation_room_number[]" id="reservation_room_number1" class="chosen form-control">
																			<option value="">Select Room</option>
																			<?php 
																			  if($rooms){
																				foreach($rooms as $key=>$val){
																			  ?>
																			  <option value="<?php echo $val->room_number ?>"><?php echo $val->room_number.' - '.$val->room_category->room_category_name.' - '.$site_general_settings->currency.$val->room_category->price_per_night; ?></option>
																			  <?php 
																				}
																			  }
																			  ?>
																		</select>
																	</div>
																</td>
																<td>
																	<div class="input-icon right">
																		<select style="width:170px; border:0;" name="reservation_room_category[]" id="reservation_room_category1" class="chosen form-control validate[required]" required>
																			<?php 
																			  if($roomCategories){
																				foreach($roomCategories as $key=>$val){
																			  ?>
																			  <option value="<?php echo $val->room_category_name?>"><?php echo $val->room_category_name; ?></option>
																			  <?php 
																				}
																			  }
																			  ?>
																		</select>
																	</div>
																</td>
																<td>
																	<div class="input-icon right">
																		<input name="booking_room_price[]" id="booking_room_price1" placeholder="" class="form-control validate[required] ramt" value="0" type="text" onKeyUp="tot_bill_amt(1)" style="border:0; background:#FFFFFF;" autocomplete="off" onKeyPress="return is_amount(event, this)">
																	</div>
																</td>
																<td>
																	<div class="input-icon right">
																		<input name="booking_room_discount[]" id="booking_room_discount1" placeholder="" class="form-control validate[required] damt" value="0" type="text" onKeyUp="tot_bill_amt(1)" style="border:0; background:#FFFFFF;" autocomplete="off" onKeyPress="return number(event, this)" oninput="checkNumberFieldLength(this)">
																	</div>
																</td>
																<td>
																	<div class="input-icon right">
																		<input name="room_booking_price[]" id="room_booking_price1" placeholder="" class="form-control validate[required] bamt" value="" type="text" style="border:0; background:#FFFFFF;" autocomplete="off" onKeyPress="return is_amount(event, this)" readonly>
																	</div>
																</td>
																<input type="hidden" name="slider_count" id="slider_count" value="1">
															</tr>
														</table>
													</div>

													<div class="form-group col-md-12 text-right" style="padding-left:0px">
													   <a href="javascript:void(0)" style="color: #FFF;" class='addmore item-button'>Add Room </a>
													   <a href="javascript:void(0)" style="margin-left: 10px; color: #FFF;" class='delete item-button'>Remove Room</a>
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
													<?php echo $this->Form->control('check_in_date', ['autocomplete' => 'off', 'placeholder' => 'Check In Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => date("Y-m-d"), 'data-errormessage-value-missing'=>'Check In Date is required', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Check Out Date <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('check_out_date', ['autocomplete' => 'off', 'placeholder' => 'Check Out Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => $day, 'data-errormessage-value-missing'=>'Check Out Date is required', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Adults <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('adults', ['autocomplete' => 'off', 'value' => '1', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Adults is required', 'type' => 'text', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'oninput' => "checkNumberFieldLength(this);", 'onKeyUp' => "show_food_tot()"]);?>
												</div>
											</div>
										</div>										
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Children <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('children', ['autocomplete' => 'off', 'value' => '0', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Children is required', 'type' => 'text', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'oninput' => "checkNumberFieldLength(this);", 'onKeyUp' => "show_food_tot()"]);?>
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
													<?php echo $this->Form->control('room_price', ['autocomplete' => 'off', 'placeholder' => 'Room Price', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Room Price is required', 'type' => 'text', 'style' => 'background: #FFFFFF;', 'label'=>false, 'required'=>false, 'div'=>false, 'readonly' => true]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Booking Price (<?php echo $site_general_settings->currency; ?>)
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('booking_price', ['autocomplete' => 'off', 'placeholder' => 'Booking Price', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Booking Price is required', 'type' => 'text', 'style' => 'background: #FFFFFF;', 'label'=>false, 'required'=>false, 'div'=>false, 'readonly' => true]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Room Discount (%)
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('room_discount', ['autocomplete' => 'off', 'placeholder' => 'Room Discount', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Room Discount is required', 'type' => 'text', 'style' => 'background: #FFFFFF;', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'oninput' => "checkNumberFieldLength(this);", 'readonly' => true]);?>
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
										<div class="col-md-12" style="display: none;">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Food Details
												</label>
											</div>
										</div>
										<div class="col-md-2" style="display: none;">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Food 1
												</label>
												<div class="input-icon right">
													<?php 
													$breakfast_array = array('Breakfast' => 'Breakfast');
													echo $this->Form->control('food1',['type'=>'select','options'=>$breakfast_array, 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-2" style="display: none;">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Price <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('food_price1', ['autocomplete' => 'off', 'value' => '0', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Price is required', 'type' => 'text', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'onKeyUp' => "show_food_amt(1)"]);?>
												</div>
											</div>
										</div>
										<div class="col-md-2" style="display: none;">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Total Price <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('food_total1', ['autocomplete' => 'off', 'value' => '0', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Total Price is required', 'type' => 'text', 'style' => 'background: #FFFFFF;', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'readonly' => true]);?>
												</div>
											</div>
										</div>
										<div class="col-md-2" style="display: none;">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Food 2
												</label>
												<div class="input-icon right">
													<?php 
													$lunch_array = array('Lunch' => 'Lunch');
													echo $this->Form->control('food2',['type'=>'select','options'=>$lunch_array, 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-2" style="display: none;">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Price <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('food_price2', ['autocomplete' => 'off', 'value' => '0', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Price is required', 'type' => 'text', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'onKeyUp' => "show_food_amt(2)"]);?>
												</div>
											</div>
										</div>
										<div class="col-md-2" style="display: none;">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Total Price <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('food_total2', ['autocomplete' => 'off', 'value' => '0', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Total Price is required', 'type' => 'text', 'style' => 'background: #FFFFFF;', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'readonly' => true]);?>
												</div>
											</div>
										</div>
										<div class="col-md-2" style="display: none;">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Food 3
												</label>
												<div class="input-icon right">
													<?php 
													$snacks_array = array('Snacks' => 'Snacks');
													echo $this->Form->control('food3',['type'=>'select','options'=>$snacks_array, 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-2" style="display: none;">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Price <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('food_price3', ['autocomplete' => 'off', 'value' => '0', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Price is required', 'type' => 'text', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'onKeyUp' => "show_food_amt(3)"]);?>
												</div>
											</div>
										</div>
										<div class="col-md-2" style="display: none;">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Total Price <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('food_total3', ['autocomplete' => 'off', 'value' => '0', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Total Price is required', 'type' => 'text', 'style' => 'background: #FFFFFF;', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'readonly' => true]);?>
												</div>
											</div>
										</div>
										<div class="col-md-2" style="display: none;">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Food 4
												</label>
												<div class="input-icon right">
													<?php 
													$dinner_array = array('Dinner' => 'Dinner');
													echo $this->Form->control('food4',['type'=>'select','options'=>$dinner_array, 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-2" style="display: none;">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Price <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('food_price4', ['autocomplete' => 'off', 'value' => '0', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Price is required', 'type' => 'text', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'onKeyUp' => "show_food_amt(4)"]);?>
												</div>
											</div>
										</div>
										<div class="col-md-2" style="display: none;">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Total Price <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('food_total4', ['autocomplete' => 'off', 'value' => '0', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Total Price is required', 'type' => 'text', 'style' => 'background: #FFFFFF;', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'readonly' => true]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												All Total Amount <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('all_total_amount', ['autocomplete' => 'off', 'value' => '0', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'All Total Amount is required', 'type' => 'text', 'style' => 'background: #FFFFFF;', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'readonly' => true]);?>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Paid Amount
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('paid_amount', ['autocomplete' => 'off', 'value' => '0', 'class' => 'form-control', 'data-errormessage-value-missing'=>'Paid Amount is required', 'type' => 'text', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)']);?>
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
							<?=$this->Form->button('Assign Reservation', ['type'=>'button', 'name'=>'btn_submit', 'id'=>'btn_submit', 'style' => 'width: 100%; padding: 9px;', 'class'=>'btn btn-booking', 'value'=>'Submit', 'onclick' => 'YourOnSubmitFn()']);?>
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
		show_food_amt(1);
		show_food_amt(2);
		show_food_amt(3);
		show_food_amt(4);
	}    
	$("#wrap").keyup(calcSum);
	calcSum();
});
var i=2;
$(".addmore").on('click',function(){
	var slider_count = $('#slider_count').val();
	var slider_count_new = eval(slider_count)+1;
    var data="<tr><td>&nbsp;<input type='checkbox' class='case'/></td>";
	data +="<td><div class='input-icon right'><select style='width:270px;border:0;' name='reservation_room_number[]' id='reservation_room_number"+i+"' class='chosen form-control'><option value=''>Select Room</option><?php if($rooms){foreach($rooms as $key=>$val){?><option value='<?php echo $val->room_number ?>'><?php echo $val->room_number.' - '.$val->room_category->room_category_name.' - '.$site_general_settings->currency.$val->room_category->price_per_night; ?></option><?php }}?></select></div></td>";
	data +="<td><div class='input-icon right'><select style='width:170px;border:0;' name='reservation_room_category[]' id='reservation_room_category"+i+"' class='chosen form-control validate[required]' required><?php if($roomCategories){foreach($roomCategories as $key=>$val){?><option value='<?php echo $val->room_category_name?>'><?php echo $val->room_category_name; ?></option><?php }}?></select></div></td>";
	data +="<td><div class='input-icon right'><input name='booking_room_price[]' id='booking_room_price"+i+"' placeholder='' class='form-control validate[required] ramt' value='' type='text' onKeyUp='tot_bill_amt("+i+")' style='border:0; background:#FFFFFF;' autocomplete='off' onKeyPress='return is_amount(event, this)'></div></td>";
	data +="<td><div class='input-icon right'><input name='booking_room_discount[]' id='booking_room_discount"+i+"' placeholder='' class='form-control validate[required] damt' value='0' type='text' onKeyUp='tot_bill_amt("+i+")' style='border:0; background:#FFFFFF;' autocomplete='off' onKeyPress='return number(event, this)' oninput='checkNumberFieldLength(this)'></div></td>";
	data +="<td><div class='input-icon right'><input name='room_booking_price[]' id='room_booking_price"+i+"' placeholder='' class='form-control validate[required] bamt' value='' type='text' style='border:0; background:#FFFFFF;' autocomplete='off' onKeyPress='return is_amount(event, this)' readonly></div></td>";
	$('#slider_count').val(slider_count_new);
	$('table').append(data);
	i++;
	$(".chosen").chosen();
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