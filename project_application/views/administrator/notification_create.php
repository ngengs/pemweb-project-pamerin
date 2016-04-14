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
 			<form class="form form-horizontal" method="POST" action="<?php echo base_url($this->config->item('url_admin_notification_submit'));?>">
				<article class="cards">
					<header class="cards-header">
					</header>
					<div class="cards-body cards-body-padding">
						<div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">Title</label>
						    <div class="col-sm-10">
						   		<input type="text" class="form-control" name="title" placeholder="Title" required />
						   	</div>
						</div>
						<div class="form-group">
						    <label for="inputPassword3" class="col-sm-2 control-label">Message</label>
						    <div class="col-sm-10">
						    	<textarea class="form-control" name="message" placeholder="Messagge" required></textarea>
						    	<p class="help-block">You can use html tag in here, line break not require <code>&lt;br&gt;</code>, link not reqire <code>&lt;a&gt;</code>, <code>@</code> and <code>#</code> automatically change to user profile link and hastagh link</code></p>
						    </div>
				  		</div>
				  		<div class="form-group">
				  			<label class="col-sm-2 control-label">To</label>
				  			<div class="col-sm-10">
				  				<div class="input-group">
					  				<select name="user[]" class="form-control select2-user" multiple required>
					  					<?php foreach ($user as $key => $value) {
					  							$ava = base_url('assets/img/profile.png');
												if(!empty($value->USER_PICTURE)) $ava=base_url($this->config->item('media_path').'/'.$value->USERNAME.'/'.$this->config->item('media_avatar').'/'.$value->USER_PICTURE);
											  ?>
											  <option value="<?php echo $value->ID_USER;?>" data-fullname="<?php echo $value->FULL_NAME;?>" data-ava="<?php echo $ava;?>" <?php if(!empty($single) && $value->ID_USER==$single)echo "selected='selected'";?>>@<?php echo $value->USERNAME;?></option>
											  <?php
										  } ?>
					  				</select>
						  			<div class="input-group-btn">
						  				<button type="button" class="btn btn-default btn-select-all">All</button>
						  			</div>
					  			</div>
				  			</div>
				  		</div>
					</div>
					<footer class="cards-footer">
						<div class="cards-footer-action">
							<div class="action-left"></div>
							<div class="action-right">
								<button type="submit" class="btn btn-primary">Create Notification</button>
							</div>
						</div>
					</footer>
				</article>
			</form>
		</div>