<?php 
	$this->assign('title','Assign Booking to Customer / Travel Agency');
	$this->assign('heading','Assign Booking to Customer / Travel Agency');
	$this->assign('breadcrumb','Assign Booking to Customer / Travel Agency'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Bookings', 'action'=>'index'])); 
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

	$(document).ready(function(){

		$("#aadhaar-image").on("change", function(){

			var file = this.files[0];

			if(!file){
				return false;
			}

			var formData = new FormData();
			formData.append('aadhaar_image', file);

			$.ajax({
				url: "<?php echo $this->Url->build(['controller'=>'Ocr', 'action'=>'aadhaar'])?>",
				type: "POST",
				data: formData,
				processData: false,
				contentType: false,
				dataType: "json",
				headers : {
					'X-CSRF-Token': "<?php echo $this->request->getParam('_csrfToken');?>"
				},
				success: function(response) {
					console.log(response);

					if(response.success){
						$("#aadhaar_no").val(response.aadhaar_no);
						$("#full-name").val(response.name);
						$("#dob").val(response.dob);
						$("#address").val(response.address);
					} else {
						showCustomMessage('<div class="message error">'+response.message+'</div>');
					}
				},

				error: function(xhr, status, error){

					console.log(xhr.responseText);
					console.log(status);
					console.log(error);

					showCustomMessage('<div class="message error">'+xhr.responseText+'</div>');
				}
			});

		});

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
		<?php echo $this->Form->create($booking, ["name" => "add-form", "id" => "add-form",  "method" => "POST", 'enctype'=>'multipart/form-data']); ?>
		<div class="col-lg-4">
			<div class="panel panel-grey">
				<div class="panel-heading">Customer / Travel Agency Information</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<!-- <div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Upload Aadhaar <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php //echo $this->Form->control('aadhaar_image', ['autocomplete' => 'off', 'type' => 'file', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Aadhaar is required', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div> -->
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
													Booking Type
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('booking_type',['type'=>'select','options'=>$booking_type, 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?>
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
												Room Details
												</label>
												<div class="input-icon right">
													<?php 
													$booking_price = "0.00";
													if(isset($room_id) && $room_id!="")
													{
														$booking_price = $rooms[0]->room_category->price_per_night;
														//echo $room_info = "Room Number: ".$rooms->room_number.' <br /> Room Categoy: '.$rooms->room_category->room_category_name.' <br /> Room Price Per Night: '.$site_general_settings->currency.$rooms->room_category->price_per_night;
														//echo $this->Form->control('room_booking_info', ['autocomplete' => 'off', 'value' => $room_info, 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);
													}
													else
													{
														/*$options_room = array();
														if(!empty($rooms))
														{
															foreach($rooms as $key => $val)
															{
																array_push($options_room, array('text' => $val->room_number.' - '.$val->room_category->room_category_name.' - '.$site_general_settings->currency.$val->room_category->price_per_night, 'value' => $val->id));
															}
														}
														echo $this->Form->control('room_ids[]', ['type'=>'select', 'options' => $options_room, 'class' => 'form-control validate[required]', 'multiple' => true, 'label'=>false, 'required'=>false, 'div'=>false]);*/
													}
													?>
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
																		<select style="width:270px; border:0;" name="booking_room_name[]" id="booking_room_name1" class="chosen form-control validate[required]" required>
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
																		<select style="width:170px; border:0;" name="booking_room_category[]" id="booking_room_category1" class="chosen form-control validate[required]" required>
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
																		<input name="booking_room_price[]" id="booking_room_price1" placeholder="" class="form-control validate[required] ramt" value="<?php echo $booking_price ?>" type="text" onKeyUp="tot_bill_amt(1)" style="border:0; background:#FFFFFF;" autocomplete="off" onKeyPress="return is_amount(event, this)">
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

													<?php
													if(isset($room_id) && $room_id!="")
													{
														//
													}
													else
													{
													?>
													<div class="form-group col-md-12 text-right" style="padding-left:0px">
													   <a href="javascript:void(0)" style="color: #FFF;" class='addmore item-button'>Add Room </a>
													   <a href="javascript:void(0)" style="margin-left: 10px; color: #FFF;" class='delete item-button'>Remove Room</a>
													</div>
													<?php
													}
													?>
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
													<?php echo $this->Form->control('adults', ['autocomplete' => 'off', 'value' => '1', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Adults is required', 'type' => 'text', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'oninput' => "checkNumberFieldLength(this);"]);?>
												</div>
											</div>
										</div>										
										<div class="col-md-4">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Children <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('children', ['autocomplete' => 'off', 'value' => '0', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Children is required', 'type' => 'text', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'oninput' => "checkNumberFieldLength(this);"]);?>
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
							<?=$this->Form->button('Assign Booking', ['type'=>'button', 'name'=>'btn_submit', 'id'=>'btn_submit', 'style' => 'width: 100%; padding: 9px;', 'class'=>'btn btn-booking', 'value'=>'Submit', 'onclick' => 'YourOnSubmitFn()']);?>
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
	data +="<td><div class='input-icon right'><select style='width:270px;border:0;' name='booking_room_name[]' id='booking_room_name"+i+"' class='chosen form-control validate[required]' required><?php if($rooms){foreach($rooms as $key=>$val){?><option value='<?php echo $val->room_number ?>'><?php echo $val->room_number.' - '.$val->room_category->room_category_name.' - '.$site_general_settings->currency.$val->room_category->price_per_night; ?></option><?php }}?></select></div></td>";
	data +="<td><div class='input-icon right'><select style='width:170px;border:0;' name='booking_room_category[]' id='booking_room_category"+i+"' class='chosen form-control validate[required]' required><?php if($roomCategories){foreach($roomCategories as $key=>$val){?><option value='<?php echo $val->room_category_name?>'><?php echo $val->room_category_name; ?></option><?php }}?></select></div></td>";
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