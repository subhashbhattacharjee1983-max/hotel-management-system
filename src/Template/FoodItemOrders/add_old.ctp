<?php 
	$this->assign('title','Create Kitchen Order (KOT)');
	$this->assign('heading','Create Kitchen Order (KOT)');
	$this->assign('breadcrumb','Create Kitchen Order (KOT)'); 
	$this->assign('breadcrumb_url',$this->Url->build(['controller'=>'FoodItemOrders', 'action'=>'index'])); 
?>
<script type="text/javascript">
<!--
	$(function(){
		$("#add-form").validationEngine();
		show_room_table("R");
		function calcSum() {
			var bamt = 0; 
			var ramt = 0;
			var damt = 0;
			$("#wrap .ramt").each(function() {
			   ramt += parseFloat($(this).val()) || 0; 
			});
			$("#food-item-price").val(parseFloat(ramt).toFixed(2));

			$("#wrap .damt").each(function() {
			   damt += parseInt($(this).val()) || 0; 
			});
			$("#total-quantity").val(parseInt(damt));
			
			$("#wrap .bamt").each(function() {
			   bamt += parseFloat($(this).val()) || 0; 
			});
			$("#sub-total").val(parseFloat(bamt).toFixed(2));
		}    
		$("#wrap").keyup(calcSum);
		calcSum();
	});
	function show_room_table(val){
		if(val == "R")
		{
			$("#show_room").show();
			$("#show_table").hide();
		}else if(val == "T")
		{
			$("#show_table").show();
			$("#show_room").hide();
		}
	}
	function number(evt){
	 var charCode = (evt.which) ? evt.which : event.keyCode;
	 if(charCode>31 && (charCode<48 || charCode>57))
	  return false;
	 return true;
	}
    function is_amount(evt, element) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (
			//(charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
			(charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
			(charCode < 48 || charCode > 57))
			return false;
		return true;
	}
	function checkNumberFieldLength(elem){
		if (elem.value.length > 2) {
			elem.value = elem.value.slice(0,2); 
		}
	}
	function tot_bill_amt(id)
	{
		var item_price = 0;
		var sub_total = 0;
		var item_price = $('#item_price'+id).val() || 0;
		var quantity = $('#item_quantity'+id).val() || 0;
		var sub_total = item_price * quantity;
		$("#item_sub_total"+id).val(parseFloat(sub_total).toFixed(2));
	}
	function find_item(cat_val,val)
	{
		var cat_id = cat_val.split('@');
		$.ajax({		
			type:'POST',
			url:"<?=$this->Url->build(['controller'=>'FoodItemOrders', 'action'=>'fetchItem'])?>",
			data:{
				cat_id:cat_id[0]
			},
			dataType:'json',
			headers : {
				'X-CSRF-Token': "<?php echo $this->request->getParam('_csrfToken');?>"
			},			
			beforeSend: function() {
				$("#food_item_name"+val).html('<option value="">Select Item</option>');
			},
			success:function(response){
				//alert(response);
				if(response.item)
				{
					var item_html='<option value="">Select Item</option>';
					$.each(response.item, function(key, val){
						item_html+='<option value="'+key+'@'+val+'">'+val+'</option>';
					});
					$("#food_item_name"+val).html(item_html);
				}				
			},
			error: function(error){
				// Do nothing
			}
		});
	}
	function show_item_amount(item_val,val)
	{
		var item_id = item_val.split('@');
		$.ajax({		
			type:'POST',
			url:"<?=$this->Url->build(['controller'=>'FoodItemOrders', 'action'=>'fetchItemAmount'])?>",
			data:{
				item_id:item_id[0]
			},
			headers : {
				'X-CSRF-Token': "<?php echo $this->request->getParam('_csrfToken');?>"
			},
			success:function(data){
				//alert(data);
				$("#item_price"+val).val(data);
				tot_bill_amt(val);
				function calcSum() {
					var bamt = 0; 
					var ramt = 0;
					var damt = 0;
					$("#wrap .ramt").each(function() {
					   ramt += parseFloat($(this).val()) || 0; 
					});
					$("#food-item-price").val(parseFloat(ramt).toFixed(2));

					$("#wrap .damt").each(function() {
					   damt += parseInt($(this).val()) || 0; 
					});
					$("#total-quantity").val(parseInt(damt));
					
					$("#wrap .bamt").each(function() {
					   bamt += parseFloat($(this).val()) || 0; 
					});
					$("#sub-total").val(parseFloat(bamt).toFixed(2));
				}    
				$("#wrap").keyup(calcSum);
				calcSum();
			},
			error: function(error){
				// Do nothing
			}
		});
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
		<?php echo $this->Form->create($foodItemOrder, ["name" => "add-form", "id" => "add-form",  "method" => "POST", 'enctype'=>'multipart/form-data']); ?>
		<div class="col-lg-4">
			<div class="panel panel-grey">
				<div class="panel-heading">Kitchen Order <?php echo $bookied_id!=0 ? 'for Booking Id: '.$bookied_id : '' ?></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="inputName" class="control-label">
												Order Type <span class="text-danger">*</span>
												</label>
												<div class="input-icon right">
													<?php echo $this->Form->control('order_type', ['type'=>'select', 'options' => $order_type, 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'div'=>false, 'onchange' => 'show_room_table(this.value)']);
													?>
												</div>
											</div>
										</div>
										<div id="show_room">
											<div class="col-md-12">
												<div class="form-group">
													<label for="inputName" class="control-label">
													Select Room Number <span class="text-danger">*</span>
													</label>
													<div class="input-icon right">
														<?php 
														$options_room = array();
														if(!empty($rooms))
														{
															foreach($rooms as $key => $val)
															{
																array_push($options_room, array('text' => $val->room_number.' - '.$val->room_category->room_category_name, 'value' => $val->room_number));
															}
														}
														echo $this->Form->control('room_number', ['type'=>'select', 'options' => $options_room, 'class' => 'form-control validate[required]', 'label'=>false, 'required'=>false, 'data-errormessage-value-missing'=>'Room Number is required', 'div'=>false]);
														?>
													</div>
												</div>
											</div>
										</div>
										<div id="show_table">
											<div class="col-md-6">
												<div class="form-group">
													<label for="inputName" class="control-label">
													Table Number <span class="text-danger">*</span>
													</label>
													<div class="input-icon right">
														<?php echo $this->Form->control('table_number', ['autocomplete' => 'off', 'placeholder' => 'Table Number', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Table Number is required', 'value' => '001', 'label'=>false, 'required'=>false, 'div'=>false]);?>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="inputName" class="control-label">
													Guest Name
													</label>
													<div class="input-icon right">
														<?php echo $this->Form->control('guest_name', ['autocomplete' => 'off', 'placeholder' => 'Guest Name', 'class' => 'form-control', 'data-errormessage-value-missing'=>'Guest Name is required', 'value' => 'Walk in Guest', 'label'=>false, 'required'=>false, 'div'=>false]);?>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="inputName" class="control-label">
													Phone Number
													</label>
													<div class="input-icon right">
														<?php echo $this->Form->control('mobile_number', ['autocomplete' => 'off', 'placeholder' => 'Phone Number', 'class' => 'form-control', 'data-errormessage-value-missing'=>'Phone Number is required', 'label'=>false, 'required'=>false, 'div'=>false]);?>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="inputName" class="control-label">
													Number of Persons
													</label>
													<div class="input-icon right">
														<?php echo $this->Form->control('number_of_persion', ['autocomplete' => 'off', 'placeholder' => 'Number of Persons', 'class' => 'form-control', 'data-errormessage-value-missing'=>'Number of Persons is required', 'type' => 'text', 'value' => '1', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'oninput' => "checkNumberFieldLength(this);"]);?>
													</div>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label for="inputName" class="control-label">
													Special Notes
													</label>
													<div class="input-icon right">
														<?php echo $this->Form->control('special_note', ['autocomplete' => 'off', 'type' => 'textarea', 'placeholder' => 'Special Notes', 'class' => 'form-control', 'data-errormessage-value-missing'=>'Special Notes is required', 'value' => 'Thank you for your order', 'label'=>false, 'required'=>false, 'div'=>false]);?>
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
		</div>
		<div class="col-lg-8">
			<div class="panel panel-grey">
				<div class="panel-heading">Item Details</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel-body pan">
								<div class="form-body pal">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group attr_field">
												<div class="input-icon right">
													<div class="form-group col-md-12" style="padding-left:0px" id="wrap">
														<table width="100%" border="1">
															<tr style="background:gray;">
																<th style="width:5%;">&nbsp;<!-- <input class='check_all' type='checkbox' onclick="select_all()"/> --></th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Item Category</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Item</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Item Price (<?php echo $site_general_settings->currency; ?>)</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:15%;">Quantity</th>
																<th style="text-align:center; padding:8px; color:#FFF; width:20%;">Subtotal (<?php echo $site_general_settings->currency; ?>)</th>
															</tr>
															<tr>
																<td><!-- &nbsp;<input type='checkbox' class='case'/>&nbsp; --></td>
																<td>
																	<div class="input-icon right">
																		<select style="width:100%; border:0;" name="food_category_id[]" id="food_category_id1" class="form-control validate[required]" onChange="find_item(this.value, 1)" required>
																			<option value="">Select Item Category</option>
																			<?php 
																			  if($foodcategories){
																				foreach($foodcategories as $key=>$val){
																			  ?>
																			  <option value="<?php echo $val->id."@".$val->food_item_name ?>"><?php echo $val->food_item_name; ?></option>
																			  <?php 
																				}
																			  }
																			  ?>
																		</select>
																	</div>
																</td>																
																<td>
																	<div class="input-icon right">
																		<select style="width:100%; border:0;" name="food_item_name[]" id="food_item_name1" class="form-control validate[required]" onChange="show_item_amount(this.value, 1)" required>
																			<option value="">Select Item</option>
																		</select>
																	</div>
																</td>
																<td>
																	<div class="input-icon right">
																		<input name="item_price[]" id="item_price1" placeholder="" class="form-control validate[required] ramt" value="" type="text" onKeyUp="tot_bill_amt(1)" style="border:0; background:#FFFFFF;" autocomplete="off" onKeyPress="return is_amount(event, this)">
																	</div>
																</td>
																<td>
																	<div class="input-icon right">
																		<input name="item_quantity[]" id="item_quantity1" placeholder="" class="form-control validate[required] damt" value="1" type="text" onKeyUp="tot_bill_amt(1)" style="border:0; background:#FFFFFF;" autocomplete="off" onKeyPress="return number(event, this)" oninput="checkNumberFieldLength(this)">
																	</div>
																</td>
																<td>
																	<div class="input-icon right">
																		<input name="item_sub_total[]" id="item_sub_total1" placeholder="" class="form-control validate[required] bamt" value="" type="text" style="border:0; background:#FFFFFF;" autocomplete="off" onKeyPress="return is_amount(event, this)" readonly>
																	</div>
																</td>
																<input type="hidden" name="slider_count" id="slider_count" value="1">
															</tr>
														</table>
													</div>

													
													<div class="form-group col-md-12 text-right" style="padding-left:0px">
													   <a href="javascript:void(0)" style="color:#ff0000;" class='addmore'>Add Item </a> |
													   <a href="javascript:void(0)" style="color:#ff0000;" class='delete'>Remove Item</a>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="inputName" class="control-label">
															Item Price (<?php echo $site_general_settings->currency; ?>)
															</label>
															<div class="input-icon right">
																<?php echo $this->Form->control('food_item_price', ['autocomplete' => 'off', 'placeholder' => 'Item Price', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Item Price is required', 'type' => 'text', 'style' => 'background: #FFFFFF;', 'label'=>false, 'required'=>false, 'div'=>false, 'readonly' => true]);?>
															</div>
														</div>
													</div>													
													<div class="col-md-4">
														<div class="form-group">
															<label for="inputName" class="control-label">
															Quantity
															</label>
															<div class="input-icon right">
																<?php echo $this->Form->control('total_quantity', ['autocomplete' => 'off', 'placeholder' => 'Quantity', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Quantity is required', 'type' => 'text', 'style' => 'background: #FFFFFF;', 'label'=>false, 'required'=>false, 'div'=>false, 'onKeyPress' => 'return number(event, this)', 'oninput' => "checkNumberFieldLength(this);", 'readonly' => true]);?>
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="inputName" class="control-label">
															Sub Total (<?php echo $site_general_settings->currency; ?>)
															</label>
															<div class="input-icon right">
																<?php echo $this->Form->control('sub_total', ['autocomplete' => 'off', 'placeholder' => 'Sub Total', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Sub Total is required', 'type' => 'text', 'style' => 'background: #FFFFFF;', 'label'=>false, 'required'=>false, 'div'=>false, 'readonly' => true]);?>
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
				</div>
			</div>
		</div>
		<div class="col-lg-4"></div>
		<div class="col-lg-8">
			<div class="form-body">
				<div class="row">
					<div class="col-md-12">
						<div class="text-right" style="padding-top: 7%;">
							<?=$this->Form->button('Create Order', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'style' => 'width: 100%; padding: 9px;', 'class'=>'btn btn-primary','value'=>'Login']);?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<script type="text/javascript">
<!--
$(".delete").on('click', function() {
	$('.case:checkbox:checked').parents("tr").remove();
	function calcSum() {
		var bamt = 0; 
		var ramt = 0;
		var damt = 0;
		$("#wrap .ramt").each(function() {
		   ramt += parseFloat($(this).val()) || 0; 
		});
		$("#food-item-price").val(parseFloat(ramt).toFixed(2));

		$("#wrap .damt").each(function() {
		   damt += parseInt($(this).val()) || 0; 
		});
		$("#total-quantity").val(parseInt(damt));
		
		$("#wrap .bamt").each(function() {
		   bamt += parseFloat($(this).val()) || 0; 
		});
		$("#sub-total").val(parseFloat(bamt).toFixed(2));
	}    
	$("#wrap").keyup(calcSum);
	calcSum();
});
var i=2;
$(".addmore").on('click',function(){
	var slider_count = $('#slider_count').val();
	var slider_count_new = eval(slider_count)+1;
    var data="<tr><td>&nbsp;<input type='checkbox' class='case'/></td>";  
	data +="<td><div class='input-icon right'><select style='width:100%;border:0;' name='food_category_id[]' id='food_category_id"+i+"' class='form-control validate[required]' onChange='find_item(this.value, "+i+")' required><option value=''>Select Item Category</option><?php if($foodcategories){foreach($foodcategories as $key=>$val){?><option value='<?php echo $val->id.'@'.$val->food_item_name ?>'><?php echo $val->food_item_name; ?></option><?php }}?></select></div></td>";
	data +="<td><div class='input-icon right'><select style='width:100%;border:0;' name='food_item_name[]' id='food_item_name"+i+"' class='form-control validate[required]' onChange='show_item_amount(this.value, "+i+")' required><option value=''>Select Item</option></select></div></td>";
	data +="<td><div class='input-icon right'><input name='item_price[]' id='item_price"+i+"' placeholder='' class='form-control validate[required] ramt' value='' type='text' onKeyUp='tot_bill_amt("+i+")' style='border:0; background:#FFFFFF;' autocomplete='off' onKeyPress='return is_amount(event, this)'></div></td>";
	data +="<td><div class='input-icon right'><input name='item_quantity[]' id='item_quantity"+i+"' placeholder='' class='form-control validate[required] damt' value='1' type='text' onKeyUp='tot_bill_amt("+i+")' style='border:0; background:#FFFFFF;' autocomplete='off' onKeyPress='return number(event, this)' oninput='checkNumberFieldLength(this)'></div></td>";
	data +="<td><div class='input-icon right'><input name='item_sub_total[]' id='item_sub_total"+i+"' placeholder='' class='form-control validate[required] bamt' value='' type='text' style='border:0; background:#FFFFFF;' autocomplete='off' onKeyPress='return is_amount(event, this)' readonly></div></td>";
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