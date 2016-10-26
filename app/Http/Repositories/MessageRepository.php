<?php

namespace App\Http\Repositories;

use DB;
use Auth;
use App\Message;
use App\MessageDetail;

class MessageRepository implements MessageRepositoryInterface
{
    /**
     * @param array $request
     */
    public function saveEntity(array $request)
    {
        DB::transaction(function() use  ($request) {
            $message = Message::create($request);
            $request['message_id'] = $message->id;
            $request['user_id'] = $message->receiver_id;
            $request['is_last'] = true;
            MessageDetail::create($request);
        });
    }

    public function getAll()
    {
        return DB::select(DB::raw('select
u.name, u.email,
m.sender_id, m.receiver_id, md.created_at,
m.sender_id,m.receiver_id, IF(md.user_id = m.receiver_id ,1, 0) as r, md.user_id, md.is_unread,
case
	when md.is_unread = 1 then md.is_unread = IF(md.user_id = m.receiver_id ,1, 0)
end as unread,
md.message_id
from message_details as md
left  join `message_details` as `md1` on (`md`.`message_id` = `md1`.`message_id` and md1.id > md.id )
inner join messages as m on (m.id = md.message_id)
inner join users as u on (u.id = IF(md.user_id = m.sender_id, m.sender_id, m.receiver_id))
where md1.id is null
and (m.sender_id = '.Auth::id().' or m.receiver_id = '.Auth::id().')
and
case
		WHEN m.receiver_id = '.Auth::id().' then md.user_id = m.receiver_id
		WHEN m.sender_id  = '.Auth::id().' then md.user_id = m.sender_id
	end
order by md.message_id desc'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getMessagesById($id)
    {
        return DB::table('message_details')
            ->join('messages as m','m.id', '=', 'message_details.message_id')
            ->join('users as u ','u.id', '=', DB::raw('if(message_details.user_id = m.sender_id, m.receiver_id, m.sender_id)'))
            ->select(DB::raw('if(message_details.user_id = m.sender_id, m.receiver_id, m.sender_id) as receiver'), 'u.email', 'message_details.id', 'message_details.user_id', 'message_details.message_id', 'message_details.subject', 'message_details.body', 'message_details.is_unread', 'm.sender_id', 'm.receiver_id')
            ->where('message_details.message_id', '=', $id)->get();
    }

    /**
     * @param $id
     */
    public function updateVisibility($id)
    {
        DB::table('message_details')->where('message_id', $id)
            ->update(['is_unread' => false]);
    }

    /**
     * @param $request
     */
    public function saveEntityDetails($request)
    {
        MessageDetail::create($request);
    }


}