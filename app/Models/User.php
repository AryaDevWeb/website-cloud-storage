<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Gallery;
use App\Models\Wallet;
use App\Models\Folder;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'storage_used',
        'storage_quota'
    ];
    //

    public function galleries() 
    {
        return $this->hasMany(Gallery::class);

    }

    public function wallets()
    {
        return $this->hasOne(related: Wallet::class);
    }

    public function folders()
    {
        return $this->hasMany(Folder::class);
    }
}
