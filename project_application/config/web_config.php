<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['web_name'] = "Pamerin";
$config['web_logo'] = null;


$config['web_image_quality'] = "75%";
$config['web_image_size_minus'] = 10;

$config['media_path'] = "media";
$config['media_upload'] = "uploads";
$config['media_avatar'] = "avatar";

$config['url_search_submit'] = 'search/search_submit/';
$config['url_search_user'] = 'search/users/';
$config['url_search_hashtags'] = 'search/hashtags/';
$config['url_hashtags'] = $config['url_search_hashtags'];
$config['url_profile'] = 'profile/user/';
$config['url_following'] = 'profile/following/';
$config['url_follower'] = 'profile/followers/';

$config['url_post_create'] = 'post/submit_post';
$config['url_single_post'] = 'post/view';
$config['url_like_post'] = 'post/like';
$config['url_unlike_post'] = 'post/unlike';
$config['url_delete_post'] = 'post/delete';
$config['url_edit_comment'] = 'post/submit_comment_edit';
$config['url_delete_comment'] = 'post/comment_delete';
$config['url_report_post'] = 'post/submit_report';

$config['url_follow'] = 'profile/follow_user';
$config['url_unfollow'] = 'profile/unfollow_user';

$config['url_settings_profile'] = 'settings/profile/';
$config['url_settings_profile_submit'] = 'settings/profile_submit/';

$config['timeline_post'] = 12;
$config['user_show'] = 10;
