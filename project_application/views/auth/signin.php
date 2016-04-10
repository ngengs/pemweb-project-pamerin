<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    		<div class="col-sm-6 col-sm-offset-3">
    			<form class="form" method="POST" action="<?php echo base_url('auth/signin_submit');?>">
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
								<input type="text" name="username" class="form-control" placeholder="Username" required>
							</div>
							<div class="form-group">
								<label>Password</label>
								<input type="password" name="password" class="form-control" placeholder="Password" required>
							</div>
						</div>
						<footer class="cards-footer">
							<div class="cards-footer-action">
								<div class="action-left">
									<a href="<?php echo base_url('auth/signup');?>" class="btn btn-default">Sign Up</a>
								</div>
								<div class="action-right">
									<button type="submit" class="btn btn-primary">Sign In</button>
								</div>
							</div>
						</footer>
					</article>
				</form>
			</div>
    	