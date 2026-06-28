<?php 
	$this->assign('title','Room Report');
	$this->assign('heading','List of Room Report');
	$this->assign('breadcrumb','Room Report'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Bookings', 'action'=>'report'])); 
	$start_date_room = $this->request->getQuery('start_date_room');
	$end_date_room = $this->request->getQuery('end_date_room');
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
							<div class="col-lg-6">Room Report From <?php echo $start_date_room ?> to <?php echo $end_date_room ?></div>
							<div class="col-lg-6" style="text-align: right;">
								<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'roombillcsv', $start_date_room, $end_date_room]);?>" target="_blank" class="btn btn-success">Export CSV</a>
								<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'roombillpdf', $start_date_room, $end_date_room]);?>" target="_blank" class="btn btn-orange-middle">View PDF</a>
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
														<th>Booking Number</th>	
														<th>Room Number</th>
														<th>Customer Name</th>
														<th>Mobile Number</th>
														<th>Check In</th>
														<th>Check Out</th>
														<th>Total Room Charge</th>
														<th>Total Service Charge</th>
														<th>Total BST Charge</th>
														<th>Total GST Charge</th>
														<th>Bank Transfer Charge</th>
														<th>Grand Total</th>
													</tr>
												</thead>
												<tbody>
												<?php 
												$i=0;
												$all_room_amount = 0;
												$all_bst_tax = 0;
												$all_service_tax = 0;
												$all_gst_tax = 0;
												$all_bank_transfer_charge = 0;
												$all_grand_amount = 0;
												if(!empty($bookings))
												{
													foreach ($bookings as $booking):
													$i++;
													$show_rooms = $this->Common->show_rooms($booking->id);
													$room_charge = round($booking->booking_price) * $booking->number_of_night; 
													$all_room_amount = $all_room_amount + $room_charge;
													$bst_tax = 0;
													$service_tax = 0;
													$gst_tax = 0;
													$bank_transfer_charge = 0;
													if($booking->allow_bst == "Y")
													{
														$bst_tax = round(($all_room_amount * $booking->bst_tax)/100);
													}
													if($booking->allow_service_charge == "Y")
													{
														$service_tax = round(($all_room_amount * $booking->service_tax)/100);
													}
													if($booking->allow_gst == "Y")
													{
														$gst_tax = round(($all_room_amount * $booking->gst_tax)/100);
													}
													if($booking->allow_bank_transfer_charge == "Y")
													{
														$bank_transfer_charge = $booking->bank_transfer_charge;
													}
													$all_bst_tax = $all_bst_tax + $bst_tax;
													$all_service_tax = $all_service_tax + $service_tax;
													$all_gst_tax = $all_gst_tax + $gst_tax;
													$all_bank_transfer_charge = $all_bank_transfer_charge + $bank_transfer_charge;
													$grand_total_booking_amount = $room_charge + $bst_tax + $service_tax + $gst_tax + $bank_transfer_charge;
													$all_grand_amount = $all_grand_amount + $grand_total_booking_amount;
												?>
													<tr>
														<td><?php echo h($booking->id); ?></td>	
														<td><?php echo $show_rooms; ?></td>
														<td><?php echo h($booking->customer->full_name); ?> <a href="<?=$this->Url->build(['controller'=>'Customers', 'action'=>'view',$booking->customer_id]);?>" target="_blank"><?=$this->Html->image('/img/icons/view.png', array('alt' => 'View', 'border' => '0'))?></a></td>
														<td><?php echo h($booking->customer->mobile_number); ?></td>
														<td><?php echo h($this->Common->entry_date($booking->check_in_date)); ?></td>
														<td><?php echo h($this->Common->entry_date($booking->check_out_date)); ?></td>
														<td><?php echo $site_general_settings->currency.round($room_charge); ?></td>
														<td><?php echo $site_general_settings->currency.round($service_tax); ?> (<?php echo $booking->service_tax; ?>%)</td>
														<td><?php echo $site_general_settings->currency.round($bst_tax); ?> (<?php echo $booking->bst_tax; ?>%)</td>
														<td><?php echo $site_general_settings->currency.round($gst_tax); ?> (<?php echo $booking->gst_tax; ?>%)</td>
														<td><?php echo $site_general_settings->currency.round($bank_transfer_charge); ?></td>
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
														<th></th>
														<th></th>
														<th><?php echo $site_general_settings->currency.round($all_room_amount); ?></th>
														<th><?php echo $site_general_settings->currency.round($all_service_tax); ?></th>
														<th><?php echo $site_general_settings->currency.round($all_bst_tax); ?></th>
														<th><?php echo $site_general_settings->currency.round($all_gst_tax); ?></th>
														<th><?php echo $site_general_settings->currency.round($all_bank_transfer_charge); ?></th>
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