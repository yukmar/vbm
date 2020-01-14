<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'dashboard/dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
// --------------------------------------------------------
// start dashboard
// dashboard: first time landing
$route['login'] = 'dashboard/dashboard/login';
// dashboard: logout
$route['logout'] = 'dashboard/dashboard/logout';
// end dashboard
$route['testing'] = 'template/Testing';
// --------------------------------------------------------
// start praktikum
// praktikum: user
$route['praktikum/(:num)'] = 'praktikum/user/show/$1';
// praktikum: admin (kelola praktikum)
$route['manage-praktikum'] = 'praktikum/Manage/show';
$route['manage-praktikum/([a-zA-Z]+)'] = function($action)
{
	switch ($action) {
		case 'add':
			return 'praktikum/Manage/create';
			break;

		case 'edit':
			return 'praktikum/Manage/update';
			break;

		case 'delete':
			return 'praktikum/Manage/delete';
			break;

		case 'set':
			return 'praktikum/Manage/praktikum_set';
			break;
		
		default:
			return show_404();
			break;
	}
};
// end praktikum
// --------------------------------------------------------
// start assignment
// assignment: user
$route['ujian/(:num)'] = 'assignment/user/ujian/$1';
$route['ujian/(:num)/(:num)'] = 'assignment/user/ujian/$1/$2';
$route['ujian/submit/(:num)'] = 'assignment/user/submit_ujian/$1';
$route['nilai/(:num)'] = 'assignment/user/nilai/$1';
$route['pretest'] = 'assignment/user/pretest';
$route['pretest/submit'] = 'assignment/user/submit';
// assignment: admin
$route['manage-soal'] = 'assignment/Manage/show';
$route['manage-soal/([a-zA-Z]+)'] = function($action)
{
	switch ($action) {
		case 'list':
			return 'assignment/Manage/list_soal';
			break;
		case 'pilihan':
			return 'assignment/Manage/get_pilihan';
			break;
		case 'add':
			return 'assignment/Manage/create';
			break;
		case 'edit':
			return 'assignment/Manage/update';
			break;
		case 'delete':
			return 'assignment/Manage/delete';
			break;
		case 'pretest':
			return 'assignment/Manage/show_pretest';
			break;
		case 'ujian':
			return 'assignment/Manage/show_ujian';
			break;
		default:
			return show_404();
			break;
	}
};
$route['manage-soal/([a-zA-Z]+)/set-soal'] = function($segment)
{
	switch ($segment) {
		case 'ujian':
			return 'assignment/Manage/set_ujian';
			break;
		case 'pretest':
			return 'assignment/Manage/set_pretest';
			break;
		default:
			return show_404();
			break;
	}
};
$route['manage-soal/([a-zA-Z]+)/list'] = function($segment)
{
	switch ($segment) {
		case 'ujian':
			return 'assignment/Manage/list_ujian';
			break;
		
		default:
			return show_404();
			break;
	}
};
$route['manage-soal/([a-zA-Z]+)/edit'] = function($segment)
{
	switch ($segment) {
		case 'ujian':
			return 'assignment/Manage/edit_ujian';
			break;

		case 'pretest':
			return'assignment/Manage/edit_pretest';
			break;
		
		default:
			return show_404();
			break;
	}
};
// end assignmet
// --------------------------------------------------------
// start user
// user: admin (kelola user)
$route['manage-user'] = 'user/Manage/show';
$route['manage-user/([a-zA-Z]+)'] = function($action)
{
	switch ($action) {
		case 'add':
			return 'user/Manage/create';
			break;
		case 'edit':
			return 'user/Manage/update';
			break;
		case 'delete':
			return 'user/Manage/delete';
			break;
		case 'set':
			return 'user/Manage/user_set';
			break;
		default:
			return show_404();
			break;
	}
};
// end user
// --------------------------------------------------------
// start penilaian
// penilaian: admin
$route['penilaian/(:num)'] = 'penilaian/Manage/show/$1';
$route['penilaian/([a-zA-Z]+)/(:num)'] = function($segment, $val)
{
	switch ($segment) {
		case 'summary':
			return 'penilaian/Manage/summary/'.$val;
			break;
		case 'periksa':
			return 'penilaian/Manage/periksa/'.$val;
			break;
		case 'submit':
			return 'penilaian/Manage/submit_nilai/'.$val;
			break;
		default:
			return show_404();
			break;
	}
};
$route['penilaian/detailoff/(:num)/(:num)/(:num)'] = 'penilaian/Manage/detail_off/$1/$2/$3';