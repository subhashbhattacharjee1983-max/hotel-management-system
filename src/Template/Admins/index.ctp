<?php 
	$this->assign('title','Admin User');
	$this->assign('heading','Admin User');
	$this->assign('breadcrumb','Admin User'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'Admins', 'action'=>'index']));
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
				<div class="panel-heading">Admins</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="newsCategorys index">
										<table cellpadding="0" cellspacing="0" class="table table-hover" id="myTable">
										<thead>
										<tr>
											<th>Sl No</th>
											<th>Name</th>
											<th>Email Address</th>
											<th>Account Type</th>
											<th>Status</th>
											<th class="actions"><?php echo __('Actions'); ?></th>
										</tr>
										</thead>
										<tbody>
										<?php 
										if(!empty($admins))
										{
											$i=0;
											foreach ($admins as $block):
											$i++;
										?>
										<tr>
											<td><?php echo $i; ?></td>											
											<td><?php echo h($block->name); ?></td>
											<td><?php echo h($block->email); ?></td>
											<td><?php echo h($account_type[$block->user_type]); ?></td>
											<td><a class="status_btn status_checks <?=$block->status=='Y' ? "btn-success" : "btn-danger";?>" onclick="change_status(<?=$block->id?>, $(this))" style="padding:5px 5px; cursor:pointer;"><?=$block->status=='Y' ? "Active" : "Inactive";?></a></td>
											<td class="actions">												
												<a href="<?=$this->Url->build(['controller'=>'Admins', 'action'=>'edit',$block->id]);?>"><?=$this->Html->image('/img/icons/edit.png', array('alt' => 'Edit', 'border' => '0',  ))?></a>&nbsp;
												<a onclick="return confirm('Are you sure you want to delete?')" href="<?=$this->Url->build(['controller'=>'Admins', 'action'=>'delete',$block->id]);?>"><?=$this->Html->image('/img/icons/delete.png', array('alt' => 'Delete', 'border' => '0',  ))?></a>
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
	var table = $('#myTable').DataTable({"order": [[0, 'asc' ]], "lengthMenu": [10, 25, 50, 100],
			"pageLength": 25
	});
});
function change_status(id, cur)
{
	$.ajax({
		url:"<?=$this->Url->build(['controller'=>'Admins', 'action'=>'statusupdate'])?>/"+id,
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