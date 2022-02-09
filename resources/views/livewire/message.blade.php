<div>
    <div class="container">
        @if(\Illuminate\Support\Facades\Session::has('error'))
            <div class="alert alert-danger">
                <i class="fa fa-warning"
                   style="font-size:30px;margin-right: 5px;color:red"></i>{{\Illuminate\Support\Facades\Session::get('error')}}
            </div>
        @endif

        @if(\Illuminate\Support\Facades\Session::has('success'))
            <div class="alert alert-success">
                <i class="fa fa-check"
                   style="font-size:30px;margin-right: 5px;color:green"></i>{{\Illuminate\Support\Facades\Session::get('success')}}
            </div>
        @endif
        <div class="row justify-content-center">


            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Users
                    </div>
                    <div class="card-body chatbox p-0">
                        <ul class="list-group list-group-flush">
                            @foreach($users as $user)
                                <a wire:click="getUser({{$user->id}})" class="text-dark text-decoration-none pointer">
                                    <li class="list-group-item link">
                                        <img class="img-fluid avatar"
                                             src="https://www.iconpacks.net/icons/1/free-icon-businessman-280.png">
                                        @if($user->is_online ==true)
                                            <i class="fa fa-circle text-success"></i>
                                        @endif
                                        {{$user->name}}

                                        @php
                                            $not_seen = \App\Models\Message::where('user_id',$user->id)->
                                            where('receiver_id',\Illuminate\Support\Facades\Auth::id())->
                                            where('is_seen' , false)->get();

                                        @endphp

                                        @if(filled($not_seen))
                                            <div class="badge badge-success">
                                                {{$not_seen->count()}}
                                            </div>
                                        @endif


                                    </li>
                                </a>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>


            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        @if(isset($sender))
                            {{$sender->name}}
                        @endif
                    </div>


                    <div class="card-body message-box" id="messageBody" wire:poll.10ms="mountData">
                        @if(!empty($pv_messages))
                            @foreach($pv_messages as $msg)
                                <div
                                    class="single-message @if($msg->user_id ==auth()->id()) sent @else received @endif ">
                                    <p class="fw-bolder"> {{$msg->user->name}}</p>
                                    {{$msg->message}}
                                    <br>
                                    <small class="text-muted w-100">Send <em>{{$msg->created_at}}</em></small>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="card-footer">
                        <form wire:submit.prevent="sendMessage()">
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="text" class="form-control input shadow-none w-100 d-inline-block"
                                           required
                                           wire:model="message">

                                </div>
                                <div class="col-md-4">

                                    <button type="submit" class="btn btn-primary d-inline-block w-100"><i
                                            class="far fa-paper-plan"></i>Send
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
