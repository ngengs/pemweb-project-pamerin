<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

	<?php if(!empty($error)){?>
		<div class="cards-column-full">
			<div class="cards-row"></div>
				<div class="cards-column-half cards-column-center">
					<div class="alert alert-danger"><?php echo $error;?></div
				</div>
			</div>
		</div>
	<?php } ?>
<?php 
if(!empty($user)){
	$value=$user;
	$profile_link = base_url($this->config->item('url_profile').$value->USERNAME);
	?>
	
	<?php 
		$ava_user = base_url('assets/img/profile.png');
		if(!empty($user->USER_PICTURE)) $ava_user=base_url($this->config->item('media_path').'/'.$value->USERNAME.'/'.$this->config->item('media_avatar').'/'.$value->USER_PICTURE);
	?>
 		<div class="cards-column-half cards-column-center">
 			<form class="form form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url($this->config->item('url_settings_profile_submit'));?>">
				<article class="cards cards-padding">
					<header class="cards-header">
						<h2 class="text-primary margin-top-no margin-bottom-no"><?php echo $title;?></h2>
					</header>
					<div class="cards-body cards-body-padding">
						<div class="text-center row">
							<div class="col-sm-12">
							<div id="upload-avatar-errors" class="center-block" style="display:none"></div>
							<div class="row">
							<div class="upload-avatar col-sm-6 col-sm-offset-3 col-xs-8 col-xs-offset-2">
						        <input id="avatar-upload" name="image_upload" type="file" class="file-loading" data-avatar-before="<?php echo $ava_user;?>">
						    </div>
						    </div>
						    </div>
						</div>
						<div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">Full Name</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" id="inputEmail3" name="full_name" placeholder="Full Name" value="<?php echo $value->FULL_NAME;?>" required>
							</div>
						</div>
						<div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
						    <div class="col-sm-10">
						      <input type="email" class="form-control" id="inputEmail3" name="email" placeholder="Email" value="<?php echo $value->EMAIL;?>" required>
							</div>
						</div>
						<div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">Description</label>
						    <div class="col-sm-10">
						      <textarea class="form-control" id="inputEmail3" name="description" placeholder="Description"><?php echo $value->DESCRIPTION;?></textarea>
							</div>
						</div>
						<div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">Password</label>
						    <div class="col-sm-10">
						      <input type="password" class="form-control" id="inputEmail3" name="password" placeholder="Password">
						      <p class="help-block">Leave empty if not changed</p>
							</div>
						</div>
						<div class="form-group">
						    <label for="inputEmail3" class="col-sm-2 control-label">Password Retype</label>
						    <div class="col-sm-10">
						      <input type="password" class="form-control" id="inputEmail3" name="password_retype" placeholder="Password Retype">
						      <p class="help-block">Leave empty if not changed</p>
							</div>
						</div>
						<?php if($this->session->prjct_user->LEVEL==1){ ?>
						 <div class="form-group">
						    <div class="col-sm-offset-2 col-sm-10">
						      <div class="checkbox">
						        <label>
						          <input name="is_admin" type="checkbox" <?php if($value->LEVEL==1)echo 'checked';?>> Administrator
						        </label>
						      </div>
						    </div>
						  </div>
						<?php } ?>
					</div>
					<footer class="cards-footer">
						<div class="cards-footer-action">
							<div class="action-left">
								<?php if($value->IS_AKTIF==1) { ?>
									<button data-href="<?php echo base_url($this->config->item('url_settings_delete_user').$value->ID_USER.'/'.$value->USERNAME);?>" data-username="<?php echo $value->USERNAME;?>" class="btn btn-danger delete-user"><span class="fa fa-ban"></span> Delete User</button>
								<?php } elseif ($value->IS_AKTIF==0 && $this->session->prjct_user->LEVEL==1) { ?>
									<button data-href="<?php echo base_url($this->config->item('url_settings_activate_user').$value->ID_USER.'/'.$value->USERNAME);?>" data-username="<?php echo $value->USERNAME;?>" class="btn btn-success activate-user"><span class="fa fa-check"></span> Activate User</button>
								<?php } ?>
							</div>
							<div class="action-right">
								<input type="hidden" name="id" value="<?php echo $value->ID_USER;?>">
								<input type="hidden" name="username" value="<?php echo $value->USERNAME;?>">
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
					</footer>
				</article>
			</form>
		</div>
<?php 
} ?>