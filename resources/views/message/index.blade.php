@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Messages View</div>
                    <table class="table table-bordered">
                        @if($messages)
                            @foreach($messages as $message)
                                <tr @if($message->unread) class="success" @endif>
                                    <td>{{$message->name}} ({{$message->email}})</td>
                                    <td>{{$message->created_at}}</td>
                                    <td style="width: 5%">
                                        <a class="btn btn-sm btn-primary" href="{{ route('message.view', $message->message_id) }}" role="button">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10">No messages!</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
