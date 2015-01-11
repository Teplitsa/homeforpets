<?php

Yii::import('ext.swiftmailer.YiiMail');
/**
 * Class CallbackMail
 */
class CallbackMail extends YiiMail
{
    /**
     * Sends a message
     *
     * @param mixed $to
     * @param mixed $subject
     * @param string $body
     *
     * @return int
     */
    public function send($to, $subject, $body)
    {
        $result = 0;
        if ($callbackOptions = CallbackConfig::model()->find() and $callbackOptions->enabled)
        {
            $options = array();
            $emailFrom = null;
            if ($callbackOptions->type == 'smtp')
            {
                $options['host'] = $callbackOptions->host;
                $options['username'] = $callbackOptions->username;
                $options['password'] = $callbackOptions->password;
                if ($callbackOptions->port)
                    $options['port'] = $callbackOptions->port;

                if ($callbackOptions->encryption)
                    $options['encryption'] = $callbackOptions->encryption;

                $emailFrom = $callbackOptions->username;
            }
            else
            {
                $admin = User::model()->findByPk(1);
                $emailFrom = $admin->email;
            }

            parent::setTransportOptions($callbackOptions->type, $options);

            $from = array($emailFrom => $callbackOptions->sender);

            $result = parent::send($from, $to, $subject, $body);
        }

        return $result;
    }
}