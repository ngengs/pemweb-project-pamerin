<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="nav navbar-nav" id="main-menu">
		      	<li class="sidebar-header">
		      		<div class="sidebar-header-box">
		      			<button class="btn btn-link" data-toggle="collapse" data-target="#main-menu" aria-expanded="false">
		      				<span class="fa fa-arrow-left"></span>
		      			</button>
		      			<a href="<?php echo base_url($this->config->item('url_profile').$this->session->prjct_user->USERNAME); ?>" class="sidebar-header-user">
		      				<div class="avatar">
		      					<?php if(!empty($this->session->prjct_user->USER_PICTURE)){
		      								$ava = base_url($this->config->item('media_path').'/'.$this->session->prjct_user->USERNAME.'/'.$this->config->item('media_avatar').'/'.$this->session->prjct_user->USER_PICTURE);
		      						}else{
		      							$ava = base_url('assets/img/profile.png');
		      						}
		      					?>
		      					<img class="img img-profile img-circle" src="<?php echo $ava;?>">
		      				</div>
		      				<div class="detail">
		      					<div class="fullname"><?php echo $this->session->prjct_user->FULL_NAME;?></div>
		      					<div class="username">@<?php echo $this->session->prjct_user->USERNAME;?></div>
		      				</div>
		      			</a>
		      		</div>
		      	</li>
		        <li <?php if(!empty($menu) && $menu==1) echo "class='active'";?>><a href="<?php echo base_url();?>"><span class="fa fa-home fa-fw"></span><span class="menu-text">Home</span></a></li>
		        <li <?php if(!empty($menu) && $menu==2) echo "class='active'";?>><a href="<?php echo base_url($this->config->item('url_profile').$this->session->prjct_user->USERNAME);?>"><span class="fa fa-user fa-fw"></span><span class="menu-text">Profile</span></a></li>
		        
		        
		        <?php if($this->session->prjct_user->LEVEL == 1){ ?>
	        	<!-- Admin Menu -->
		        <li <?php if(!empty($menu) && $menu==98) echo "class='active'";?>><a href="<?php echo base_url($this->config->item('url_admin_user'));?>"><span class="fa fa-users fa-fw"></span><span class="menu-text">List User</span></a></li>
		        <?php } ?>
		        <li <?php if(!empty($menu) && $menu==99) echo "class='active'";?>><a href="<?php echo base_url($this->config->item('url_settings_profile').$this->session->prjct_user->USERNAME);?>"><span class="fa fa-cog fa-fw"></span><span class="menu-text">Setting</span></a></li>
		        
		        <li><a href="<?php echo base_url('auth/signout');?>"><span class="fa fa-power-off fa-fw text-danger"></span><span class="menu-text">Sign Out</span></a></li>
		        
		        
		      </ul>
		      <ul class="nav navbar-nav navbar-right">
		        <li class="link-badge search">
		        	<a href="#" data-toggle="modal" data-target="#modal-search"><span class="fa fa-search icon"></span><span class="text">Search</span></a>
		        </li>
		        <?php if($this->session->prjct_user->LEVEL == 1){ ?>
		        	<!-- Admin Menu -->
		        	
			        <li class="link-badge notification">
			        	<a href="#">
			        		<span class="fa fa-bug icon"></span><span class="badge badge-danger"><?php if(!empty($report_count))echo $report_count;?></span><span class="text">Report</span></a>
			        </li>
		        <?php } ?>
		        <li class="link-badge notification">
		        	<a href="#">
		        		<span class="fa fa-bell icon"></span><span class="badge badge-danger"><?php if(!empty($notif_count))echo $notif_count;?></span><span class="text">Notification</span></a>
		        </li>
		      </ul>