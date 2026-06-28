<?php 
	$this->assign('title','Reservations');
	$this->assign('heading','List of Reservations');
	$this->assign('breadcrumb','Reservations'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Bookings', 'action'=>'reservation'])); 
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
							<div class="col-lg-6">Reservations</div>
							<div class="col-lg-6" style="text-align: right;">
								<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'add']);?>" class="btn btn-orange-middle">Add Bookings</a>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="panel-body pan">
									<div class="form-body pal">
										<div class="newsCategorys index">
											<table cellpadding="0" cellspacing="0" class="table table-hover" id="myTable">
												<thead>
													<tr>
														<th>Booking ID</th>
														<th>Room Number</th>
														<th>Customer</th>
														<th>Check In</th>
														<th>Check Out</th>
														<th>Booking Date</th>
														<th>Booking Status</th>
														<th>Payment Status</th>														
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
														<td><?php echo h(date("d/m/Y H:i:s",strtotime($booking->booking_date))); ?></td>
														<td><a style="width: 85px;" class="status_btn status_checks <?=$booking->booking_status=='C' ? "btn-success" : "btn-yellow";?>"><?php echo h($booking_status[$booking->booking_status]); ?></a></td>
														<td><a style="width: 85px;" class="status_btn status_checks <?php echo $payment_status_booking ?>"><?php echo h($payment_status[$booking->payment_status]); ?></a></td>														
														<td class="actions">															
															<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'view',$booking->id]);?>"><?=$this->Html->image('/img/icons/view.png', array('alt' => 'View Booking Details', 'border' => '0', 'title' => 'View Booking Details'))?></a>&nbsp;
															<a href="<?=$this->Url->build(['controller'=>'BookingPayments', 'action'=>'index',$booking->id]);?>"><?=$this->Html->image('/img/icons/payment.png', array('alt' => 'Payment', 'border' => '0', 'title' => 'Payment'))?></a>&nbsp;
															<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'revedit',$booking->id]);?>"><?=$this->Html->image('/img/icons/edit.png', array('alt' => 'Edit Booking', 'border' => '0', 'title' => 'Edit Booking'))?></a>&nbsp;
															<!-- <a onclick="return confirm('Are you sure you want to delete?')" href="<?php //echo $this->Url->build(['controller'=>'Bookings', 'action'=>'delete',$booking->id]);?>"><?php //echo $this->Html->image('/img/icons/delete.png', array('alt' => 'Delete', 'border' => '0',  ))?></a> -->
														</td>
													</tr>
												<?php 
													endforeach;
												}
												?>
												</tbody>
											</table>
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
<script type="text/javascript">
<!--
$(document).ready( function () {
	var table = $('#myTable').DataTable({"order": [[0, 'desc' ]], "lengthMenu": [10, 25, 50, 100],
			"pageLength": 25
	});
});
//-->
</script>