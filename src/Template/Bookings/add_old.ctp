<?php 
	$this->assign('title','Assign Booking to Customer');
	$this->assign('heading','Assign Booking to Customer');
	$this->assign('breadcrumb','Assign Booking to Customer'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Bookings', 'action'=>'index'])); 
	$day = date('d') + 3;
?>
<script type="text/javascript">
<!--
	$(function(){
		$("#add-form").validationEngine();
		$( "#check-in-date, #check-out-date" ).datepicker({
			dateFormat : 'yy-mm-dd'
		});
		//var value = $('input[type="checkbox"]:checked').val();
		//alert(value);
		  // Attach a click event listener to all input elements of type checkbox
		  $('input[type="checkbox"]').on('click', function() {alert("Ok");
			// Check if the clicked checkbox is checked
			if ($(this).is(':checked')) {
			  // Get the value of the checked checkbox
			  var checkboxValue = $(this).val();
			  console.log("Checkbox checked! Value: " + checkboxValue);
			} else {
			  // If the checkbox is unchecked
			  var checkboxValue = $(this).val();
			  console.log("Checkbox unchecked! Value: " + checkboxValue);
			}
		  });
	});
//-->
</script>
<div id="tab-general">
	<div class="row mbl">
		<div class="col-lg-12">
			<div class="col-md-12">
				<div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
				</div>
			</div>
		</div>
		<?php echo $this->Form->create($booking, ["name" => "edit-form", "id" => "edit-form",  "method" => "POST", 'enctype'=>'multipart/form-data']); ?>
		<div class="col-lg-6">
			<div class="panel panel-grey">
				<div class="panel-heading">Customer Information</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Full Name *
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('full_name', ['autocomplete' => 'off', 'placeholder' => 'Full Name', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Full name is required', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Email Address *
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('email_address', ['autocomplete' => 'off', 'placeholder' => 'Email Address', 'class' => 'form-control validate[required,custom[email]]', 'data-errormessage-value-missing'=>'Address is required', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Mobile Number *
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('mobile_number', ['type'=>'text', 'placeholder' => 'Mobile Number', 'autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false, 'data-errormessage-value-missing'=>'Mobile number is required']);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Guest Category *
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('guest_category',['type'=>'select','options'=>$guest_category, 'class'=>'form-control validate[required]', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Address *
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('address', ['type'=>'textarea', 'placeholder' => 'Address', 'autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
													ID Type *
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('id_type',['type'=>'select','options'=>$id_type, 'class'=>'form-control validate[required]', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Id Number *
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('id_number', ['type'=>'text', 'placeholder' => 'Id Number', 'autocomplete' => 'off', 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false, 'data-errormessage-value-missing'=>'Id number is required']);?>
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
		<div class="col-lg-6">
			<div class="panel panel-grey">
				<div class="panel-heading">Booking Details</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group attr_field">
												<label for="inputName" class="control-label">
												Rooom Details
												</label>
												<div class="input-icon right">
													<?php 
													$booking_price = "0.00";
													if(isset($room_id) && $room_id!="")
													{
														$booking_price = $rooms->room_category->price_per_night;
														echo $room_info = "Room Number: ".$rooms->room_number.' <br /> Room Categoy: '.$rooms->room_category->room_category_name.' <br /> Room Price Per Night: '.$site_general_settings->currency.$rooms->room_category->price_per_night;
														//echo $this->Form->control('room_booking_info', ['autocomplete' => 'off', 'value' => $room_info, 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false]);
													}
													else
													{
														$options_room = array();
														if(!empty($rooms))
														{
															foreach($rooms as $key => $val)
															{
																array_push($options_room, array('text' => $val->room_number.' - '.$val->room_category->room_category_name.' - '.$site_general_settings->currency.$val->room_category->price_per_night, 'value' => $val->id));
															}
														}
														echo $this->Form->control('room_ids[]', ['type'=>'select', 'options' => $options_room, 'class' => 'form-control validate[required]', 'multiple' => true, 'label'=>false, 'required'=>false, 'div'=>false]);
													}
													?>
													<!-- <select id="room-ids" name="room_ids[]" multiple>
														<?php
														/*if(!empty($rooms))
														{
															foreach($rooms as $key => $val) 
															{*/
														?>
														<option value="<?php //echo $val->id?>"><?php //echo $val->room_number.' - '.$val->room_category->room_category_name.' - '.$site_general_settings->currency.$val->room_category->price_per_night?></option>
														<?php
															/*}
														}*/
														?>
													</select> -->
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Check In Date *
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('check_in_date', ['autocomplete' => 'off', 'placeholder' => 'Check In Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => date("Y-m-d"), 'data-errormessage-value-missing'=>'Check In Date is required', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Check Out Date *
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('check_out_date', ['autocomplete' => 'off', 'placeholder' => 'Check Out Date', 'type' => 'text', 'class' => 'form-control validate[required] datepicker', 'value' => date("Y-m-").$day, 'data-errormessage-value-missing'=>'Check Out Date is required', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Adults
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('adults', ['autocomplete' => 'off', 'value' => '1', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Adults is required', 'type' => 'text', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Children
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('children', ['autocomplete' => 'off', 'value' => '0', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Children is required', 'type' => 'text', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
													Room Category
												</label>
												<div class="input-icon right">
													<?php 
													$options = array();
													if(!empty($roomCategories))
													{
														foreach($roomCategories as $key => $val)
														{
															array_push($options, array('text' => $val->room_category_name, 'value' => $val->id));
														}
													}
													echo $this->Form->control('room_category_id',['type'=>'select','options'=>$options, 'class'=>'form-control validate[required]', 'empty'=>'Room Category', 'label'=>false, 'required'=>false]); ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Booking Price (<?php echo $site_general_settings->currency; ?>)
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('booking_price', ['autocomplete' => 'off', 'value' => $booking_price, 'placeholder' => 'Booking Price', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Booking Price is required', 'type' => 'text', 'label'=>false, 'required'=>false, 'div'=>false]);?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Room Discount
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('room_discount', ['autocomplete' => 'off', 'placeholder' => 'Room Discount', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Room Discount is required', 'type' => 'text', 'label'=>false, 'required'=>false, 'div'=>false]);?>
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
		<div class="col-lg-6"></div>
		<div class="col-lg-6">
			<div class="form-body">
				<div class="row">
					<div class="col-md-12">
						<div class="text-right" style="padding-top: 7%;">
							<?=$this->Form->button('Assign Booking', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'style' => 'width: 100%; padding: 9px;', 'class'=>'btn btn-primary','value'=>'Login']);?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<script type="text/javascript">
    	$(function(){
    		$('#room-ids').multiSelect({

			  // Custom templates
			  'containerHTML': '<div class="multi-select-container">',
			  'menuHTML': '<div class="multi-select-menu">',
			  'buttonHTML': '<span class="multi-select-button">',
			  'menuItemsHTML': '<div class="multi-select-menuitems">',
			  'menuItemHTML': '<label class="multi-select-menuitem">',
			  'presetsHTML': '<div class="multi-select-presets">',

			  // sets some HTML (eg: <div class="multi-select-modal">) to enable the modal overlay.
			  'modalHTML': undefined,

			  // Active CSS class
			  'activeClass': 'multi-select-container--open',

			  // Text to show when no option is selected
			  'noneText': 'Select Rooms',

			  // Text to show when all options are selected
			  'allText': undefined,

			  // an array of preset option groups
			  // presets: [{
			  //   name: 'All categories',
			  //   all: true // select all
			  // },{
			  //   name: 'My categories',
			  //   options: ['a', 'c']
			  // }]
			  'presets': undefined,

			  // CSS class added to the container, when the menu is about to extend beyond the right edge of the position<a href="https://www.jqueryscript.net/menu/">Menu</a>Within element
			  'positionedMenuClass': 'multi-select-container--positioned',

			  // If you provide a jQuery object here, the plugin will add a class (see positionedMenuClass option) to the container when the right edge of the dropdown menu is about to extend outside the specified element, giving you the opportunity to use CSS to prevent the menu extending, for example, by allowing the option labels to wrap onto multiple lines.
			  'positionMenuWithin': undefined,

			  // The plugin will attempt to keep this distance, in pixels, clear between the bottom of the menu and the bottom of the viewport, by setting a fixed height style if the menu would otherwise approach this distance from the bottom edge of the viewport.
			  'viewportBottomGutter': 20,

			  // minimal height
			  'menuMinHeight': 200
			  
			});
    	});
    </script>

<style type="text/css">
	.attr_field .multi-select-menuitem {
	  font-size: 14px;
	  color: #555;
	  display: block;
	}
	.multi-select-button {
	  width: 100%;
	  display: inline-block;
	  height: 34px;
	  padding: 7px 12px;
	  font-size: 14px;
	  white-space: nowrap;
	  overflow: hidden;
	  text-overflow: ellipsis;
	  vertical-align: -0.5em;
	  border: 1px solid #e5e5e5;
	  cursor: default;
	  color: #555;
	  
	}
	.multi-select-menu {
	  position: absolute;
	  left: 0;
	  top: 1.5em;
	  float: left;
	  min-width: 100%;
	  background: #fff;
	  margin: 1em 0;
	  border: 1px solid #e5e5e5;
	  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
	  display: none;
	  z-index: 1;
	  padding: 10px;
	}
	.multi-select-container--open .multi-select-menu {
	  display: block;
	}
</style>