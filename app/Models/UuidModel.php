<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class UuidModel extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        // https://laracasts.com/discuss/channels/laravel/uuid-as-primary-key-type
        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4()->toString());
        });
    }
}
