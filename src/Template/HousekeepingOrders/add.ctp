<?php 
	$this->assign('title','Room Service / House keeping');
	$this->assign('heading','Add Room Service / House keeping');
	$this->assign('breadcrumb','Room Service / House keeping'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'HousekeepingOrders', 'action'=>'index'])); 
?>
<script type="text/javascript">
<!--
	$(function(){
		$("#add-form").validationEngine();
	});
	function tot_bill_amt(id)
	{
		var item_price = 0;
		var sub_total = 0;
		var item_price = $('#service_price'+id).val() || 0;
		var quantity = $('#quantity'+id).val() || 0;
		var sub_total = item_price * quantity;
		$("#sub_total"+id).val(parseFloat(sub_total).toFixed(2));
	}
	function show_service(val, id){
		var service = val.split('@');
		$('#service_price'+id).val(service[1]);
		tot_bill_amt(id);
	}
//-->
</script>
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
						<div class="col-lg-6">Add Room Service / House keeping for Booking Id: <?php echo $booking_id ?></div>
						<div class="col-lg-6" style="text-align: right;">
							<a href="<?=$this->Url->build(['controller'=>'HousekeepingOrders', 'action'=>'index', $booking_id]);?>" class="btn btn-success">Back to House keeping</a>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<?php echo $this->Form->create($housekeepingOrder,["name" => "add-form", "id" => "add-form", "method" => "POST", "type" => "file"]); ?>
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<div class="input-icon right">
													<div class="form-group col-md-12" style="padding-left:0px" id="wrap">
														<table width="100%" border="1">
															<tr style="background: #4f158c;">
																<th style="width:5%;">&nbsp;<!-- <input class='check_all' type='checkbox' onclick="select_all()"/> --></th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Room Number</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Service Name</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Service Price (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Quantity</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Sub Total (<?php echo $site_general_settings->currency; ?>)</th>
															</tr>
															<tr>
																<td><!-- &nbsp;<input type='checkbox' class='case'/>&nbsp; --></td>
																<td>
																	<div class="input-icon right">
																		<select style="width:100%; border:0;" name="room_number[]" id="room_number1" class="form-control validate[required]" required>
																			<?php 
																			  if($rooms){
																				foreach($rooms as $key=>$val){
																			  ?>
																			  <option value="<?php echo $val->room_number ?>"><?php echo $val->room_number; ?></option>
																			  <?php 
																				}
																			  }
																			  ?>
																		</select>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right">
																		<select style="width:100%; border:0;" name="service_name[]" id="service_name1" class="form-control validate[required]" onChange="show_service(this.value, 1)" required>
																			<option value="">Select Service</option>
																			<?php 
																			  if($roomServices){
																				foreach($roomServices as $key=>$val){
																			  ?>
																			  <option value="<?php echo $val->service_name."@".$val->price?>"><?php echo $val->service_name; ?></option>
																			  <?php 
																				}
																			  }
																			  ?>
																		</select>
																	</div>
																</td>
																<td>
																	<div class="input-icon right">
																		<input name="service_price[]" id="service_price1" placeholder="" class="form-control validate[required] ramt" value="" type="text" onKeyUp="tot_bill_amt(1)" style="border:0; background:#FFFFFF;" autocomplete="off" onKeyPress="return is_amount(event, this)" readonly>
																	</div>
																</td>
																<td>
																	<div class="input-icon right">
																		<input name="quantity[]" id="quantity1" placeholder="" class="form-control validate[required] damt" value="1" type="text" onKeyUp="tot_bill_amt(1)" style="border:0; background:#FFFFFF;" autocomplete="off" onKeyPress="return number(event, this)" oninput="checkNumberFieldLength(this)">
																	</div>
																</td>
																<td>
																	<div class="input-icon right">
																		<input name="sub_total[]" id="sub_total1" placeholder="" class="form-control validate[required] bamt" value="" type="text" style="border:0; background:#FFFFFF;" autocomplete="off" onKeyPress="return is_amount(event, this)" readonly>
																	</div>
																</td>
																<input type="hidden" name="slider_count" id="slider_count" value="1">
															</tr>
														</table>
													</div>

													<div class="form-group col-md-12 text-right" style="padding-left:0px">
													   <a href="javascript:void(0)" style="color:#ff0000;" class='addmore'>Add House Keeping </a> |
													   <a href="javascript:void(0)" style="color:#ff0000;" class='delete'>Remove House Keeping</a>
													</div>
													
												</div>
											</div>
										</div>
										
									</div>
									<div class="form-actions text-right pal">
										<?=$this->Form->button('Add House Keeping', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'class'=>'btn btn-orange-middle','value'=>'Login']);?>
									</div>
									<?php echo $this->Form->end(); ?>
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
$(".delete").on('click', function() {
	$('.case:checkbox:checked').parents("tr").remove();
});
var i=2;
$(".addmore").on('click',function(){
	var slider_count = $('#slider_count').val();
	var slider_count_new = eval(slider_count)+1;
    var data="<tr><td>&nbsp;<input type='checkbox' class='case'/></td>";  
	data +="<td><div class='input-icon right'><select style='width:100%;border:0;' name='room_number[]' id='room_number"+i+"' class='form-control validate[required]' required><?php if($rooms){foreach($rooms as $key=>$val){?><option value='<?php echo $val->room_number ?>'><?php echo $val->room_number; ?></option><?php }}?></select></div></td>";
	data +="<td><div class='input-icon right'><select style='width:100%;border:0;' name='service_name[]' id='service_name"+i+"' class='form-control validate[required]' onChange='show_service(this.value, "+i+")' required><option value=''>Select Service</option><?php if($roomServices){foreach($roomServices as $key=>$val){?><option value='<?php echo $val->service_name.'@'.$val->price ?>'><?php echo $val->service_name; ?></option><?php }}?></select></div></td>";
	data +="<td><div class='input-icon right'><input name='service_price[]' id='service_price"+i+"' placeholder='' class='form-control validate[required] ramt' value='' type='text' onKeyUp='tot_bill_amt("+i+")' style='border:0; background:#FFFFFF;' autocomplete='off' onKeyPress='return is_amount(event, this)'></div></td>";
	data +="<td><div class='input-icon right'><input name='quantity[]' id='quantity"+i+"' placeholder='' class='form-control validate[required] damt' value='1' type='text' onKeyUp='tot_bill_amt("+i+")' style='border:0; background:#FFFFFF;' autocomplete='off' onKeyPress='return number(event, this)'></div></td>";
	data +="<td><div class='input-icon right'><input name='sub_total[]' id='sub_total"+i+"' placeholder='' class='form-control validate[required] bamt' value='' type='text' style='border:0; background:#FFFFFF;' autocomplete='off' onKeyPress='return is_amount(event, this)' readonly></div></td>";
	$('#slider_count').val(slider_count_new);
	$('table').append(data);
	i++;
	//$(".chosen").chosen();
});
function select_all() {
	$('input[class=case]:checkbox').each(function(){ 
		if($('input[class=check_all]:checkbox:checked').length == 0){ 
			$(this).prop("checked", false); 
		} else {
			$(this).prop("checked", true); 
		} 
	});
}
//$(".chosen").chosen();
//-->
</script>