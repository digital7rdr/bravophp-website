<?php

return [
    'name' => env_value('APP_NAME', 'Bravo Secure'),
    'env' => env_value('APP_ENV', 'production'),
    'url' => rtrim(env_value('APP_URL', 'http://localhost:8000'), '/'),
    'mail_to' => env_value('MAIL_TO', 'info@bravo-secure.com'),
];
