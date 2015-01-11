<?php

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

$branch = "frontend";
if ($_SERVER['REQUEST_URI'] == "/manage" or mb_strpos($_SERVER['REQUEST_URI'], "/manage/", 0, "UTF-8") === 0)
	$branch = "backend";

// Php constants and functions
require_once(dirname(__FILE__) . '/../vendors/constants_and_functions.php');

return CMap::mergeArray(
	array(
		'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
		'name' => 'Plusone CMS',
		// preloading 'log' component
		'preload' => array('log'),
		'language' => 'ru',
		'sourceLanguage' => 'en',
		// autoloading model and component classes
		'import' => array(
			'application.models.*',
			'application.components.*',
			'application.extensions.mailer.YiiMailMessage',
		),
		'components' => array(
			'user' => array(
				'class' => 'CWebUser',
				'allowAutoLogin' => true,
			),
			'authManager' => array(
				'class' => 'DbAuthManager',
				'connectionID' => 'db',
				'userTable' => 'user',
			),	
			'urlManager' => array(
				'urlFormat' => 'path',
				'showScriptName' => false,
			),
			'log' => array(
				'class' => 'CLogRouter',
				'routes' => array(
					array(
						'class' => 'CFileLogRoute',
						'levels' => 'error, warning, info',
					),
				),
			),
			'ih' => array(
				'class' => 'CImageHandler',
			),
			'config' => array(
				'class' => 'CConfig',
			),
		),
		'modules' => array(
			'callback',	
		),
		'behaviors' => array(
			'runBranch' => array(
				'class' => 'application.behaviors.WebApplicationBranchBehavior',
				'branch' => $branch,
			),
			'modulesInformation' => array(
				'class' => 'application.behaviors.ModulesInformationBehavior',
			),
		),
	),
	require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'local.php'),
	require(dirname(__FILE__) . DIRECTORY_SEPARATOR . $branch . '.php')
);
?>