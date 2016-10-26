<?php

namespace App;
use Auth;
use DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cmgmyr\Messenger\Traits\Messagable;

class User extends Authenticatable
{
    use Notifiable, Messagable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeExcludeAuth($query)
    {
        return $query->where('id', '!=', Auth::id());
    }

    /**
     * @param $query
     * @return array $usersAsArray
     * @throws \Exception
     */
    public function scopeToOptionArray($query)
    {
        $users = $query->get(['id', 'name']);
        if ($users->isEmpty())
            throw new \Exception('Please add a new user first!');

        $usersAsArray = ['select' => '--Select--'];
        foreach ($users as $user) {
            $usersAsArray[$user->id] = $user->name;
        }

        return $usersAsArray;
    }

    public function scopeWithMessages($query)
    {

        $userId = Auth::id();
        DB::enableQueryLog();
        $data = $query->leftjoin('messages as m','users.id', '=', 'm.receiver_id')
            ->join('message_details as md','m.id', '=', 'md.message_id')
            ->join('users as u ','u.id', '=', 'm.sender_id')
            ->select('users.*', 'm.*', 'md.*', 'u.name as sender_name', 'u.email as sender_email', 'm.created_at as dtc')
            ->where('md.user_id', '=',  $userId)
            ->orderBy('md.id', 'desc')
            ->get();
        return $data;
    }

}
