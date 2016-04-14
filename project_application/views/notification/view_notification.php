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
					if(!empty($notification)){
						?>
					<header class="cards-header">
					</header>
					<?php } ?>
					<div class="cards-body">
						<div class="cards-list card-list-default">
					<?php 
					if(!empty($notification)){
						?>
							<div class="form form-horizontal">
								<div class="form-group">
								    <label for="inputPassword3" class="col-sm-2 control-label">Date</label>
								    <div class="col-sm-10">
								    	<p class="form-control-static"><?php echo $notification->DATE_NOTIFIKASI;?></p>
								    </div>
						  		</div>
								<div class="form-group">
								    <label for="inputPassword3" class="col-sm-2 control-label">Message</label>
								    <div class="col-sm-10">
								    	<p class="form-control-static"><?php echo prjct_text_generate_html($notification->PESAN);?></p>
								    </div>
						  		</div>
							</div>
							<?php 
							} else {?>
								<h3 class="margin-top-no margin-bottom-no padding-top-sm padding-bottom-sm padding-left-sm padding-right-sm">Empty Data</h3>
							<?php }?>
						</div>
					</div>
					<?php if(!empty($notification)){ ?>
						<footer class="cards-footer">
							<div class="cards-footer-action">
								<div class="action-left">
								</div>
								<div class="action-right">
								</div>
							</div>
						</footer>
					<?php } ?>
				</article>
			</div>