<?php

namespace Illuminate\Http;

interface Request
{
    /**
     * @return \App\Models\UserModel|null
     */
    public function user($guard = null);
}