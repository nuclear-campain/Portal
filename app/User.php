<?php

namespace App;

use Illuminate\Database\Eloquent\{Builder, SoftDeletes};
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 * 
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Method for hashing the given password in the application storage. 
     * 
     * @param  string $password The given or generated password from the application/form
     * @return void
     */
    public function setPasswordAttribute(string $password): void
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Scope for getting all the admin users out the storage.
     *
     * @param  Builder $query The query builder instance.
     * @return Builder
     */
    public function scopeAdminUsers(Builder $query): Builder
    {
        return $query->role('admin');
    }

    /**
     * Scope for only getting the deleted user out of the application.
     *
     * @param  Builder $query The query builder instance.
     * @return Builder
     */
    public function scopeDeletedUsers(Builder $query): Builder
    {
        return $query->onlyTrashed();
    }
}
