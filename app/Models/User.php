<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type_of_user_id',
        'name',
        'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function messages()
    {
//        $x = Relation::macro();

//
//        return $this->hasMany(Message::class, 'sender_user', 'id')
//                    ->orWhere('recipient_user', $this->id)
//                    ->setModel($this)
//            ;

//
        $x = $this->hasManyThrough(
            User::class,
            Message::class,
            'id',
            'id',
            'sender_user',
            'sender_user'
        )
            ->orWhereNotNull('messages.id')
            ->where('users.id', '!=', $this->id)
        ;
//        dd($x->toSql());
        return $x;


//        return Message::query()
//            ->where('sender_user', $this->id)
//            ->orWhere('recipient_user', $this->id)
//            ->;
    }
}
