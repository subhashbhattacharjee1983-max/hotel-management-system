<?php 
	$this->assign('title','Bar Orders (BOT) Details');
	$this->assign('heading','Bar Orders (BOT) Details');
	$this->assign('breadcrumb','Bar Orders (BOT) Details'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'BeverageItemOrders', 'action'=>'index'])); 
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
				<div class="panel-heading">Bar Order</div>
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
													<?php echo $order_type[$beverageItemOrder->order_type]; ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Order Date
												</label>
												<div class="input-icon right">
													<?php echo $this->Common->entry_date($beverageItemOrder->order_date); ?>
												</div>
											</div>
										</div>
										<?php if($beverageItemOrder->order_type == "R"){ ?>
										<div class="col-md-12">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Room Number
												</label>
												<div class="input-icon right">
													<?php echo $beverageItemOrder->room_number; ?>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if($beverageItemOrder->order_type == "T" || $beverageItemOrder->order_type == "E"){ ?>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Invoice No
												</label>
												<div class="input-icon right">
													<?php echo $beverageItemOrder->table_number; ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Guest Name
												</label>
												<div class="input-icon right">
													<?php echo $beverageItemOrder->guest_name; ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Phone Number
												</label>
												<div class="input-icon right">
													<?php echo $beverageItemOrder->mobile_number; ?>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												Number of Persons
												</label>
												<div class="input-icon right">
													<?php echo $beverageItemOrder->number_of_persion; ?>
												</div>
											</div>
										</div>
										<?php if($beverageItemOrder->from_date != ""){ ?>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												From Date
												</label>
												<div class="input-icon right">
													<?php echo $this->Common->entry_date($beverageItemOrder->from_date); ?>
												</div>
											</div>
										</div>
										<?php } if($beverageItemOrder->to_date != ""){ ?>
										<div class="col-md-6">
											<div class="form-group">
												<label style="font-weight: bold;" for="inputName" class="control-label">
												To Date
												</label>
												<div class="input-icon right">
													<?php echo $this->Common->entry_date($beverageItemOrder->to_date); ?>
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
													<?php echo $beverageItemOrder->special_note; ?>
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
							<a href="<?=$this->Url->build(['controller'=>'BeverageItemOrders', 'action'=>'barbill', $beverageItemOrder->id]);?>" target="_blank" class="btn btn-yellow">BOT Bill</a>
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
														<?php if($beverageItemOrder->booking_id > 0){ ?>
														Booking ID: <?php echo $beverageItemOrder->booking_id ?>
														<?php }else{ ?>
														Invoice No: <?php echo $beverageItemOrder->table_number ?>
														<?php } ?>
													</label>
													<div class="form-group col-md-12" style="padding-left:0px" id="wrap">
														<table width="100%" border="1">
															<tr style="background: #4f158c;">
																<!-- <th style="text-align:center; padding:8px; color:#FFF; width:20%;">Item Category</th> -->
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Item</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Item Price (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Quantity</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Subtotal (<?php echo $site_general_settings->currency; ?>)</th>
															</tr>
															<?php
															if(!empty($beverageItemOrder->beverage_item_details))
															{
																foreach($beverageItemOrder->beverage_item_details as $key_dtls => $val)
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
															</tr>
															<?php
																}
															}
															?>
														</table>
													</div>

													<div class="col-md-4">
														<div class="form-group">
															<label for="inputName" class="control-label">
															Item Price (<?php echo $site_general_settings->currency; ?>)
															</label>
															<div class="input-icon right">
																<?php echo round($beverageItemOrder->beverage_item_price); ?>
															</div>
														</div>
													</div>													
													<div class="col-md-4">
														<div class="form-group">
															<label for="inputName" class="control-label">
															Quantity
															</label>
															<div class="input-icon right">
																<?php echo $beverageItemOrder->total_quantity; ?>
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="inputName" class="control-label">
															Sub Total (<?php echo $site_general_settings->currency; ?>)
															</label>
															<div class="input-icon right">
																<?php echo round($beverageItemOrder->sub_total); ?>
															</div>
														</div>
													</div>
												</div>
												<?php if($beverageItemOrder->booking_id == 0){ ?>
												<div class="col-md-12" style="margin-top: 27px;">
													<div class="row">
														<div class="form-group">
															<?php echo $this->Common->order_item_payment($beverageItemOrder->id, "B"); ?>
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