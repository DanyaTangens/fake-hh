<?php

return [
	// MainController
	'' => [
		'controller' => 'main',
		'action' => 'index',
	],
	'main/index/{page:\d+}' => [
		'controller' => 'main',
		'action' => 'index',
	],
	'about' => [
		'controller' => 'main',
		'action' => 'about',
	],
	'contact' => [
		'controller' => 'main',
		'action' => 'contact',
	],
	'login' => [
		'controller' => 'main',
		'action' => 'login',
	],
	'signup' => [
		'controller' => 'main',
		'action' => 'signup',
	],
	'post/{id:\d+}' => [
		'controller' => 'main',
		'action' => 'post',
	],
	// AccountController
	'account/login' => [
		'controller' => 'account',
		'action' => 'login',
	],
	'account/register' => [
		'controller' => 'account',
		'action' => 'register',
	],
	'account/profile' => [
		'controller' => 'account',
		'action' => 'profile',
	],
	'account/add' => [
		'controller' => 'account',
		'action' => 'add',
	],
	'account/edit/{id:\d+}' => [
		'controller' => 'account',
		'action' => 'edit',
	],
	'account/delete/{id:\d+}' => [
		'controller' => 'account',
		'action' => 'delete',
	],
	'account/posts/{page:\d+}' => [
		'controller' => 'account',
		'action' => 'posts',
	],
	'account/posts' => [
		'controller' => 'account',
		'action' => 'posts',
	],
	'account/logout' => [
		'controller' => 'account',
		'action' => 'logout',
	],
	// AdminController
	'admin/login' => [
		'controller' => 'admin',
		'action' => 'login',
	],
	'admin/logout' => [
		'controller' => 'admin',
		'action' => 'logout',
	],
	'admin/add' => [
		'controller' => 'admin',
		'action' => 'add',
	],
	'admin/edit/{id:\d+}' => [
		'controller' => 'admin',
		'action' => 'edit',
	],
	'admin/delete/{id:\d+}' => [
		'controller' => 'admin',
		'action' => 'delete',
	],
	'admin/posts/{page:\d+}' => [
		'controller' => 'admin',
		'action' => 'posts',
	],
	'admin/posts' => [
		'controller' => 'admin',
		'action' => 'posts',
	],
];