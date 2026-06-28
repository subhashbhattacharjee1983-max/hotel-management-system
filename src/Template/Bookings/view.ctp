<?php 
	$this->assign('title','Booking Details');
	$this->assign('heading','Booking Details');
	$this->assign('breadcrumb','Booking Details'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Bookings', 'action'=>'index'])); 
?>
<div id="tab-general">
	<div class="row mbl">
		<div class="col-lg-12">
			<div class="col-md-12">
				<div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
				</div>
			</div>
		</div>
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
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-6">Booking Details for Booking Id: <?php echo $booking->id ?></div>
						<div class="col-lg-6" style="text-align: right;">
							<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'masterbill', $booking->id]);?>" class="btn btn-success">Master Bill</a>
							<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'roombill', $booking->id]);?>" class="btn btn-info">Room Bill</a>
							<?php 
							if(!empty($foodItemOrder))
							{
							?>
							<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'foodbill', $booking->id]);?>" class="btn btn-yellow">KOT Bill</a>
							<?php 
							}
							if(!empty($bavarageItemOrder))
							{
							?>
							<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'barbill', $booking->id]);?>" class="btn btn-orange">BOT Bill</a>
							<?php
							}
							?>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<label style="font-size: 17px; padding: 0 0 15px;" for="inputName" class="control-label">
												<?php
												if($booking->payment_status == "P"){
													$payment_status_booking = "btn-success";
												}else if($booking->payment_status == "U"){
													$payment_status_booking = "btn-danger";
												}else{
													$payment_status_booking = "btn-yellow";
												}
												?>
												<a style="width: 100%; border-radius: 7px;" class="status_btn status_checks <?php echo $payment_status_booking ?>">Payment Status: <?php echo $payment_status[$booking->payment_status]; ?></a>
											</label>
											<label style="font-size: 17px; padding: 0 0 15px; margin-left:5px;" for="inputName" class="control-label">
												<a style="width: 100%; border-radius: 7px;" class="status_btn status_checks btn-orange-middle">Booking Type: <?php echo $booking_type[$booking->booking_type]; ?></a>
											</label>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Booking Package
												</label>
												<div class="input-icon right">
													<?php echo $booking->booking_package; ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Booking Food Plan
												</label>
												<div class="input-icon right">
													<?php echo $booking->food_plan; ?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="input-icon right">
												<div class="col-md-12 btn btn-success" style="padding: 7px; margin: 17px 0; text-align: left; font-size: 17px;">Room Details</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Check In Date
												</label>
												<div class="input-icon right">
													<?php echo $this->Common->entry_date($booking->check_in_date);?>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Check Out Date
												</label>
												<div class="input-icon right">
													<?php echo $this->Common->entry_date($booking->check_out_date);?>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Adults
												</label>
												<div class="input-icon right">
													<?php echo $booking->adults;?>
												</div>
											</div>
										</div>										
										<div class="col-md-3">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Children
												</label>
												<div class="input-icon right">
													<?php echo $booking->children;?>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Number Of Night
												</label>
												<div class="input-icon right">
													<?php echo $booking->number_of_night;?>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Room Price (<?php echo $site_general_settings->currency; ?>)
												</label>
												<div class="input-icon right">
													<?php echo round($booking->room_price);?>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Booking Price (<?php echo $site_general_settings->currency; ?>)
												</label>
												<div class="input-icon right">
													<?php echo round($booking->booking_price);?>
												</div>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Room Discount (%)
												</label>
												<div class="input-icon right">
													<?php echo $booking->room_discount;?>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group attr_field">
												<div class="input-icon right">
													<div class="form-group col-md-12" style="padding-left:0px" id="room">
														<table width="100%" border="1">
															<tr style="background: #4f158c;">
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Room Number</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Room Category</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Room Price (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Discount (%)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Booking Price (<?php echo $site_general_settings->currency; ?>)</th>
															</tr>
															<?php
															if(!empty($booking->booking_room_details))
															{
																foreach($booking->booking_room_details as $key_dtls => $val)
																{
															?>
															<tr>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo $val->booking_room_name; ?>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo $val->booking_room_category; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo round($val->booking_room_price) ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo $val->booking_room_discount; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">																		
																		<?php echo round($val->room_booking_price); ?>
																	</div>
																</td>
															</tr>
															<?php
																}
															}
															?>
														</table>
													</div>
												</div>
												<div class="col-md-12">
													<div class="row">
														<?php $total_room_booking_amount = round($booking->booking_price) * $booking->number_of_night; ?>
														<label style="font-size: 17px; font-weight: bold; color: #f2994b;" for="inputName" class="control-label">Total Room Booking Amount: <?php echo $site_general_settings->currency; ?> <?php echo round($total_room_booking_amount); ?> (<?php echo $this->Common->convert_number_to_words($total_room_booking_amount); ?>)</label>
													</div>
												</div>
												<?php 
												if(!empty($foodItemOrder))
												{
												?>												
												<div class="input-icon right">
													<div class="col-md-12 btn btn-yellow" style="padding: 7px; margin: 27px 0; text-align: left; font-size: 17px;">Food & Kitchen Order (KOT) Details</div>
													<?php
													$sub_total_kitchen_amount = 0;
													foreach($foodItemOrder as $food_key => $food_val)
													{
														$sub_total_kitchen_amount = $sub_total_kitchen_amount + $food_val->sub_total;
														$food_item_details = $this->Common->food_item_details($food_val->id);
													?>
													<div class="col-md-12">
														<div class="row">
															<label style="font-weight: bold;" for="inputName" class="control-label">Room Number: <?php echo $food_val->room_number; ?></label>
														</div>
													</div>
													<?php
													if(!empty($food_item_details))
													{
													?>
													<div class="form-group col-md-12" style="padding-left:0px" id="food">
														<table width="100%" border="1">
															<tr style="background: #4f158c;">
																<!-- <th style="text-align:center; padding:8px; color:#FFF; width:20%;">Item Category</th> -->
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Item</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Item Price (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:5%;">Quantity</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Subtotal (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Order Date</th>
															</tr>
															<?php
															foreach($food_item_details as $key_dtls => $val)
															{
															?>
															<tr>
																<!-- <td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php //echo $val->food_item_category; ?>
																	</div>
																</td> -->																
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo $val->food_item_name; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo round($val->price); ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo $val->quantity; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo round($val->sub_total); ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo $this->Common->entry_date($val->order_date); ?>
																	</div>
																</td>
															</tr>
															<?php
															}
															?>
														</table>
													</div>
													<?php
														}
													}
													?>
													<div class="col-md-12">
														<div class="row">
															<label style="font-size: 17px; font-weight: bold; color: #f2994b;" for="inputName" class="control-label">Total Food & Kitchen Amount: <?php echo $site_general_settings->currency; ?> <?php echo round($sub_total_kitchen_amount); ?> (<?php echo $this->Common->convert_number_to_words($sub_total_kitchen_amount); ?>)</label>
														</div>
													</div>
												</div>
												<?php
												}
												?>
												<?php 
												if(!empty($bavarageItemOrder))
												{
												?>												
												<div class="input-icon right">
													<div class="col-md-12 btn btn-orange" style="padding: 7px; margin: 27px 0; text-align: left; font-size: 17px;">Beverage & Bar Order (BOT) Details</div>
													<?php
													$sub_total_bar_amount = 0;
													foreach($bavarageItemOrder as $beverage_key => $beverage_val)
													{
														$sub_total_bar_amount = $sub_total_bar_amount + $beverage_val->sub_total;
														$beverage_item_details = $this->Common->beverage_item_details($beverage_val->id);
													?>
													<div class="col-md-12">
														<div class="row">
															<label style="font-weight: bold;" for="inputName" class="control-label">Room Number: <?php echo $beverage_val->room_number; ?></label>
														</div>
													</div>
													<?php
													if(!empty($beverage_item_details))
													{
													?>
													<div class="form-group col-md-12" style="padding-left:0px" id="bar">
														<table width="100%" border="1">
															<tr style="background: #4f158c;">
																<!-- <th style="text-align:center; padding:8px; color:#FFF; width:20%;">Item Category</th> -->
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Item</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Item Price (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:5%;">Quantity</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Subtotal (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Order Date</th>
															</tr>
															<?php
															foreach($beverage_item_details as $key_dtls => $val)
															{
															?>
															<tr>
																<!-- <td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php //echo $val->beverage_item_category; ?>
																	</div>
																</td> -->																
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo $val->beverage_item_name; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo round($val->price); ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo $val->quantity; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo round($val->sub_total); ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo $this->Common->entry_date($val->order_date); ?>
																	</div>
																</td>
															</tr>
															<?php
															}
															?>
														</table>
													</div>
													<?php
														}
													}
													?>
													<div class="col-md-12">
														<div class="row">
															<label style="font-size: 17px; font-weight: bold; color: #f2994b;" for="inputName" class="control-label">Total Beverage & Bar Order Amount: <?php echo $site_general_settings->currency; ?> <?php echo round($sub_total_bar_amount); ?> (<?php echo $this->Common->convert_number_to_words($sub_total_bar_amount); ?>)</label>
														</div>
													</div>
												</div>
												<?php
												}
												?>
												<?php 
												if(!empty($housekeepingOrders))
												{
												?>												
												<div class="input-icon right">
													<div class="col-md-12 btn btn-pink" style="padding: 7px; margin: 27px 0; text-align: left; font-size: 17px;">House keeping / Service Details</div>
													<div class="form-group col-md-12" style="padding-left:0px" id="service">
														<table width="100%" border="1">
															<tr style="background: #4f158c;">
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Room Number</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Service Name</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Service Price (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Quantity</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Sub Total (<?php echo $site_general_settings->currency; ?>)</th>
															</tr>
															<?php
															$sub_total_house_keeping_amount = 0;
															foreach($housekeepingOrders as $key_dtls => $val)
															{
																$sub_total_house_keeping_amount = $sub_total_house_keeping_amount + $val->sub_total;
															?>
															<tr>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo $val->room_number; ?>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right text-center">
																		<?php echo $val->service_name; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center">
																		<?php echo round($val->service_price); ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center">
																		<?php echo $val->quantity; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center">
																		<?php echo round($val->sub_total); ?>
																	</div>
																</td>
															</tr>
															<?php
															}
															?>
														</table>
													</div>
													<div class="col-md-12">
														<div class="row">
															<label style="font-size: 17px; font-weight: bold; color: #f2994b;" for="inputName" class="control-label">Total House keeping Amount: <?php echo $site_general_settings->currency; ?> <?php echo round($sub_total_house_keeping_amount); ?> (<?php echo $this->Common->convert_number_to_words($sub_total_house_keeping_amount); ?>)</label>
														</div>
													</div>
												</div>
												<?php
												}
												if(!empty($bookingPayments))
												{
												?>
												<div class="input-icon right">
													<div class="col-md-12 btn btn-warning" style="padding: 7px; margin: 27px 0; text-align: left; font-size: 17px;">All Payment Details</div>
													<?php echo $this->Common->verify_booking_payment($booking->id); ?>
												</div>
												<?php
												}
												if(!empty($refundPayments))
												{
												?>
												<div class="input-icon right">
													<div class="col-md-12 btn btn-warning" style="padding: 7px; margin: 27px 0; text-align: left; font-size: 17px;">Refund Payment to <?php echo $booking->customer->full_name ?></div>
													<?php echo $this->Common->refund_payment($booking->id); ?>
												</div>
												<?php
												}
												?>
												<div class="col-md-12" style="margin-top: 27px;">
													<div class="row">
														<div class="form-group">
															<?php echo $this->Common->booking_payment($booking->id); ?>
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
			</div>
		</div>		
	</div>
</div>