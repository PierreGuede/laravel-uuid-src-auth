<?php

namespace App\Traits;

trait EncryptPasswordTrait
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->password = bcrypt($model->password);
        });
    }
}
