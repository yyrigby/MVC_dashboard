<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Loading pages
$route['default_controller'] = "main";
$route['404_override'] = '';
$route['signin'] = 'main/signin';
$route['logoff'] = 'users/logoff';
$route['register'] = 'main/register';
$route['dashboard'] = 'main/dashboard';
$route['dashboard/admin'] = 'main/admin_dashboard';
$route['users/new'] = 'main/add_new';
$route['users/signin'] = 'users/login';
$route['admin/edit/(:any)'] = 'main/admin_edit/$1';
$route['users/show/(:any)'] = 'messages/user_info/$1';
$route['users/edit'] = 'main/edit_profile';

//Edit Personal Profile controllers
$route['users/edit_info'] = 'users/edit_info';
$route['users/update_password'] = 'users/update_password';
$route['users/edit_description'] = 'users/update_description';

//Edit Admin User profile
$route['admin/edit_info'] = 'users/admin_edit_info';
$route['admin/update_password'] = 'users/admin_update_password';

$route['admin/remove/(:any)'] = 'users/remove_user/$1';
$route['users/register'] = 'users/register';
$route['users/admin_register'] = 'users/admin_register';

$route['message/leave_message'] = 'messages/post_message';
$route['message/leave_comment'] = 'messages/post_comment';


/* End of file routes.php */
/* Location: ./application/config/routes.php */