<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    | 跨域中最难的一个部分，就是解决客户端的预检问题，
    | 如果是自己手写跨域就得手动处理OPTIONS请求，并响应所有HTTP动作，如果使用fruitcake/laravel-cors，就不需要处理这个问题，包已经自动解决了。
    | 另一个问题，则是header支持的字段，需要手动填充，否则前端是无法获取的
    | $response->header('Access-Control-Allow-Origin', '*');
    | $response->header('Access-Control-Allow-Headers', 'X-Requested-With, Origin, Content-Type, Accept, Authorization, AjaxPagePath');
    | $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS');
    | $response->header('Access-Control-Allow-Credentials', 'false');

    原理：
    配置文件中maxAge属性很重要，相当于http属性（Access-Control-Max-Age）。
    我们在Network下面看到同一个url有两条请求，url有两条请求。
    第一条请求的Method为OPTIONS。
    第二条请求的Method才是真正的Get或者Post。
    这是由于Web服务器在处理跨域访问引起的，options其实是一种预检请求，浏览器在处理跨域问题是会先辨别发送的请求是否为复杂请求，
    如果是则会先向服务器发送一条预检请求，再根据服务器的返回内容由浏览器判断服务器是否允许此次请求，如果服务器是使用cors的方式来支持跨域访问的，那么预检行为是必不可少的。
    如果要避免预检行为的发生，可以在发送了一个请求之后设置一个预检有效期，在有效期内对该浏览器发送请求不再重复预检，
    设置这个参数即可达到预期目标，该参数用来指定本次预检请求的有效期，单位为秒。

    简单的默认方法：allowed_origins, allowed_headers and allowed_methods can be set to ['*'] to accept any value.

    注意：postman不会发生预检行为，浏览器等标准的Http客户端才会有预检行为。
    |
    */

    'paths' => ['v1/*'], // 指定匹配路径的路由支持跨域，这个是laravel的配置，不是http的配置

    // 'allowed_methods' => ['*'],
    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    // 'exposed_headers' => [],
    'allowed_headers' => ['X-Requested-With', 'Origin', 'Content-Type', 'Accept', 'Authorization', 'AjaxPagePath', '各种自定义的头'],

    'max_age' => 0,

    'supports_credentials' => false,

];
