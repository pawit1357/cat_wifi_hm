<?php
return array (
		'name' => 'faa',
		'defaultController' => 'dashboard',
		'import' => array (
				'application.models.*',
				'application.components.*' 
		),
		'components' => array (
				'urlManager' => array (
						'urlFormat' => 'path' 
				),
				'db' => array (
						'class' => 'CDbConnection',
						'connectionString' => 'mysql:host=localhost;dbname=adsdb',
						'emulatePrepare' => true,
						'username' => 'root',
						'password' => 'P@ssw0rd',

						'charset' => 'utf8' 
				),
				'Smtpmail' => array (
						'class' => 'application.extensions.smtpmail.PHPMailer',
						'Host' => "smtp.gmail.com",
						'Username' => 'pawitvaap@gmail.com',
						'Password' => '',
						'Mailer' => 'smtp',
						'Port' => 465,
						'SMTPAuth' => true,
						'SMTPSecure' => 'ssl',
						'SMTPDebug' => 1 
				) 
		)
		 
);
?>