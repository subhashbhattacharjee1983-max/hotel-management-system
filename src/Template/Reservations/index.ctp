<?php 
	$this->assign('title','Reservations');
	$this->assign('heading','List of Reservations');
	$this->assign('breadcrumb','Reservations'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Reservations', 'action'=>'index'])); 
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
								<a href="<?=$this->Url->build(['controller'=>'Reservations', 'action'=>'add']);?>" class="btn btn-orange-middle">Add Reservation</a>
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
														<th>Reservation ID</th>
														<th>Room Number</th>
														<th>Customer</th>
														<th>Mobile Number</th>
														<th>Check In</th>
														<th>Check Out</th>
														<th>Reservation Date</th>
														<th>Reservation Status</th>
														<th style="width: 227px;"><?php echo __('Actions'); ?></th>
													</tr>
												</thead>
												<tbody>
												<?php 
													$i=0;
												if(!empty($reservations))
												{
													foreach ($reservations as $reservation):
													$i++;
													$show_rooms = $this->Common->show_reservation_rooms($reservation->id);
												?>
													<tr>
														<td><?php echo h($reservation->id); ?></td>
														<td><?php echo $show_rooms; ?></td>
														<td><?php echo h($reservation->customer->full_name); ?></td>
														<td><?php echo h($reservation->customer->mobile_number); ?></td>
														<td><?php echo h($this->Common->entry_date($reservation->check_in_date)); ?></td>
														<td><?php echo h($this->Common->entry_date($reservation->check_out_date)); ?></td>
														<td><?php echo h(date("d/m/Y H:i:s",strtotime($reservation->booking_date))); ?></td>
														<td><a style="width: 85px;" class="status_btn status_checks <?=$reservation->booking_status=='C' ? "btn-success" : "btn-yellow";?>"><?php echo h($booking_status[$reservation->booking_status]); ?></a></td>
														<td class="actions">															
															<?php
															if(date("Y-m-d",strtotime($reservation->check_out_date)) >= date("Y-m-d"))
															{
															?>
															<a onclick="return confirm('Are you sure you want to add to booking this reservation?')" href="<?=$this->Url->build(['controller'=>'Reservations', 'action'=>'addtobooking', $reservation->id]);?>" class="btn btn-orange-middle">Add to Booking</a>&nbsp;
															<?php
															}
															?>
															<a href="<?=$this->Url->build(['controller'=>'Reservations', 'action'=>'view', $reservation->id]);?>"><?=$this->Html->image('/img/icons/view.png', array('alt' => 'View Reservation Details', 'border' => '0', 'title' => 'View reservation Details'))?></a>&nbsp;
															<a href="<?=$this->Url->build(['controller'=>'Reservations', 'action'=>'edit', $reservation->id]);?>"><?=$this->Html->image('/img/icons/edit.png', array('alt' => 'Edit Reservation', 'border' => '0', 'title' => 'Edit Reservation'))?></a>&nbsp;
															<a onclick="return confirm('Are you sure you want to delete?')" href="<?php echo $this->Url->build(['controller'=>'Reservations', 'action'=>'delete', base64_encode($reservation->id)]);?>"><?php echo $this->Html->image('/img/icons/delete.png', array('alt' => 'Delete', 'border' => '0',  ))?></a>
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