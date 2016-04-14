<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('prjct_text_generate_html'))
{
    function prjct_text_generate_html($desc = NULL)
    {
    	$CI =& get_instance();
		$desc = auto_link($desc, 'url');
    	$desc = preg_replace('/(^|\s)#(\w*[a-zA-Z_]+\w*)/', '\1<a href="'.base_url().$CI->config->item('url_hashtags').'\2">#\2</a>', $desc);	
		$desc = preg_replace('/(^|\s)@(\w*[a-zA-Z_]+\w*)/', '\1<a href="'.base_url().$CI->config->item('url_profile').'\2">@\2</a>', $desc);	
		return nl2br($desc);
    }   
}

if ( ! function_exists('prjct_print_username')) {
	function prjct_print_username($user = NULL, $inverse = TRUE)
	{
		$string = '';
		if (!empty($user)) {
			$string = "@".$user->USERNAME;
			if(!empty($user->LEVEL) && $user->LEVEL==1){
				if($inverse)
					$string .= ' <span class="admin-icon fa-stack fa-sm"><i class="fa fa-certificate fa-stack-2x"></i><i class="fa fa-check fa-stack-1x fa-inverse"></i></span>';
				else
					$string .= ' <span class="admin-icon fa-stack fa-sm"><i class="fa fa-certificate fa-stack-2x"></i><i class="fa fa-check fa-stack-1x fa-inverse fa-inverse-other"></i></span>';
			}
		}
		echo $string;
	}
}
