@extends('layouts.admin')

@section('content')
    <h1>Edit Users</h1>
    <div class="row">
        <div class="col-sm-3">
            <img src="{{$user->photo? $user->photo->file: 'http://placehold.it/400x400'}}" alt="" class="img-responsive img-rounded">
        </div>

        <div class="col-sm-9">
            {!! Form::model($user,['method'=>'PATCH','action'=>['AdminUsersController@update',$user->id],'files'=>true])!!}

            <div class="form-group">
                {!!Form::label('name','Name:')!!}
                {!!Form::text('name',null,['class'=>'form-control'])!!}

            </div>

            <div class="form-group">
                {!!Form::label('email','Email:')!!}
                {!!Form::email('email',null,['class'=>'form-control'])!!}

            </div>

            <div class="form-group">
                {!!Form::label('role_id','Role:')!!}
                {!!Form::select('role_id',[''=>'Choose Options'] + $roles ,null,['class'=>'form-control'])!!}

            </div>

            <div class="form-group">
            {!!Form::label('is_active','Status:')!!}
            {!!Form::select('is_active',array(1=>'Active', 0=>'Not Active'),null,['class'=>'form-control'])!!}<!--0 between commas is default value change it to null to allow laravel to input some info in the field-->

            </div>

            <div class="form-group">
                {!!Form::label('photo_id','Photo:')!!}
                {!!Form::file('photo_id',['class'=>'form-control'])!!}

            </div>

            <div class="form-group">
            {!!Form::label('password','Password:')!!}
            {!!Form::password('password',['class'=>'form-control'])!!}<!--password without null-->

            </div>

            <div class="form-group">
                {!!Form::submit('Create User',['class'=>'btn btn-primary'])!!}
            </div>

            {!! Form::close()!!}
        </div>
    </div>

    <div class="row">@include('includes.form_errors')</div>


@endsection