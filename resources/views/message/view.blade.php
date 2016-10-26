@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Messages View</div>
                    <table class="table table-bordered">
                        @if(!$messages->isEmpty())
                            @foreach($messages as $message)
                                <tr>
                                    <td>Sender:</td>
                                    <td>{{$message->email}}</td>
                                    <div style="display: none" class="visibility" rel="{{ $message->is_unread }}"></div>
                                </tr>
                                <tr>
                                    <td colspan="2">{{$message->subject}} <br /> {{$message->body}}

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
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-body">

                                @include('partials.errors.form')

                                {!! Form::open([
                                    'method' => 'POST',
                                    'route' => ['message.storeDetails'],
                                    'class'=>'form-horizontal'
                                ]) !!}

                                <div class="form-group">
                                    {!! Form::label(
                                    'subject',
                                    'Subject:',
                                    ['class' => 'control-label col-md-4'])
                                    !!}
                                    <div class="col-md-6">
                                        {!! Form::text('subject', old('subject') ? old('subject') : $messages->last()->subject , ['class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label(
                                    'body',
                                    'Body:',
                                    ['class' => 'control-label col-md-4'])
                                    !!}
                                    <div class="col-md-6">
                                        {{ Form::textarea('body', old('body'), ['class' => 'form-control', 'size' => '10x5']) }}
                                    </div>
                                </div>

                                {{ Form::hidden('user_id', $messages->last()->receiver) }}
                                {{ Form::hidden('message_id', $messages->last()->message_id) }}

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        {!! Form::submit('Reply', ['class' => 'btn btn-primary']) !!}
                                    </div>
                                </div>

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function(){
            var hasVisibility = 0;
            jQuery('.visibility').each(function() {
                if (jQuery(this).attr('rel') == 1) {
                    hasVisibility = 1;
                }
            });
            if (hasVisibility == 1) {
                jQuery.ajax({
                    type: 'POST',
                    //dataType: 'json',
                    data: {
                        messageId: "{{ $messages->last()->message_id }}" ,
                    },
                    url: "{{  route('message.hasBeenSeen') }}"
                }).done(function(result) {
                });
            }
        });

    </script>
@endsection
