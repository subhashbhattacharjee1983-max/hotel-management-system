<?php 
	$this->assign('title','Food & Kitchen Report');
	$this->assign('heading','List of Food & Kitchen Report');
	$this->assign('breadcrumb','Food & Kitchen Report'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Bookings', 'action'=>'report'])); 
	$start_date_food = $this->request->getQuery('start_date_food');
	$end_date_food = $this->request->getQuery('end_date_food');
?>
	<div id="tab-general">
		<div class="row mbl">
			<div class="col-lg-12">
				<div class="col-md-12">
					<div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div id="notify_msg_div"></div>
			</div>
			<div class="col-lg-12">
				 <div class="panel panel-grey">
				 
					<div class="panel-heading">
						<div class="row">
							<div class="col-lg-6">Food & Kitchen Report From <?php echo $start_date_food ?> to <?php echo $end_date_food ?></div>
							<div class="col-lg-6" style="text-align: right;">
								<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'foodbillcsv', $start_date_food, $end_date_food]);?>" target="_blank" class="btn btn-success">Export CSV</a>
								<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'foodbillpdf', $start_date_food, $end_date_food]);?>" target="_blank" class="btn btn-orange-middle">View PDF</a>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel-body pan">
									<div class="form-body pal">
											<table cellpadding="0" cellspacing="0" class="table table-hover">
												<thead>
													<tr>
														<th>SL No</th>	
														<th>Room / Table Number</th>
														<th>Customer Name</th>
														<th>Mobile Number</th>
														<th>Total Food Charge</th>
														<th>Total Service Charge (<?php echo $site_general_settings->food_service_tax; ?>%)</th>
														<th>Total BST Charge (<?php echo $site_general_settings->food_bst_tax; ?>%)</th>
														<th>Total GST Charge (<?php echo $site_general_settings->food_gst_tax; ?>%)</th>
														<th>Grand Total</th>
													</tr>
												</thead>
												<tbody>
												<?php 
												$i=0; 
												$all_food_amount = 0;
												$all_bst_tax = 0;
												$all_service_tax = 0;
												$all_gst_tax = 0;
												$all_grand_amount = 0;
												if(!empty($foodItemOrders))
												{
													foreach ($foodItemOrders as $key => $foodItemOrder):
													$i++;
													if($foodItemOrder->booking_id > 0){
														$show_rooms = "Room: ".$this->Common->show_rooms($foodItemOrder->booking_id);
														$booking = $this->Common->booking_customer_details($foodItemOrder->booking_id);
														$customer_name = $booking->customer->full_name;
														$mobile_number = $booking->customer->mobile_number;
													}else{
														$show_rooms = "Table: ".$foodItemOrder->table_number;
														$customer_name = $foodItemOrder->guest_name;
														$mobile_number = $foodItemOrder->mobile_number;
													}
													$food_charge = round($foodItemOrder->sub_total); 
													$all_food_amount = $all_food_amount + $food_charge;
													$bst_tax = round(($food_charge * $site_general_settings->food_bst_tax)/100);
													$service_tax = round(($food_charge * $site_general_settings->food_service_tax)/100);
													$gst_tax = round(($food_charge * $site_general_settings->food_gst_tax)/100);
													
													$all_bst_tax = $all_bst_tax + $bst_tax;
													$all_service_tax = $all_service_tax + $service_tax;
													$all_gst_tax = $all_gst_tax + $gst_tax;
													$grand_total_booking_amount = $food_charge + $bst_tax + $service_tax + $gst_tax;
													$all_grand_amount = $all_grand_amount + $grand_total_booking_amount;
												?>
													<tr>
														<td><?php echo $key + 1; ?></td>	
														<td><?php echo $show_rooms; ?></td>
														<td><?php echo $customer_name; ?></td>
														<td><?php echo $mobile_number; ?></td>
														<td><?php echo $site_general_settings->currency.round($food_charge); ?></td>
														<td><?php echo $site_general_settings->currency.round($service_tax); ?></td>
														<td><?php echo $site_general_settings->currency.round($bst_tax); ?></td>
														<td><?php echo $site_general_settings->currency.round($gst_tax); ?></td>
														<td><?php echo $site_general_settings->currency.round($grand_total_booking_amount); ?></td>
													</tr>
												<?php 
													endforeach;
												}
												?>
												</tbody>
												<thead>
													<tr>
														<th></th>
														<th></th>
														<th></th>
														<th></th>
														<th><?php echo $site_general_settings->currency.round($all_food_amount); ?></th>
														<th><?php echo $site_general_settings->currency.round($all_service_tax); ?></th>
														<th><?php echo $site_general_settings->currency.round($all_bst_tax); ?></th>
														<th><?php echo $site_general_settings->currency.round($all_gst_tax); ?></th>
														<th><?php echo $site_general_settings->currency.round($all_grand_amount); ?></th>
													</tr>
												</thead>
											</table>
											<div class="col-lg-12 col-md-12">
												<ul class="service_pagination">
													<?php echo $this->Paginator->prev('< ' . __(''), array(), null, array('class' => 'prev page-numbers disabled'));?>
													<?php echo $this->Paginator->numbers(array('separator' => ''));?>
													<?php echo $this->Paginator->next(__('') . ' >', array(), null, array('class' => 'next page-numbers disabled'));?>
												</ul>
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