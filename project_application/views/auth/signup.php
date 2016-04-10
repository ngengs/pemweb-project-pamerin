<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    		<div class="col-sm-6 col-sm-offset-3">
    			<form class="form" method="POST" action="<?php echo base_url('auth/signup_submit');?>">
					<article class="cards " data-id="132314" data-link="media/single">
						<header class="cards-header">
							<h2 class="text-primary" style="margin:0"><?php echo $title;?></h2>
						</header>
						<div class="cards-body cards-body-padding">
							<?php if(!empty($error)){ ?>
								<div class="alert alert-danger" role="alert"><?php echo $error;?></div>
							<?php } ?>
							<div class="form-group">
								<label>Username</label>
								<input type="text" name="username" class="form-control" placeholder="Username" maxlength="25" required>
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="email" name="email" class="form-control" placeholder="Email" required>
							</div>
							<div class="form-group">
								<label>Full Name</label>
								<input type="text" name="full_name" class="form-control" placeholder="Full Name" required>
							</div>
							<div class="form-group">
								<label>Password</label>
								<input type="password" name="password" class="form-control" placeholder="Password" required>
							</div>
							<div class="form-group">
								<label>Password Retype</label>
								<input type="password" name="password_retype" class="form-control" placeholder="Password Retype" required>
							</div>
						</div>
						<footer class="cards-footer">
							<div class="cards-footer-action">
								<div class="action-left">
									<a href="<?php echo base_url('auth/signin');?>" class="btn btn-default">Sign In</a>
								</div>
								<div class="action-right">
									<button type="submit" class="btn btn-primary">Sign Up</button>
								</div>
							</div>
						</footer>
					</article>
				</form>
			</div>
    	