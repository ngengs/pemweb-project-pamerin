<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('prjct_text_generate_html'))
{
    function prjct_text_generate_html($desc = NULL)
    {
    	$CI =& get_instance();
    	$desc = preg_replace('/(^|\s)#(\w*[a-zA-Z_]+\w*)/', '\1<a href="'.base_url().$CI->config->item('url_hashtags').'\2">#\2</a>', $desc);	
		$desc = preg_replace('/(^|\s)@(\w*[a-zA-Z_]+\w*)/', '\1<a href="'.base_url().$CI->config->item('url_profile').'\2">@\2</a>', $desc);	
		return nl2br($desc);
    }   
}