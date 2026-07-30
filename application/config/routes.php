<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'landing';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Public routes
$route['lacak'] = 'landing/lacak';

// Auth routes
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['logout'] = 'auth/logout';

// Dashboard shortcuts
$route['admin'] = 'admin/dashboard';
$route['owner'] = 'owner/dashboard';
$route['pelanggan'] = 'pelanggan/dashboard';
