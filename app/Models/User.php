<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'email_notification', 'password','signature','phone','PBPBC'.'PBTYP','Department_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $dateFormat = 'Ymd H:i:s.v';
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
    public function authorization(){
        return $this->hasMany(Authorization::class, 'User_id');
    }
    public function buyer(){
        return $this->belongsTo(Buyer::class,'Buyer_id');
    }
    //Relación uno a muchos (  -  )
    public function department(){
        return $this->belongsTo(Department::class,'Department_id');
    }
    //Relación uno a muchos (Users  - Quotes )
    public function quoteGerente(){
        return $this->hasMany(RequestQuote::class, 'Gerente_id');
    }
    public function quoteDirector(){
        return $this->hasMany(RequestQuote::class, 'Director_id');
    }
    public function quoteVicepresidente(){
        return $this->hasMany(RequestQuote::class, 'Vicepresidente_id');
    }
    public function quotePresidente(){
        return $this->hasMany(RequestQuote::class, 'Presidente_id');
    }
    public function quoteBuyer(){
        return $this->hasMany(RequestQuote::class, 'Buyer_id');
    }
}
