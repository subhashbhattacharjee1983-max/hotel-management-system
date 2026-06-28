<script type="text/javascript">
<!--
	$(function(){
		$("#login_form").validationEngine();
	});
//-->
</script>
<style>
div.input
{
	display: inline;
}
</style>
<div class="container">
	<div class="card card-container">
	   <div align="center" style="padding:10px;"><?php echo(isset($site_general_settings->website_logo) && trim($site_general_settings->website_logo)!='' && file_exists(WWW_ROOT.$upload_folder. DS.$website_logo_folder.DS.$site_general_settings->website_logo) ? $this->Html->image('/'.$upload_folder.'/'.$website_logo_folder.'/'.$site_general_settings->website_logo, array('alt' => $site_general_settings->website_name, 'border' => '0', 'align'=>'center', 'style'=>"max-width:70%")) : $this->Html->image('logo.png', array('alt' => $site_general_settings->website_name, 'border' => '0', 'align'=>'center', 'style'=>"max-width:70%")))?></div>
		<p id="profile-name" class="profile-name-card">Login to <?php echo $site_general_settings->website_name;?> </p>
		<?php echo $this->Form->create($admin, ['div'=>false, 'method'=>'post', 'id'=>'login_form', 'class'=>'form-horizontal']);?>
		<span id="reauth-email" class="reauth-email"></span>
		<div class="form-group">
			<div class="col-md-12">
				<?php echo $this->Form->control('email', ['autocomplete' => 'off', 'class' => 'form-control validate[required,custom[email]]', 'data-errormessage-value-missing'=>'Email Address is required', 'label'=>false, 'required'=>false, 'div'=>false, 'placeholder'=>'E-mail', 'value'=>(isset($this->request->getData()['email'])?$this->request->getData()['email']:(isset($_COOKIE['autopoeliejoe_email'])?$_COOKIE['autopoeliejoe_email']:''))]);?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<?php echo $this->Form->control('password', ['autocomplete' => 'off', 'class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Password is required', 'label'=>false, 'div'=>false, 'required'=>false, 'placeholder'=>'Password', 'value'=>(isset($_COOKIE['autopoeliejoe_administrator_password'])?$_COOKIE['autopoeliejoe_administrator_password']:'')]);?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<?php echo $this->Form->control('type', array('class' => 'form-control validate[required]', 'data-errormessage-value-missing'=>'Account Type is required', 'options' => $account_type, 'label' => false, 'div' => false, 'required'=>false, 'placeholder'=>'Account Type'))?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<div id="remember" class="checkbox">
					<label style="color: #FFF; font-weight: bold;">
						<?=$this->Form->control('remember_me', ['type'=>'checkbox', 'label'=>false, 'div'=>false, 'name'=>'remember_me', 'id'=>'remember_me', 'style'=>'margin: 2px 5px 0 0', 'value'=>1, 'checked'=>(isset($_COOKIE['autopoeliejoe_email'])&&$_COOKIE['autopoeliejoe_email']!=''?true:'')]);?> Remember me
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<div id="remember" class="checkbox">
					<label style="color: #FFF; font-weight: bold;">
						By signing, you agree to our <a href="<?=$this->Url->build(['controller'=>'Admins', 'action'=>'termCondition'])?>" style="color: #f76600;" target="_blank">Terms & Conditions</a> and <a href="<?=$this->Url->build(['controller'=>'Admins', 'action'=>'privacyPolicy'])?>" style="color: #f76600;" target="_blank">Privacy Policy</a>
					</label>
				</div>
				<?=$this->Form->button('Sign In', ['type'=>'submit', 'name'=>'btn_login', 'id'=>'btn_login', 'class'=>'btn btn-primary', 'style'=>'width:100% !important; background-color: #4f158c; border: 1px solid #4f158c; height: 45px; border-radius: 7px !important; margin-top: 15px;' ,'value'=>'Login']); ?>
			</div>
		</div>
		<?php echo $this->Form->end();?>
		<div class="form-group">
			<div class="text-right">
				<a href="<?php echo $this->Url->build(['controller'=>'Admins', 'action'=>'forgot']); ?>" style="color: #FFF !important; font-weight: bold;" class="forgot-password text-primary">
					Forgot the password?
				</a>
			</div>
		</div>
	</div>
</div>