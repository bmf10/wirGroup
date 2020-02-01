<?php

require_once APPPATH . 'libraries/JWT.php';

use \Firebase\JWT\JWT;

function is_merchant($header)
{
    if ($header) {
        $key = "ynxxmglqb8r7MyMmqfpnIQZLtUljLhHcSnT4WbJKHgSpPphqtBqgq9IZFjybb34H5Nh6NnunScwbpK1mTG6uckN6wdE7fHrykMHb";
        $token = explode(" ", $header);

        $decode = JWT::decode($token[1], $key, array('HS256'));

        if ($decode->role != 2) {
            response('error', "JWT token not valid", 200);
            exit;
        } else {
            if ($decode->exp < time()) {
                response('error', "JWT has expired, please re-login", 200);
                exit;
            } else {
                return $decode;
            }
        }
    } else {
        response('error', "JWT token not found", 200);
        exit;
    }
}

function is_customer($header)
{
    if ($header) {
        $key = "ynxxmglqb8r7MyMmqfpnIQZLtUljLhHcSnT4WbJKHgSpPphqtBqgq9IZFjybb34H5Nh6NnunScwbpK1mTG6uckN6wdE7fHrykMHb";
        $token = explode(" ", $header);

        $decode = JWT::decode($token[1], $key, array('HS256'));

        if ($decode->role != 1) {
            response('error', "JWT token not valid", 200);
            exit;
        } else {
            if ($decode->exp < time()) {
                response('error', "JWT has expired, please re-login", 200);
                exit;
            } else {
                return $decode;
            }
        }
    } else {
        response('error', "JWT token not found", 200);
        exit;
    }
}
