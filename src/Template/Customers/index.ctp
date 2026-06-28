<?php 
	$this->assign('title','Customers');
	$this->assign('heading','List of Customers');
	$this->assign('breadcrumb',' Customers'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Customers', 'action'=>'index'])); 
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
							<div class="col-lg-6">Customers</div>							
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
														<th>Name</th>
														<th>Mobile Number</th>
														<th>Email Address</th>
														<th>Guste Category</th>
														<th>Id Type</th>
														<th>Id Number</th>
														<th>Address</th>
														<th class="actions"><?php echo $this->Paginator->sort('status'); ?></th>
														<th class="actions"><?php echo __('Actions'); ?></th>
													</tr>
												</thead>
												<tbody>
												<?php 
													$i=0;
												if(!empty($customers))
												{
													foreach ($customers as $customer):
													$i++;
													$parameter_arr['customer_id'] = $customer->id;
												?>
													<tr>
														<td><?php echo $i; ?>&nbsp;</td>
														<td><?php echo h($customer->full_name); ?></td>
														<td><?php echo h($customer->mobile_number); ?></td>
														<td><?php echo h($customer->email_address); ?></td>
														<td><?php echo h($customer->guest_category); ?></td>
														<td><?php echo h($customer->id_type); ?></td>
														<td><?php echo h($customer->id_number); ?></td>
														<td><?php echo h($customer->address); ?></td>
														<td><a class="status_btn status_checks <?=$customer->status=='Y' ? "btn-success" : "btn-danger";?>" onclick="change_status(<?=$customer->id?>, $(this))"><?=$customer->status=='Y' ? "Active" : "Inactive";?></a></td>
														<td class="actions">															
															<a href="<?=$this->Url->build(['controller'=>'Customers', 'action'=>'edit',$customer->id]);?>"><?=$this->Html->image('/img/icons/edit.png', array('alt' => 'Edit', 'title' => 'Edit', 'border' => '0',  ))?></a>&nbsp;
															<a href="<?=$this->Url->build(['controller'=>'Bookings', 'action'=>'customerreport',"?" => $parameter_arr]);?>"><?=$this->Html->image('/img/icons/report.png', array('alt' => 'Report', 'title' => 'Report', 'border' => '0',  ))?></a>&nbsp;
															<a href="<?=$this->Url->build(['controller'=>'Customers', 'action'=>'view',$customer->id]);?>"><?=$this->Html->image('/img/icons/view.png', array('alt' => 'View', 'title' => 'View', 'border' => '0',  ))?></a>&nbsp;
															<!-- <a onclick="return confirm('Are you sure you want to delete?')" href="<?php //echo $this->Url->build(['controller'=>'Customers', 'action'=>'delete', $customer->id]);?>"><?php //echo $this->Html->image('/img/icons/delete.png', array('alt' => 'Delete', 'border' => '0',  ))?></a> -->
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
