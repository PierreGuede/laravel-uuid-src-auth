<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UUIDTrait
{
    /**
    * Create regular or static methods here
    */
    protected static function boot ()
    {
        // Boot other traits on the Model
        parent::boot();

        /**
         * Listen for the creating event on the user model.
         * Sets the 'id' to a UUID using Str::uuid() on the instance being created
         */
        static::creating(function ($model){
            if($model->getKey()===null){
                $model->setAttribute($model->getKeyName(),Str::uuid()->toString());
            }
            if (isset($model->password)) {
                $model->password = bcrypt($model->password);
            }
            if (isset($model->two_factor_code)) {
                # code...
            }
        });
    }

    public function getIncrementing ()
    {
        return false;
    }

    public function getKeyType ()
    {
        return 'string';
    }
}
