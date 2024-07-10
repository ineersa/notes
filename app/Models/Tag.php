<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends \Spatie\Tags\Tag
{
    protected $connection = \App\Services\UserDatabasesService::CONNECTION_NAME;
}
