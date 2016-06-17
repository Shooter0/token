<?php

namespace Vuer\Token\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token', 'expiration_date', 'type',
    ];

    /**
     * Get all of the owning tokenable models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function tokenable()
    {
        return $this->morphTo();
    }
}
