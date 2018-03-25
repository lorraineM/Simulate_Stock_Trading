<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "welcome";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */

/**********************   S1  route  ************************/
$route['test'] = 's1/Test/index';
$route['acco_home'] = 's1/login_controllers/index';
$route['account_cancel'] = 's1/cancel_controllers/index';
$route['register'] = 's1/Hregister/index';
$route['lost'] = 's1/Lhome/index';
$route['select'] = 's1/select/index';



/**********************   S2  route  ************************/
$route['fund'] = 's2/home/index';
$route['fund/fund_pwd'] = 's2/fund_pwd_control/index';
$route['fund/request_open'] = 's2/request_open_control/index';
$route['fund/request_close']='s2/request_close_control/index';
$route['fund/request_loss']='s2/request_loss_control/index';
$route['fund/request_reissue']='s2/request_reissue_control/index';

$route['fund/fund_admin'] = 's2/admin_index/index';
$route['fund/fund_mkey'] = 's2/admin_mkey/index';
$route['fund/fund_mkey_check'] = 's2/admin_mkey_check/index';
$route['fund/fund_logout'] = 's2/admin_logout/index';
$route['fund/fund_reqn'] = 's2/admin_reqn/index';
$route['fund/fund_reqhs'] = 's2/admin_reqhs/index';
$route['fund/fund_log'] = 's2/admin_log/index';
$route['fund/fund_search'] = 's2/admin_search/index';
$route['fund/fund_detailreq'] = 's2/admin_detailreq/index';
$route['fund/fund_checkreq'] = 's2/admin_checkreq/index';
$route['fund/fund_singlereq'] = 's2/admin_singlereq/index';
$route['fund/fund_singlelog'] = 's2/admin_singlelog/index';

$route['fund/status_query']='s2/home/status_query';
$route['fund/deposit_save']='s2/home/deposit_save';
$route['fund/admin_login']='s2/home/admin_login';

/**********************   S3  route  ************************/




/**********************   S4  route  ************************/




/**********************   S5  route  ************************/



/**********************   S6  route  ************************/
