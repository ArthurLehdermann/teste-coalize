<?php

return [
    'POST api/auth' => 'auth/login',
    'POST api/auth/refresh' => 'auth/refresh-token',

    'GET api/customers/<id:\d+>' => 'customer/read',
    'POST api/customers' => 'customer/create',
    'PUT api/customers/<id:\d+>' => 'customer/update',
    'DELETE api/customers/<id:\d+>' => 'customer/delete',
    'GET api/customers' => 'customer/index',

    'GET api/products/<id:\d+>' => 'product/read',
    'POST api/products' => 'product/create',
    'PUT api/products/<id:\d+>' => 'product/update',
    'DELETE api/products/<id:\d+>' => 'product/delete',
    'GET api/products' => 'product/index',
];