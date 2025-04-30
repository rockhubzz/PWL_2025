<?php

namespace Illuminate\Support\Facades;

interface Auth
{
    /**
     * @return \App\Models\UserModel|false
     */
    public static function loginUsingId(mixed $id, bool $remember = false);

    /**
     * @return \App\Models\UserModel|false
     */
    public static function onceUsingId(mixed $id);

    /**
     * @return \App\Models\UserModel|null
     */
    public static function getUser();

    /**
     * @return \App\Models\UserModel
     */
    public static function authenticate();

    /**
     * @return \App\Models\UserModel|null
     */
    public static function user();

    /**
     * @return \App\Models\UserModel|null
     */
    public static function logoutOtherDevices(string $password);

    /**
     * @return \App\Models\UserModel
     */
    public static function getLastAttempted();
}