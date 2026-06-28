<?php 
	$this->assign('title','Food Item');
	$this->assign('heading','List of Food Items');
	$this->assign('breadcrumb',' Food Item'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'FoodItems', 'action'=>'index'])); 
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
							<div class="col-lg-6">Food Items</div>
							<div class="col-lg-6" style="text-align: right;">
								<a href="<?=$this->Url->build(['controller'=>'FoodItems', 'action'=>'add']);?>" class="btn btn-orange-middle">Add Food Item</a>
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
														<th>Food Category Name</th>
														<th>Food Item Name</th>
														<th><?php echo $this->Paginator->sort('food_item_price'); ?></th>
														<th class="actions"><?php echo $this->Paginator->sort('status'); ?></th>
														<th class="actions"><?php echo __('Actions'); ?></th>
													</tr>
												</thead>
												<tbody>
												<?php 
													$i=0;
												if(!empty($foodItems))
												{
													foreach ($foodItems as $foodItem):
													$i++;
												?>
													<tr>
														<td><?php echo $i; ?></td>
														<td><?php echo h($foodItem->food_category->food_item_name); ?></td>
														<td><?php echo h($foodItem->food_item_name); ?></td>
														<td><?php echo $site_general_settings->currency; ?><?php echo h(number_format($foodItem->food_item_price,2)); ?></td>
														<td><a class="status_btn status_checks <?=$foodItem->status=='Y' ? "btn-success" : "btn-danger";?>" onclick="change_status(<?=$foodItem->id?>, $(this))"><?=$foodItem->status=='Y' ? "Active" : "Inactive";?></a></td>
														<td class="actions">															
															<a href="<?=$this->Url->build(['controller'=>'FoodItems', 'action'=>'edit',$foodItem->id]);?>"><?=$this->Html->image('/img/icons/edit.png', array('alt' => 'Edit', 'border' => '0',  ))?></a>&nbsp;
															<a onclick="return confirm('Are you sure you want to delete?')" href="<?php echo $this->Url->build(['controller'=>'FoodItems', 'action'=>'delete',$foodItem->id]);?>"><?php echo $this->Html->image('/img/icons/delete.png', array('alt' => 'Delete', 'border' => '0',  ))?></a>
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
function change_status(id, cur)
{
	$.ajax({
		url:"<?=$this->Url->build(['controller'=>'FoodItems', 'action'=>'statusupdate'])?>/"+id,
		type:"post",
		beforeSend:function(){
			//cur.removeClass("btn-success").removeClass("btn-danger");
			//cur.text("");
			cur.hide();
		},
		dataType:"json",
		headers : {
			'X-CSRF-Token': "<?php echo $this->request->getParam('_csrfToken');?>"
		},
		success:function(response){
			//console.log(response);
			cur.show();
			if(response.msg=="success")
			{
				//showSuccess(response.success);
				showCustomMessage('<div class="message success">'+response.success+'</div>');
				cur.removeClass("btn-success").removeClass("btn-danger");
				if(response.status=='Y')
				{
					cur.addClass("btn-success");
					cur.text("Active");
				}
				else
				{
					cur.addClass("btn-danger");
					cur.text("Inactive");
				}
			}
			else
			{
				showError(response.msg);
			}
		},
		error:function(){
			cur.show();
			showError("We are having some problem. Please try later.");
		}
	});
}
//-->
</script>