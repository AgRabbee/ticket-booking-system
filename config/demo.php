<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Portfolio notice
    |--------------------------------------------------------------------------
    |
    | A strip shown above every public page and dashboard telling visitors
    | this is a portfolio project and nothing on it is real. Set
    | DEMO_BANNER=false in .env to hide it.
    |
    */

    'banner' => [
        'enabled' => env('DEMO_BANNER', true),
        'title'   => 'Portfolio project',
        'message' => 'This site is a demo built for my portfolio. All trips, companies, bookings and payments are sample data: no real tickets are sold and no real money is charged.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Demo accounts
    |--------------------------------------------------------------------------
    |
    | These sign-ins are published on the sign-in page so portfolio visitors
    | can try every role. They can browse and add data, but the "demo"
    | middleware stops them deleting data, deactivating users or companies,
    | and changing the shared passwords. Any other account is unaffected.
    |
    */

    'password' => '123456',

    'logins' => [
        'traveller' => 'demo.traveller@tbs.com',
        'company'   => 'demo.company@tbs.com',
        'admin'     => 'demo.admin@tbs.com',
    ],

    'accounts' => [
        'demo.traveller@tbs.com',
        'demo.company@tbs.com',
        'demo.admin@tbs.com',
    ],

    'messages' => [
        'delete' => "You can't perform that delete because you are just visiting this site with a demo account. A real admin account can.",
        'change' => "You can't make that change because you are just visiting this site with a demo account. A real account can.",
    ],

];
