<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'personalbudgetMVC';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = '';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;
    /**
     * Secret key for hashing
     * @var boolean
     */
    const SECRET_KEY = 'Fxufr7z6HCjjBEkaoFOfYwGCwQE0Dv8s';

    const MAIL_ADDRESS = 'pawelmaj0@gmail.com';

    const MAIL_PASSWORD = 'zvuyaawlcarmquhb';

    const CAPTCHA_SECRET_KEY = '6LeQ1OQjAAAAAAS2VjtWBMwrNIM_uL9U5YHAwgml';

}
