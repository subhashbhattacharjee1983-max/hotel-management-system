<?php 
	$this->assign('title','All Bookings');
	$this->assign('heading','List of All Bookings');
	$this->assign('breadcrumb','All Bookings'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Bookings', 'action'=>'index']));
	$today_year = date('Y');
	$year = isset($this->request->getParam('pass')[0]) && $this->request->getParam('pass')[0] != "" ? str_replace("_", " ", $this->request->getParam('pass')[0]) : "";
	if(isset($year) && $year!="")
	{
		$today_year = $year;
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
			<div class="col-lg-12">
				<div id="notify_msg_div"></div>
			</div>
			<div class="col-lg-12">
				 <div class="panel panel-grey">
				 
					<div class="panel-heading">
						<div class="row">
							<div class="col-lg-2">All Bookings</div>
							<div class="col-lg-6">
								<?php for($i=2025;$i<=date('Y');$i++){ ?>
									<a href="<?php echo $this->Url->build(['controller'=>'Bookings', 'action'=>'oldbooking', $i]); ?>" class="btn year-btn <?php echo $i == $today_year ? 'btn-orange-middle' : 'btn-success' ?>"><?php echo $i; ?></a>
								<?php } ?>
							</div>
							<div class="col-lg-4" style="text-align: right;">
								<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'add']);?>" class="btn btn-orange-middle">Add Bookings</a>
								<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'unpaid']);?>" class="btn btn-success">Unpaid Bookings</a>
							</div>
						</div>
					</div>					
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel-body pan">
									<div class="form-body pal">
										<div class="newsCategorys index">
											<table cellpadding="0" cellspacing="0" class="table table-hover">
												<thead>
													<tr>
														<th>Booking ID</th>
														<th>Room Number</th>
														<th>Customer</th>
														<th>Check In</th>
														<th>Check Out</th>
														<th>Booking Status</th>
														<th>Payment Status</th>
														<th>Booking Date</th>
														<th class="actions"><?php echo __('Actions'); ?></th>
													</tr>
												</thead>
												<tbody>
												<?php 
													$i=0;
												if(!empty($bookings))
												{
													foreach ($bookings as $booking):
													$i++;
													if($booking->payment_status == "P"){
														$payment_status_booking = "btn-success";
													}else if($booking->payment_status == "U"){
														$payment_status_booking = "btn-danger";
													}else{
														$payment_status_booking = "btn-yellow";
													}
													$show_rooms = $this->Common->show_rooms($booking->id);
												?>
													<tr>
														<td><?php echo h($booking->id); ?></td>
														<td><?php echo $show_rooms; ?></td>
														<td><?php echo h($booking->customer->full_name); ?></td>
														<td><?php echo h($this->Common->entry_date($booking->check_in_date)); ?></td>
														<td><?php echo h($this->Common->entry_date($booking->check_out_date)); ?></td>
														<td><a style="width: 100px;" class="status_btn status_checks <?=$booking->booking_status=='C' ? "btn-success" : "btn-info";?>"><?php echo h($booking_status[$booking->booking_status]); ?></a></td>
														<td><a style="width: 85px;" class="status_btn status_checks <?php echo $payment_status_booking ?>"><?php echo h($payment_status[$booking->payment_status]); ?></a></td>
														<td><?php echo h(date("d/m/Y H:i:s",strtotime($booking->booking_date))); ?></td>
														<td class="actions">															
															<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'view',$booking->id]);?>"><?=$this->Html->image('/img/icons/view.png', array('alt' => 'View Booking Details', 'border' => '0', 'title' => 'View Booking Details'))?></a>&nbsp;
															<?php if($booking->payment_status != "P"){ ?>
															<a href="<?=$this->Url->build(['controller'=>'BookingPayments', 'action'=>'index',$booking->id]);?>"><?=$this->Html->image('/img/icons/payment.png', array('alt' => 'Payment', 'border' => '0', 'title' => 'Payment'))?></a>&nbsp;
															<?php } ?>
														</td>
													</tr>
												<?php 
													endforeach;
												}
												?>
												</tbody>
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
</div>