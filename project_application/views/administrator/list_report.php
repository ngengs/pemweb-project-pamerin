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
		<div class="cards-column-half-litle cards-column-center">
			<ul class="nav nav-inverted margin-bottom-md nav-pills nav-justified">
			  <li role="presentation"<?php if($type_page=="noread")echo ' class="active"';?>><a href="<?php echo base_url($this->config->item('url_admin_report'));?>">No Read</a></li>
			  <li role="presentation"<?php if($type_page=="read")echo ' class="active"';?>><a href="<?php echo base_url($this->config->item('url_admin_report').'read');?>">Read</a></li>
			  <li role="presentation"<?php if($type_page=="all")echo ' class="active"';?>><a href="<?php echo base_url($this->config->item('url_admin_report').'all');?>">All</a></li>
			</ul>
		</div>
 		<div class="cards-column-half cards-column-center">
				<article class="cards">
					<div class="cards-body">
						<div class="cards-list card-list-default">
					<?php 
					if(!empty($report)){
						?>
							<ul class="list-unstyled">
								<?php foreach ($report as $key => $value) {
									?>
									<li>
										<a href="<?php echo base_url($this->config->item('url_admin_report_view').$value->ID_REPORT);?>" class="list-default-link <?php if($type_page=="all" && $value->IS_READ==1) echo 'list-muted';?>">
											<h4 class="list-title margin-top-no margin-bottom-sm"><?php echo '@'.$value->USERNAME_REPORT.' - '.$value->ID_REPORT;?></h4>
											<div class="list-small">Report at <?php echo $value->DATE_REPORT;?></div>
										</a>
									</li>
									<?php
								} ?>
							</ul>
							<?php 
							} else {?>
								<h3 class="margin-top-no margin-bottom-no padding-top-sm padding-bottom-sm padding-left-sm padding-right-sm">Empty Data</h3>
							<?php }?>
						</div>
					</div>
				</article>
				<?php
				if(!empty($report) && $page_total > 1){ ?>
					<div class="cards-row">
						<div class="cards-column-half-litle cards-column-center">
							<nav>
							  <ul class="pager pager-material">
							    <li class="previous <?php if($page_now<=1) echo 'disabled';?>"><a href="<?php if($page_now>1){if($page_now-1 >1)echo base_url($url_pagination.($page_now-1));else echo base_url($url_pagination);}else echo 'javascript::'?>"><span class="fa fa-chevron-left" aria-hidden="true"></span> Newer</a></li>
							    <li class="next <?php if($page_now>=$page_total) echo 'disabled';?>"><a href="<?php if($page_now<$page_total) echo base_url($url_pagination.($page_now+1));else echo 'javascript::'?>">Older <span class="fa fa-chevron-right"  aria-hidden="true"></span></a></li>
							  </ul>
							</nav>
						</div>
					</div>
				<?php } ?>
			</div>