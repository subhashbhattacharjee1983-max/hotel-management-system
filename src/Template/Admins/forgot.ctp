<script type="text/javascript">
<!--
	$(function(){
		$("#login_form").validationEngine();
	});
//-->
</script>
<div class="container">
	<div class="card card-container">
		<div align="center" style="padding:10px;"><?php echo(isset($site_general_settings->website_logo) && trim($site_general_settings->website_logo)!='' && file_exists(WWW_ROOT.$upload_folder. DS.$website_logo_folder.DS.$site_general_settings->website_logo) ? $this->Html->image('/'.$upload_folder.'/'.$website_logo_folder.'/'.$site_general_settings->website_logo, array('alt' => $site_general_settings->website_name, 'border' => '0', 'align'=>'center', 'style'=>"max-width:70%")) : $this->Html->image('logo.png', array('alt' => $site_general_settings->website_name, 'border' => '0', 'align'=>'center', 'style'=>"max-width:70%")))?></div>
		<p id="profile-name" class="profile-name-card">Forgot Password</p>
		<?php echo $this->Form->create($admin, ['div'=>false, 'method'=>'post', 'id'=>'login_form', 'class'=>'form-horizontal']);?>
		<span id="reauth-email" class="reauth-email"></span>
		<div class="form-group">
			<div class="col-md-12">
				<?php echo $this->Form->control('email', ['autocomplete' => 'off', 'class' => 'form-control validate[required,custom[email]]', 'data-errormessage-value-missing'=>'Email Address is required', 'label'=>false, 'required'=>false, 'div'=>false, 'placeholder'=>'E-mail']);?>
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-md-12">
				<?=$this->Form->button('Submit', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'class'=>'btn btn-primary', 'style'=>'width:100% !important; background-color: #4f158c; border: 1px solid #4f158c; height: 45px; border-radius: 7px !important; margin-top: 15px;' ,'value'=>'Login']); ?>
			</div>
		</div>
		<?php echo $this->Form->end();?>
		<div class="form-group">
			<div class="text-right">
				<a href="<?=$this->Url->build(['controller'=>'Admins', 'action'=>'login'])?>" style="color: #FFF !important; font-weight: bold;" class="forgot-password text-primary">
					Back to Login
				</a>
			</div>
		</div>
	</div>
</div>