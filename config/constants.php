<?php

return [
	'users_roles' => [
		'super_admin' => 'super-admin',
		'customer' => 'customer',
		'caregiver' => 'caregiver'
	],
	'captch_sitekey' => env('GOOGLE_RECAPTCHA_KEY'),
	'captch_secretkey' => env('GOOGLE_RECAPTCHA_SECRET')
];
