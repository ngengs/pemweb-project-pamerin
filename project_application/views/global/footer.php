<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    	</div>
    </section>
    <!-- End Content -->
    
    <!-- Footer -->
    <footer id="footer">
    	
    </footer>
    <!-- End Footerf -->
    
    <!-- Modal Area -->
    <div class="modal-area">
    	<!-- Modal Search-->
		<div class="modal fade" id="modal-search" tabindex="-1" role="dialog" aria-labelledby="modal-search-label">
		  <form class="form" method="post" action="<?php echo base_url($this->config->item('url_search_submit'));?>">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Search</h4>
		      </div>
		      <div class="modal-body">
	      		<input type="text" class="form-control" name="search_query" id="search-input" placeholder="Search">
		      </div>
		      <div class="modal-footer">
		        <button type="submit" class="btn btn-primary">Search</button>
		      </div>
		    </div>
		   </form>
		  </div>
		</div>
		<!-- Modal Search -->
		
		
    	<!-- Modal Post-->
		<div class="modal fade" id="modal-post" tabindex="-1" role="dialog" aria-labelledby="modal-post-label">
		  <form class="form" method="post"  enctype="multipart/form-data" action="<?php echo base_url($this->config->item('url_post_create'));?>">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Submit Post</h4>
		      </div>
		      <div class="modal-body">
	      		<div class="form-group">
				    <label>Image</label>
					<input name="image_upload[]" accept=".jpg,.png" type="file" multiple class="input-file" required>
				</div>
	      		<div class="form-group">
				    <label>Caption</label>
					<textarea name="caption" class="form-control" maxlength="140"></textarea>
				</div>
		      </div>
		      <div class="modal-footer">
		        <button type="submit" class="btn btn-primary">Submit</button>
		      </div>
		    </div>
		   </form>
		  </div>
		</div>
		<!-- Modal Post -->
    </div>
    <!-- End Modal Area -->
    
    <!-- FAB -->
    <div class="fab">
    	<a href="#" class="fab-btn fab-yellow" data-toggle="modal" data-target="#modal-post"><span class="fa fa-plus fa-fw"></span></a>
   		<?php if($this->session->prjct_user->LEVEL==1){ ?>
   		<a href="#" data-href="<?php echo base_url($this->config->item('url_admin_notification_create'));?>" class="link-script fab-btn fab-red fab-btn-sm"><span class="fa fa-share-alt fa-fw"></span></a>
    	<?php } ?>
    </div>
    <!-- End FAB -->
    
    
    
    <script>
    	var base_url = '<?php echo base_url();?>'
    </script>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
    <script src="<?php echo base_url();?>assets/plugins/jquery/jquery-1.12.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url();?>assets/js/pemweb_project_pamerin.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/fileupload/js/plugins/canvas-to-blob.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/fileupload/js/fileinput.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/moment/moment.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/masonry/masonry.pkgd.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap-dialog/bootstrap-dialog.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/select2/js/select2.full.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/system.min.js"></script>
  </body>
</html>