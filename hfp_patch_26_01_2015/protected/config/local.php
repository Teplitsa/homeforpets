<?php
return array(
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=DBNAME',
            'emulatePrepare' => true,
            'username' => 'USER',
            'password' => 'PASSWORD',
            'charset' => 'utf8',
        ),
    ),
	'modules' => array(
		// uncomment the following to enable the Gii tool
		/*'gii' => array(
			'class' => 'system.gii.GiiModule',
			'password' => '123456',
			'ipFilters' => array('*'),
		),*/
	),
);
?>