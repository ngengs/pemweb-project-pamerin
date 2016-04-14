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
					<div class="cards-body">
						<div class="cards-list card-list-default">
					<?php 
					if(!empty($notification)){
						?>
							<ul class="list-unstyled">
								<?php foreach ($notification as $key => $value) {
									?>
									<li>
										<a href="<?php echo base_url($this->config->item('url_notification_read').$value->ID_NOTIFIKASI);?>" class="list-default-link <?php if($value->IS_READ==1) echo 'list-muted';?>">
											<h4 class="list-title margin-top-no margin-bottom-sm"><?php echo $value->JUDUL;?></h4>
											<div class="list-small">Created at <?php echo $value->DATE_NOTIFIKASI;?></div>
										</a>
									</li>
									<?php
								} ?>
							</ul>
							<?php 
							} else {?>
								<h3 class="margin-top-no margin-bottom-no padding-top-sm padding-bottom-sm padding-left-sm padding-right-sm">No Notification</h3>
							<?php }?>
						</div>
					</div>
				</article>
				<?php
				if(!empty($notification) && $page_total > 1){ ?>
					<div class="cards-row">
						<div class="cards-column-half-litle cards-column-center">
							<nav>
							  <ul class="pager pager-material">
							    <li class="previous <?php if($page_now<=1) echo 'disabled';?>"><a href="<?php if($page_now>1){if($page_now-1 >1)echo base_url($url_pagination.($page_now-1));else echo base_url($this->config->item('url_notification_list'));}else echo 'javascript::'?>"><span class="fa fa-chevron-left" aria-hidden="true"></span> Newer</a></li>
							    <li class="next <?php if($page_now>=$page_total) echo 'disabled';?>"><a href="<?php if($page_now<$page_total) echo base_url($url_pagination.($page_now+1));else echo 'javascript::'?>">Older <span class="fa fa-chevron-right"  aria-hidden="true"></span></a></li>
							  </ul>
							</nav>
						</div>
					</div>
				<?php } ?>
			</div>