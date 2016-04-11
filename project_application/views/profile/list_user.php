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
						<div class="cards-list card-list-user">
					<?php 
					if(!empty($user)){
						?>
							<ul class="media-list">
								<?php foreach ($user as $key => $value) {
									$user_link = base_url($this->config->item('url_profile').$value->USERNAME);
										?>
								<li class="media">
									<div class="media-left">
								      <a href="<?php echo $user_link;?>">
								      	<?php
								      		$ava_user = base_url('assets/img/profile.png');
											if(!empty($value->USER_PICTURE)){
												$ava_user = base_url($this->config->item('media_path').'/'.$value->USERNAME.'/'.$this->config->item('media_avatar').'/'.$value->USER_PICTURE);
											}
								      	?>
								        <img class="img img-circle img-ava" src="<?php echo $ava_user;?>">
								      </a>
								    </div>
								    <div class="media-body">
								    	<div class="media-heading">
								    		<a href="<?php echo $user_link;?>" class="list-title"><?php prjct_print_username($value);?></a>
								    		<div class="list-title-small"><?php echo $value->FULL_NAME;?></div>
								    	</div>
								    	<p class="list-detail-box">
								    		<?php if(!empty($value->DESCRIPTION)){
												echo prjct_text_generate_html($value->DESCRIPTION);					
											} ?>
								    	</p>
									</div>
									<div class="media-left media-middle">
										<?php if($value->ID_USER!=$this->session->prjct_user->ID_USER){
												$is_followed=FALSE;
												if(!empty($my_following->result())){
													foreach ($my_following->result() as $key_check => $value_check) {
														if($value_check->FOLLOWING_ID == $value->ID_USER){
															$is_followed=TRUE;break;
														}
													}
												}
												if($is_followed){
												$url = base_url($this->config->item('url_unfollow').'/'.$value->USERNAME.'/'.$value->ID_USER);
											?>
											<button type="button" data-href="<?php echo $url?>" class="link-script btn btn-danger"><span class="fa fa-user-times"></span> Unfollow</button>
											<?php  }else{ 
												$url = base_url($this->config->item('url_follow').'/'.$value->USERNAME.'/'.$value->ID_USER); ?>
											<button type="button"  data-href="<?php echo $url?>" class="link-script btn btn-success"><span class="fa fa-user-plus"></span> Follow</button>	
											<?php }
											} ?>
									</div>
								</li>
								<?php } ?>
							</ul>
							<?php 
							} else {?>
								<h3 class="margin-top-no margin-bottom-no padding-top-sm padding-bottom-sm padding-left-sm padding-right-sm">Empty Data</h3>
							<?php }?>
						</div>
					</div>
				</article>
				<?php
				if(!empty($user) && $page_total > 1){ ?>
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