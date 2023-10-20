<?php

declare(strict_types=1);

return [
    /****************************************************************************
     * Application Settings
     * --------------------------------------------------------------------------
     *
     * These are the core settings for your application.
     *****************************************************************************/

    'app_name' => 'CLImage - Helper Tool for Images',

    'app_path' => [
        __DIR__.'/../app/Command',
        '@minicli/command-help'
    ],

    'theme' => '',

    'debug' => true,

    'output_path' => __DIR__.'/../output',
];
