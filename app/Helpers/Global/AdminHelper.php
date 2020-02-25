<?php


if (! function_exists('admin')) {
    /**
     * Access the admin auth helper.
     *
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    function admin()
    {
        return auth('admin');
    }
}
