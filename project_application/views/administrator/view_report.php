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
 		<div class="cards-column-half cards-column-center">
				<article class="cards">
					<?php 
					if(!empty($report)){
						$profile_link = base_url($this->config->item('url_profile').$report->USERNAME_REPORT);
						?>
					<header class="cards-header">
						<a href="<?php echo $profile_link;?>" class="cards-header-link-profile">
							<?php 
								$ava = base_url('assets/img/profile.png');
								if(!empty($report->USER_PICTURE_REPORT)) $ava=base_url($this->config->item('media_path').'/'.$report->USERNAME_REPORT.'/'.$this->config->item('media_avatar').'/'.$report->USER_PICTURE_REPORT);
							?>
							<img src="<?php echo $ava;?>" class="img img-responsive img-responsive-center img-ava img-circle">
						</a>
						<div class="cards-header-username">
							<a href="<?php echo $profile_link;?>" class="cards-header-link-profile">
								<?php 
								$user_report = new stdClass;
								$user_report->USERNAME = $report->USERNAME_REPORT;
								$user_report->LEVEL = $report->LEVEL_REPORT;
								prjct_print_username($user_report);?>
							</a>
						</div>
					</header>
					<?php } ?>
					<div class="cards-body">
						<div class="cards-list card-list-default">
					<?php 
					if(!empty($report)){
						?>
							<div class="form form-horizontal">
								<div class="form-group">
								    <label for="inputPassword3" class="col-sm-2 control-label">Report Date</label>
								    <div class="col-sm-10">
								    	<p class="form-control-static"><?php echo $report->DATE_REPORT;?></p>
								    </div>
						  		</div>
								<div class="form-group">
								    <label for="inputPassword3" class="col-sm-2 control-label">Message</label>
								    <div class="col-sm-10">
								    	<p class="form-control-static"><?php echo prjct_text_generate_html($report->PESAN_REPORT);?></p>
								    </div>
						  		</div>
								<div class="form-group">
								    <label for="inputPassword3" class="col-sm-2 control-label">Creator Post</label>
								    <div class="col-sm-10">
								    	<p class="form-control-static"><a href="<?php echo base_url($this->config->item('url_profile').$report->USERNAME);?>">
								    		<?php echo prjct_print_username($report);?>
								    		</a></p>
								    </div>
						  		</div>
							</div>
							<?php 
							} else {?>
								<h3 class="margin-top-no margin-bottom-no padding-top-sm padding-bottom-sm padding-left-sm padding-right-sm">Empty Data</h3>
							<?php }?>
						</div>
					</div>
					<?php if(!empty($report)){ ?>
						<footer class="cards-footer">
							<div class="cards-footer-action">
								<div class="action-left">
									<a href="<?php echo base_url($this->config->item('url_single_post').'/'.$report->USERNAME.'/'.$report->ID_POST);?>" class="btn btn-default"><span class="fa fa-eye"></span> View Post</a>
								</div>
								<div class="action-right">
									<button data-href="<?php echo base_url($this->config->item('url_admin_notification_create').$report->ID_USER);?>" type="submit" class="btn btn-primary link-script">Message Creator Post</button>
								</div>
							</div>
						</footer>
					<?php } ?>
				</article>
			</div>