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
if(!empty($post)){
$value=$post;
	$profile_link = base_url($this->config->item('url_profile').$value->USERNAME);
	?>
 		<div class="cards-column-half cards-column-center">
				<article class="cards" data-post="<?php echo $value->ID_POST;?>">
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
								<?php prjct_print_username($value);?>
							</a>
						</div>
						<div class="cards-header-tools">
							<a href="<?php echo base_url($this->config->item('url_single_post').'/'.$value->ID_POST);?>" class="cards-header-tool-time"><time class="formated-time" datetime="<?php echo $value->DATE_POST;?>"><?php echo $value->DATE_POST;?></time></a>
							<div class="dropdown">
							  <button class="btn btn-link" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    <span class="fa fa-ellipsis-v"></span>
							  </button>
							  <ul class="dropdown-menu pull-right">
							  	<?php if(($value->ID_USER == $this->session->prjct_user->ID_USER)||$this->session->prjct_user->LEVEL==1){?>
							    <li><a href="#"  class="edit-post-btn" data-post="<?php echo $value->ID_POST;?>" data-action="show">Edit</a></li>
							    <li><a href="#" class="delete-post-btn" data-post="<?php echo $value->ID_POST;?>" data-type="<?php echo $this->config->item('url_delete_post');?>">Delete</a></li>
							    <?php } ?>
							    <?php if($value->ID_USER !== $this->session->prjct_user->ID_USER && $this->session->prjct_user->LEVEL!=1){ ?>
							    <li><a href="#" data-toggle="modal" data-target="#modal-report">Report</a></li>
							    <?php } ?>
							  </ul>
							</div>
						</div>
					</header>
					<div class="cards-body">
						<div class="cards-body-content">
							<?php if(!empty($value->DESCRIPTION)){
								echo prjct_text_generate_html($value->DESCRIPTION);						
							} ?>
						</div>
						<?php if(($value->ID_USER == $this->session->prjct_user->ID_USER)||$this->session->prjct_user->LEVEL==1){?>
						<div class="cards-body-form">
							<form class="form" method="POST" action="<?php echo base_url('post/submit_edit')?>">
								<div class="form-group">
									<label>Caption</label>
									<textarea class="form-control" name="caption"><?php if(!empty($value->DESCRIPTION))echo $value->DESCRIPTION;?></textarea>
								</div>
								<div class="form-group text-right">
									<input type="hidden" name="id_post" value="<?php echo $value->ID_POST;?>">
									<input type="hidden" name="username" value="<?php echo $value->USERNAME;?>">
									<button class="btn btn-default edit-post-btn" data-post="<?php echo $value->ID_POST;?>" data-action="hide">Cancel</button>
									<button type="submit" class="btn btn-warning">Edit</button>
								</div>
							</form>
						</div>
						<?php } ?>
						<div class="cards-body-image text-center">
							<?php if(count($value->PHOTOS)==1){
								$src = $this->config->item('media_path').'/'.$value->USERNAME.'/'.$this->config->item('media_upload').'/'.$value->PHOTOS[0];
								?>
							<img src="<?php echo base_url($src);?>" class="img img-responsive img-responsive-center single-image img-popup">
							<?php }else{ ?>
								<div class="grid-image text-center">
								<?php
								foreach($value->PHOTOS as $key_photo => $photo){
									$src = $this->config->item('media_path').'/'.$value->USERNAME.'/'.$this->config->item('media_upload').'/'.$photo;
								?>
								<!-- <div class="grid-image-photo text-center"> -->
									<img src="<?php echo base_url($src);?>" class="img img-responsive img-responsive-center single-image img-popup">
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
						<div class="cards-footer-comment">
							<div class="cards-footer-comment-list">
								<?php 
									if(!empty($value->COMMENT_LIST)){
								?>
								<ul class="media-list">
									<?php foreach ($value->COMMENT_LIST as $key_com => $value_com) {
										$comment_profile_link = base_url($this->config->item('url_profile').$value_com->USERNAME);
									?>
								  <li class="media" data-comment="<?php echo $value_com->ID_COMMENT;?>">
								    <div class="media-left">
								      <a href="<?php echo $comment_profile_link;?>">
								      	<?php
								      		$ava_comment = base_url('assets/img/profile.png');
											if(!empty($value_com->USER_PICTURE)){
												$ava_comment = base_url($this->config->item('media_path').'/'.$value_com->USERNAME.'/'.$this->config->item('media_avatar').'/'.$value_com->USER_PICTURE);
											}
								      	?>
								        <img class="img img-circle img-ava" src="<?php echo $ava_comment;?>">
								      </a>
								    </div>
								    <div class="media-body">
								    	<div class="media-heading">
								    		<a href="<?php echo $comment_profile_link;?>"><?php prjct_print_username($value_com);?></a>
								    	</div>
								    	<p class="comment-box">
								    		<?php if(!empty($value_com->COMMENT)){
												echo prjct_text_generate_html($value_com->COMMENT);					
											} ?>
								    	</p>
								    	<?php if($value_com->ID_USER == $this->session->prjct_user->ID_USER){ ?>
								    	<div class="comment-edit-form">
								    		<form class="form" method="post" action="<?php echo base_url($this->config->item('url_edit_comment'));?>">
								    			<div class="form-group">
								    				<label>Edit Comment</label>
								    				<textarea name="comment" class="form-control"><?php echo $value_com->COMMENT;?></textarea>
								    			</div>
								    			<div class="text-right">
								    				<input type="hidden" name="id_comment" value="<?php echo $value_com->ID_COMMENT;?>">
								    				<input type="hidden" name="id_post" value="<?php echo $value->ID_POST;?>">
								    				<input type="hidden" name="username_post" value="<?php echo $value->USERNAME;?>">
								    				<button class="btn btn-default edit-comment-btn" data-comment="<?php echo $value_com->ID_COMMENT;?>" data-action="hide">Cancel</button>
								    				<button type="submit" class="btn btn-warning">Edit</button>
								    			</div>
								    		</form>
								    	</div>
								      	<?php } ?>
								    </div>
								    <div class="comment-tools">
								    	<time class="formated-time comment-time" datetime="<?php echo $value_com->DATE_COMMENT;?>"><?php echo $value_com->DATE_COMMENT;?></time>
								    	<?php if($value_com->ID_USER == $this->session->prjct_user->ID_USER){ ?>
								    	<a href="#" class="comment-tools-btn edit-comment-btn" data-comment="<?php echo $value_com->ID_COMMENT;?>" data-action="show"><span class="fa fa-pencil"></span></a>
								    	<a href="#" class="comment-tools-btn delete-comment-btn text-danger" data-post="<?php echo $value->ID_POST;?>" data-comment="<?php echo $value_com->ID_COMMENT;?>" 
								    		data-userpost="<?php echo $value->USERNAME;?>" data-type="<?php echo $this->config->item('url_delete_comment');?>"><span class="fa fa-trash-o"></span></a>
								    	<?php } ?>
								    </div>
								  </li>
								  <?php } ?>
								</ul>
								<?php } ?>
							</div>
							<form class="form" method="POST" action="<?php echo base_url('post/submit_comment');?>">
								<div class="media">
							      <a class="media-left media-top" href="#">
							        <img class="img img-circle img-ava" src="<?php echo $ava;?>">
							      </a>
							      <div class="media-body">
							      	<textarea name="comment" class="form-control" required></textarea>
							      </div>
							      <div class="media-right media-middle">
							      	<input type="hidden" name="username" value="<?php echo $value->USERNAME;?>">
							      	<input type="hidden" name="id_post" value="<?php echo $value->ID_POST;?>">
							      	<button type="submit" class="btn btn-primary">Submit</button>
							      </div>
							    </div>
							</div>
							</form>
						</div>
					</footer>
				</article>
			</div>
			<?php if($value->ID_USER != $this->session->prjct_user->ID_USER && $this->session->prjct_user->LEVEL != 1){ ?>
				<!-- Modal Report-->
				<div class="modal fade" id="modal-report" tabindex="-1" role="dialog" aria-labelledby="modal-report-label">
				  <form class="form" method="post"  enctype="multipart/form-data" action="<?php echo base_url($this->config->item('url_report_post'));?>">
				  <div class="modal-dialog modal-lg" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" id="myModalLabel">Report Post by @<?php echo $value->USERNAME;?></h4>
				      </div>
				      <div class="modal-body">
			      		<div class="form-group">
						    <label>Report Message</label>
							<textarea name="pesan_report" class="form-control" maxlength="140" required></textarea>
						</div>
				      </div>
				      <div class="modal-footer">
				      	<input type="hidden" name="id_post" value="<?php echo $value->ID_POST;?>">
				      	<input type="hidden" name="username_creator" value="<?php echo $value->USERNAME;?>">
				        <button type="submit" class="btn btn-primary">Report</button>
				      </div>
				    </div>
				   </form>
				  </div>
				</div>
				<!-- Modal Report -->
			<?php } ?>
<?php 
} ?>