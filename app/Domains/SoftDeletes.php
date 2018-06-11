<?php

namespace Emtudo\Domains;

use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;

abstract class SoftDeletes extends Model
{
    use EloquentSoftDeletes;
}
