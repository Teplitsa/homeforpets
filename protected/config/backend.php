<?php
return array(
	'components' => array(
		'user' => array(
			'loginUrl' => array('main/login'),
			'returnUrl' => "/manage",
		),
		'urlManager' => array(
			'rules' => array(
				'manage' => 'main/index',
				'manage/<_c>' => '<_c>',
				'manage/<_c>/<_a>' => '<_c>/<_a>',
				'manage/<_m>/<_c>/<_a>' => '<_m>/<_c>/<_a>',
			),
		),
		'errorHandler' => array(
			'errorAction' => 'main/error',
		),
	)
);
?>