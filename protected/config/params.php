<?php

return [
    // commenting
    'disqus'     => [
        'shortname' => 'disqus_shortname',
    ],
    // twitter login
    'hybridauth' => [
        'providers' => [
            'Twitter' => [
                'enabled' => false,
                'keys'    => [
                    'key'    => '',
                    'secret' => ''
                ]
            ]
        ]
    ],
    // emails with sendgrid
    'sendgrid'   => [
        'username' => '',
        'password' => '',
        'from'     => ''
    ],

];
