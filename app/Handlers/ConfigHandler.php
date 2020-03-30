<?php


namespace App\Handlers;


class ConfigHandler
{
    public function userField()
    {
        return auth('api')->id();
    }
}