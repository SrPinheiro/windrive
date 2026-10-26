<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'client_id', 'client_secret'])]
#[Hidden(['client_secret'])]
class GoogleCredential extends Model
{
    protected function casts(): array
    {
        return [
            'client_secret' => 'encrypted',
        ];
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(DriveAccount::class);
    }
}
