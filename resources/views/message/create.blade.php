@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create Message</div>
                <div class="panel-body">

                    @include('partials.errors.form')

                    {!! Form::open([
                        'method' => 'POST',
                        'route' => ['message.store'],
                        'class'=>'form-horizontal'
                    ]) !!}

                    <div class="form-group">
                        {!! Form::label(
                        'receiver_id',
                        'To:',
                        ['class' => 'control-label col-md-4'])
                        !!}
                        <div class="col-md-6">
                            {!! Form::select(
                            'receiver_id',
                            $users, old('receiver_id') ? old('receiver_id') : 'select',
                            ['class' => 'form-control']) !!}
                        </div>
                    </div>


                    <div class="form-group">
                        {!! Form::label(
                        'subject',
                        'Subject:',
                        ['class' => 'control-label col-md-4'])
                        !!}
                        <div class="col-md-6">
                            {!! Form::text('subject', old('subject') , ['class' => 'form-control']) !!}
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


                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            {!! Form::submit('Create Message', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection