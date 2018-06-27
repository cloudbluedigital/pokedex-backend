<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Pokemon extends Model
{
    use Searchable;
}
