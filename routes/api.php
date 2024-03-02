<?php

return [
    'POST api/auth' => 'auth/login',

    'GET api/customers/<id:\d+>' => 'customer/read',
    'POST api/customers' => 'customer/create',
    'PUT api/customers/<id:\d+>' => 'customer/update',
    'DELETE api/customers/<id:\d+>' => 'customer/delete',
    'GET api/customers' => 'customer/index',
];