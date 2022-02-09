<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Message extends Component
{

    public $sender;
    public $message;
    public $pv_messages;
//    public $not_seen;

    public function mountData()
    {
        if (isset($this->sender->id)) {
            $this->pv_messages = \App\Models\Message::where('user_id', Auth::id())->where('receiver_id', $this->sender->id)->
            orWhere('user_id', $this->sender->id)->where('receiver_id', Auth::id())->orderBy('id', 'DESC')->get();

//            $this->not_seen = \App\Models\Message::where('user_id', $this->sender->id)->where('receiver_id', \Illuminate\Support\Facades\Auth::id())->get();


        }

    }

    public function getUser($userId)
    {
        $user = User::find($userId);
        $this->sender = $user;
        $this->pv_messages = \App\Models\Message::where('user_id', Auth::id())->where('receiver_id', $userId)->
        orWhere('user_id', $userId)->where('receiver_id', Auth::id())->orderBy('id', 'DESC')->get();


        $not_seen = \App\Models\Message::where('user_id', $userId)->get();

        foreach ($not_seen as $ns){
            $ns->is_seen = true;
            $ns->save();

        }
    }

    public function sendMessage()
    {
        if ($this->sender) {

            \App\Models\Message::create([
                'message' => $this->message,
                'user_id' => auth()->user()->id,
                'receiver_id' => $this->sender->id,

            ]);

            $this->message = null;
            session()->flash('success', 'Send Message For ' . $this->sender->name . 'Is Successfully!!');

        } else {
            session()->flash('error', 'Please Select One Person For Chat');
        }
    }


    public function render()
    {
        $users = User::all()->except(Auth::id());
        return view('livewire.message', ['users' => $users]);
    }


}
