<?php

/**
* YiiMail is an component used for sending email.
*
* Example usage:
* <pre>
* $mailer = new YiiMail;
* $message = new YiiMailMessage;
* $message->setBody('Message content here with HTML', 'text/html');
* $message->setSubject('My Subject');
* $message->setTo('receiver@domain.org');
* $message->setFrom('sender@domain.org');
* $mailer->send($message);
* </pre>
*/
class YiiMail
{
	/**
	 * @var string the delivery type. Can be either 'php' or 'smtp'.  When
	 * using 'php', PHP's {@link mail()} function will be used.
	 * Defaults to 'php'.
	 */
	private $transportType = 'php';

	/**
	 * @var string options specific to the transport type being used.
	 * To set options for STMP, set this attribute to an array where the keys
	 * are the option names and the values are their values.
	 * Possible options for SMTP are:
	 * <ul>
	 * 	<li>host</li>
	 * 	<li>username</li>
	 * 	<li>password</li>
	 * 	<li>port</li>
	 * 	<li>encryption</li>
	 * </ul>
	 * See the SwiftMailer documentaion for the option meanings.
	 */
	private $transportOptions = null;

	/**
	 * Includes swiftmailer's required files
	 */
	public function __construct()
	{
		require dirname(__FILE__) . '/lib/classes/Swift.php';
		Yii::registerAutoloader(array('Swift', 'autoload'));
		require dirname(__FILE__) . '/lib/swift_init.php';
	}

	/**
	 * To set options for STMP, set this attribute to an array where the keys
	 * are the option names and the values are their values.
	 *
	 * @param string $type
	 * @param array $options
	 *
	 * @return YiiMail
	 */
	public function setTransportOptions($type = 'php', $options = array())
	{
		$this->transportType = $type;
		$this->transportOptions = $options;

		return $this;
	}

	/**
	 * Gets the SwiftMailer transport class instance, initializing it if it has
	 * not been created yet
	 *
	 * @return mixed {@link Swift_MailTransport} or {@link Swift_SmtpTransport}
	 */
	private function getTransport()
	{
		$transport = null;
		switch ($this->transportType)
		{
			case 'php':
				$transport = Swift_MailTransport::newInstance();
				/*if ($this->transportOptions !== null)
					$transport->setExtraParams($this->transportOptions);*/
				break;
			case 'smtp':
				$transport = Swift_SmtpTransport::newInstance();
				if (is_array($this->transportOptions))
					foreach ($this->transportOptions as $option => $value)
						$transport->{'set' . ucfirst($option)}($value);
				break;
		}

		return $transport;
	}

	/**
	 * Sends a message.
	 *
	 * @param mixed $from address, string or array of the form $address => $name
	 * @param mixed $to address, string or array of the form $address => $name
	 * @param string $subject
	 * @param string $body
	 *
	 * @return int
	 */
	public function send($from, $to, $subject, $body)
	{
		$result = 0;

		$transport = $this->getTransport();
		if ($transport !== null)
		{
			$mailer = Swift_Mailer::newInstance($transport);
			$message = Swift_Message::newInstance($subject)
				->setFrom($from)
				->setTo($to)
				->setBody($body, 'text/html');

			self::log($message->toString());
			$result = $mailer->send($message);
		}
		else
			self::log('Can not get SwiftTransport.');

		return $result;
	}

	/**
	 * Logs a message using Yii::log.

	 * @return string log message
	 */
	public static function log($msg)
	{
		Yii::log($msg, CLogger::LEVEL_INFO, 'ext.swiftmailer.YiiMail');

		return $msg;
	}

}