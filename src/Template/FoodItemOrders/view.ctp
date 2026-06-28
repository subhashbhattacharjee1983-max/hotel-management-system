<?php 
	$this->assign('title','Kitchen Order (KOT) Details');
	$this->assign('heading','Kitchen Order (KOT) Details');
	$this->assign('breadcrumb','Kitchen Order (KOT) Details'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'FoodItemOrders', 'action'=>'index'])); 
	$qty = "Quantity";
	if($foodItemOrder->order_type == "C"){
		$qty = "No of Heads";
	}
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
				<div class="panel-heading">Kitchen Order</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Order Type
												</label>
												<div class="input-icon right">
													<?php echo $order_type[$foodItemOrder->order_type]; ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Order Date
												</label>
												<div class="input-icon right">
													<?php echo $this->Common->entry_date($foodItemOrder->order_date); ?>
												</div>
											</div>
										</div>
										<?php if($foodItemOrder->order_type == "R"){ ?>
										<div class="col-md-12">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Room Number
												</label>
												<div class="input-icon right">
													<?php echo $foodItemOrder->room_number; ?>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if($foodItemOrder->order_type == "T" || $foodItemOrder->order_type == "E" || $foodItemOrder->order_type == "C"){ ?>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Invoice No
												</label>
												<div class="input-icon right">
													<?php echo $foodItemOrder->table_number; ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Guest Name
												</label>
												<div class="input-icon right">
													<?php echo $foodItemOrder->guest_name; ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Phone Number
												</label>
												<div class="input-icon right">
													<?php echo $foodItemOrder->mobile_number; ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Number of Persons
												</label>
												<div class="input-icon right">
													<?php echo $foodItemOrder->number_of_persion; ?>
												</div>
											</div>
										</div>
										<?php if($foodItemOrder->from_date != ""){ ?>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												From Date
												</label>
												<div class="input-icon right">
													<?php echo $this->Common->entry_date($foodItemOrder->from_date); ?>
												</div>
											</div>
										</div>
										<?php } if($foodItemOrder->to_date != ""){ ?>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												To Date
												</label>
												<div class="input-icon right">
													<?php echo $this->Common->entry_date($foodItemOrder->to_date); ?>
												</div>
											</div>
										</div>
										<?php } ?>
										<div class="col-md-12">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Special Notes
												</label>
												<div class="input-icon right">
													<?php echo $foodItemOrder->special_note; ?>
												</div>
											</div>
										</div>										
										<?php } ?>
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
						<div class="col-lg-6">Item Details</div>
						<div class="col-lg-6" style="text-align: right;">
							<a href="<?=$this->Url->build(['controller'=>'FoodItemOrders', 'action'=>'foodbill', $foodItemOrder->id]);?>" target="_blank" class="btn btn-yellow">KOT Bill</a>
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
											<div class="form-group attr_field">
												<div class="input-icon right">
													<label style="font-size: 17px; padding: 0 0 15px;" for="inputName" class="control-label">
														<?php if($foodItemOrder->booking_id > 0){ ?>
														Booking ID: <?php echo $foodItemOrder->booking_id ?>
														<?php }else{ ?>
														Invoice No: <?php echo $foodItemOrder->table_number ?>
														<?php } ?>
													</label>
													<div class="form-group col-md-12" style="padding-left:0px" id="wrap">
														<table width="100%" border="1">
															<tr style="background: #4f158c;">
																<!-- <th style="text-align:center; padding:8px; color:#FFF; width:20%;">Item Category</th> -->
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Item</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Item Price (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;"><?php echo $qty ?></th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">No of Day</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Subtotal (<?php echo $site_general_settings->currency; ?>)</th>
															</tr>
															<?php
															if(!empty($foodItemOrder->food_item_details))
															{
																foreach($foodItemOrder->food_item_details as $key_dtls => $val)
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
																		<?php echo $val->item_no_of_days; ?>
																	</div>
																</td>
																<td>
																	<div class="input-icon right text-center" style="padding: 9px;">
																		<?php echo round($val->sub_total); ?>
																	</div>
																</td>
															</tr>
															<?php
																}
															}
															?>
														</table>
													</div>

													<div class="col-md-3">
														<div class="form-group">
															<label for="inputName" class="control-label">
															Item Price (<?php echo $site_general_settings->currency; ?>)
															</label>
															<div class="input-icon right">
																<?php echo round($foodItemOrder->food_item_price); ?>
															</div>
														</div>
													</div>													
													<div class="col-md-3">
														<div class="form-group">
															<label for="inputName" class="control-label">
															Quantity
															</label>
															<div class="input-icon right">
																<?php echo $foodItemOrder->total_quantity; ?>
															</div>
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label for="inputName" class="control-label">
															No of Day
															</label>
															<div class="input-icon right">
																<?php echo $foodItemOrder->total_no_of_days; ?>
															</div>
														</div>
													</div>
													<div class="col-md-3">
														<div class="form-group">
															<label for="inputName" class="control-label">
															Sub Total (<?php echo $site_general_settings->currency; ?>)
															</label>
															<div class="input-icon right">
																<?php echo round($foodItemOrder->sub_total); ?>
															</div>
														</div>
													</div>
												</div>
												<?php if($foodItemOrder->booking_id == 0){ ?>
												<div class="col-md-12" style="margin-top: 27px;">
													<div class="row">
														<div class="form-group">
															<?php echo $this->Common->order_item_payment($foodItemOrder->id, "F"); ?>
														</div>
													</div>
												</div>
												<?php } ?>
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