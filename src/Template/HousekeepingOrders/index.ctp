<?php 
	$this->assign('title','Room Service / House keeping');
	$this->assign('heading','List of Room Service / House keeping');
	$this->assign('breadcrumb',' Room Service / House keeping'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'HousekeepingOrders', 'action'=>'index'])); 
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
							<div class="col-lg-6">Room Service / House keeping for Booking Id: <?php echo $booking_id ?></div>
							<div class="col-lg-6" style="text-align: right;">
								<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'index', $booking_id]);?>" class="btn btn-success">Back to Bookings</a>
								<a href="<?=$this->Url->build(['controller'=>'HousekeepingOrders', 'action'=>'add', $booking_id]);?>" class="btn btn-orange-middle">Add Room Service / House keeping</a>
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
														<th>#</th>
														<th>Room Number</th>
														<th>Service Name</th>
														<th>Service Price</th>
														<th>Quantity</th>
														<th>Sub Total</th>
														<th class="actions"><?php echo __('Actions'); ?></th>
													</tr>
												</thead>
												<tbody>
												<?php 
													$i=0;
												if(!empty($housekeepingOrders))
												{
													foreach ($housekeepingOrders as $housekeepingOrder):
													$i++;
												?>
													<tr>
														<td><?php echo $i; ?>&nbsp;</td>
														<td><?php echo h($housekeepingOrder->room_number); ?></td>
														<td><?php echo h($housekeepingOrder->service_name); ?></td>
														<td><?php echo $site_general_settings->currency; ?><?php echo h(round($housekeepingOrder->service_price)); ?>&nbsp;</td>
														<td><?php echo h($housekeepingOrder->quantity); ?></td>
														<td><?php echo $site_general_settings->currency; ?><?php echo h(round($housekeepingOrder->sub_total)); ?>&nbsp;</td>
														<td class="actions">															
															<a onclick="return confirm('Are you sure you want to delete this house keeping service?')" href="<?php echo $this->Url->build(['controller'=>'HousekeepingOrders', 'action'=>'delete', base64_encode($housekeepingOrder->id), $housekeepingOrder->booking_id]);?>"><?php echo $this->Html->image('/img/icons/delete.png', array('alt' => 'Delete', 'border' => '0',  ))?></a>
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
	var table = $('#myTable').DataTable();
});
//-->
</script>
