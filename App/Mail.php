<?php

namespace App;

use App\Config;
use Mailgun\Mailgun;

/**
 * Mail
 *
 * PHP version 7.0
 */
class Mail
{

    /**
     * Send a message
     *
     * @param string $to Recipient
     * @param string $subject Subject
     * @param string $text Text-only content of the message
     * @param string $html HTML content of the message
     *
     * @return mixed
     */
    public static function send($to, $subject, $text, $html)
    {
      $mg = Mailgun::create('9a0381db37ca6d60a851a7077a016a5c-ca9eeb88-208b7ba3'); // For US servers

      $mg->messages()->send('sandbox0d9a2d2e64154bc4adc734c4231571ed.mailgun.org', [
        'from'    => 'your-sender@your-domain.com',
        'to'      => $to,
        'subject' => $subject,
        'text'    => $text
      ]);
    }
    
}
