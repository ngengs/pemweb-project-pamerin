<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="cards-column-full">
	<?php if(!empty($error)){?>
		<div class="cards-column-full">
			<div class="alert alert-danger"><?php echo $error;?></div>
		</div>
	<?php } ?>
	<div class="cards-row">
		<div class="cards-column-full">
			<div class="cards cards-profile">
				<div class="cards-row profile-show">
					<div class="profile-ava">
						<?php 
							$ava_user = base_url('assets/img/profile.png');
							if(!empty($user->USER_PICTURE)) $ava_user=base_url($this->config->item('media_path').'/'.$value->USERNAME.'/'.$this->config->item('media_avatar').'/'.$value->USER_PICTURE);
						?>
						<img src="<?php echo $ava_user;?>" class="img img-responsive img-responsive-center img-ava img-circle">
					</div>
					<div class="profile-box">
						<h2 class="profile-full-name"><?php echo $user->FULL_NAME;?></h2>
						<h4 class="profile-username">@<?php echo $user->USERNAME;?></h4>
						<p class="profile-description">
							<?php if(!empty($user->DESCRIPTION)){
								echo prjct_text_generate_html($user->DESCRIPTION);
							}
							?>
						</p>
						<div class="profile-tools">
							<?php if($user->ID_USER!=$this->session->prjct_user->ID_USER){
									if($is_followed){
								$url = base_url($this->config->item('url_unfollow').'/'.$user->USERNAME.'/'.$user->ID_USER);
							?>
							<button type="button" data-href="<?php echo $url?>" class="link-script btn btn-danger"><span class="fa fa-user-times"></span> Unfollow</button>
							<?php  }else{ 
								$url = base_url($this->config->item('url_follow').'/'.$user->USERNAME.'/'.$user->ID_USER); ?>
							<button type="button"  data-href="<?php echo $url?>" class="link-script btn btn-success"><span class="fa fa-user-plus"></span> Follow</button>	
							<?php }
							}else if($user->ID_USER==$this->session->prjct_user->ID_USER || $this->session->prjct_user->LEVEL==1){
								?>
								<a href="" class="btn btn-default"><span class="fa fa-cog"></span> Edit</a>
							<?php if($user->ID_USER==$this->session->prjct_user->ID_USER){ ?>
								<a href="" class="btn btn-warning"><span class="fa fa-bell"></span> Notifikasi</a>
							<?php } ?>
								<?php
							}?>
						</div>
						<div class="profile-count">
							<ul class="profile-count-list list-unstyled list-inline">
								<li>
									<a href="">
										<span class="number number-change" data-origin="<?php echo $total_post;?>"><?php echo $total_post;?></span><span class="number-text">post</span>
									</a>
								</li>
								<li>
									<a href="<?php echo base_url($this->config->item('url_follower').$user->USERNAME);?>">
										<span class="number number-change" data-origin="<?php echo $total_follower;?>"><?php echo $total_follower;?></span><span class="number-text">followers</span>
									</a>
								</li>
								<li>
									<a href="<?php echo base_url($this->config->item('url_following').$user->USERNAME);?>">
										<span class="number number-change" data-origin="<?php echo $total_following;?>"><?php echo $total_following;?></span><span class="number-text">following</span>
									</a>
								</li>
								
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="cards-row timeline-masonry">
<?php 
if(!empty($post)){
foreach ($post as $key => $value) { 
	$profile_link = base_url($this->config->item('url_profile').$value->USERNAME);
	?>
 <div class="cards-column">
				<article class="cards cards-as-link cards-masonry" data-post="<?php echo $value->ID_POST;?>" data-creator="<?php echo $value->USERNAME;?>" data-type="<?php echo $this->config->item('url_single_post');?>">
					<header class="cards-header">
						<a href="<?php echo $profile_link;?>" class="cards-header-link-profile">
							<?php 
								$ava = base_url('assets/img/profile.png');
								if(!empty($value->USER_PICTURE)) $ava=base_url($this->config->item('media_path').'/'.$value->USERNAME.'/'.$this->config->item('media_avatar').'/'.$value->USER_PICTURE);
							?>
							<img src="<?php echo $ava;?>" class="img img-responsive img-responsive-center img-ava img-circle">
						</a>
						<div class="cards-header-username">
							<a href="<?php echo $profile_link;?>" class="cards-header-link-profile">
								@<?php echo $value->USERNAME;?>
							</a>
						</div>
						<div class="cards-header-tools">
							<a href="<?php echo base_url($this->config->item('url_single_post').'/'.$value->USERNAME.'/'.$value->ID_POST);?>" class="cards-header-tool-time"><time class="formated-time" datetime="<?php echo $value->DATE_POST;?>"><?php echo $value->DATE_POST;?></time></a>
							
						</div>
					</header>
					<div class="cards-body">
						<div class="cards-body-content">
							<?php if(!empty($value->DESCRIPTION)){
								echo prjct_text_generate_html($value->DESCRIPTION);
							} ?>
						</div>
						<div class="cards-body-image text-center">
							<?php if(count($value->PHOTOS)==1){?>
							<img src="<?php echo base_url($this->config->item('media_path').'/'.$value->USERNAME.'/'.$this->config->item('media_upload').'/'.$value->PHOTOS[0]);?>" class="img img-responsive img-responsive-center single-image">
							<?php }else{ ?>
								<div class="grid-image text-center">
								<?php
								foreach($value->PHOTOS as $key_photo => $photo){
								?>
								<!-- <div class="grid-image-photo text-center"> -->
									<img src="<?php echo base_url($this->config->item('media_path').'/'.$value->USERNAME.'/'.$this->config->item('media_upload').'/'.$photo);?>" class="img img-responsive img-responsive-center single-image">
								<!-- </div> -->
								
							<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div>
					<footer class="cards-footer">
						<div class="cards-footer-action">
							<div class="action-left">
								<div class="action-button">
									<?php 
									$url_like = $this->config->item('url_like_post');
									if(!empty($value->MY_LIKE))$url_like = $this->config->item('url_unlike_post');
									$url_like = base_url($url_like.'/'.$value->USERNAME.'/'.$value->ID_POST);
									?>
									<a href="#" data-href="<?php echo $url_like;?>" class="link-script action-button-click action-button-heart <?php if(!empty($value->MY_LIKE))echo 'active';?>">
										<span class="fa-stack fa-lg">
										  <i class="fa fa-circle fa-stack-2x"></i>
										  <i class="fa fa-heart fa-stack-1x fa-inverse"></i>
										</span>
										<span class="action-count count"><?php if(!empty($value->LIKE_COUNT))echo $value->LIKE_COUNT;?></span>
									</a>
								</div>
							</div>
							<div class="action-right">
								<div class="action-button">
									<div class="action-button-click action-button-comment">
										<span class="fa-stack fa-lg">
										  <i class="fa fa-circle fa-stack-2x"></i>
										  <i class="fa fa-commenting fa-stack-1x fa-inverse"></i>
										</span>
										<span class="action-count count"><?php if(!empty($value->COMMENT_COUNT))echo $value->COMMENT_COUNT;?></span>
									</div>
								</div>
							</div>
						</div>
					</footer>
				</article>
			</div>
<?php } 
} ?>
</div>
<?php 
if(!empty($post)){ ?>
	<div class="cards-row">
		<div class="cards-column-half-litle cards-column-center">
			<nav>
			  <ul class="pager pager-material">
			    <li class="previous <?php if($page_now<=1) echo 'disabled';?>"><a href="<?php if($page_now>1){if($page_now-1 >1)echo base_url($this->config->item('url_profile').'/'.$user->USERNAME.'/'.($page_now-1));else echo base_url($this->config->item('url_profile').'/'.$user->USERNAME);}else echo 'javascript::'?>"><span class="fa fa-chevron-left" aria-hidden="true"></span> Newer</a></li>
			    <li class="next <?php if($page_now>=$page_total) echo 'disabled';?>"><a href="<?php if($page_now<$page_total) echo base_url($this->config->item('url_profile').'/'.$user->USERNAME.'/'.($page_now+1));else echo 'javascript::'?>">Older <span class="fa fa-chevron-right"  aria-hidden="true"></span></a></li>
			  </ul>
			</nav>
		</div>
	</div>
<?php } ?>
</div>