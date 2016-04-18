<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    	</div>
    </section>
    <!-- End Content -->
    
    <!-- Footer -->
    <footer id="footer">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-6 text-center text-left-md">
    				<h4 div class="title-footer margin-bottom-sm"><?php echo $this->config->item('web_name');?></h4>
    				<div class="copyright small">
    					Copyright &copy; <?php echo $this->config->item('copyright_year');?> <?php echo $this->config->item('copyright_holder');?>
    				</div>
    			</div>
    			<div class="col-md-6 text-center text-right-md">
    				<ul class="list-unstyled list-inline margin-top-sm margin-bottom-sm">
    					<?php foreach ($this->config->item('footer_menu') as $key => $value) { ?>
							<li><a href="<?php if(!empty($value)||$value!="#")echo base_url($value);else echo $value;?>"><?php echo $key;?></a></li>
						<?php } ?>
    				</ul>
    			</div>
    		</div>
    	</div>
    </footer>
    <!-- End Footerf -->
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
    <script src="<?php echo base_url();?>assets/plugins/jquery/jquery-1.12.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url();?>assets/js/pemweb_project_pamerin.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/fileupload/js/plugins/canvas-to-blob.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/fileupload/js/fileinput.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/system.min.js"></script>
  </body>
</html>