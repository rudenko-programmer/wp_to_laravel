@extends('adminpanel.admin-layout')
@section('header','Пользователь '.$user->login)
@section('content')
    <form class="form-horizontal" method="POST" action="{{ route('edit_user_action') }}">
        <input name="_method" type="hidden" value="PUT">
        <input name="_token" type="hidden" value="{{ csrf_token() }}">
        <input name="user_id" type="hidden" value="{{ $user->user_id }}">
    <div class="col-sm-12">
        <section class="panel panel-default">
            <header class="panel-heading font-bold">Настройки пользователя</header>
            <div class="panel-body">
                    <div class="form-group @if($errors->has('login')) has-error  @endif">
                        <label for="user_login_id" class="col-sm-2 control-label">Логин:</label>
                        <div class="col-sm-10">
                            <input type="text" id="user_login_id" class="form-control" readonly value="{{ $user->login }}">
                            <span class="help-block m-b-none">Введите логин пользователя.</span>
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('email')) has-error  @endif">
                        <label for="user_email_id" class="col-sm-2 control-label">Email:</label>
                        <div class="col-sm-10">
                            <input type="email" id="user_email_id" name="email" class="form-control" required value="{{ $user->email }}">
                            <span class="help-block m-b-none">Введите email пользователя.</span>
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('first_name')) has-error  @endif">
                        <label for="user_first_name_id" class="col-sm-2 control-label">Имя:</label>
                        <div class="col-sm-10">
                            <input type="text" id="user_first_name_id" name="first_name" class="form-control" required value="{{ $user->first_name }}">
                            <span class="help-block m-b-none">Введите имя пользователя.</span>
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('second_name')) has-error  @endif">
                        <label for="second_name_id" class="col-sm-2 control-label">Фамилия:</label>
                        <div class="col-sm-10">
                            <input type="text" id="second_name_id" name="second_name" class="form-control" value="{{ $user->second_name }}">
                            <span class="help-block m-b-none">Введите фамилию пользователя.</span>
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('third_name')) has-error  @endif">
                        <label for="third_name_id" class="col-sm-2 control-label">Отчество:</label>
                        <div class="col-sm-10">
                            <input type="text" id="third_name_id" name="third_name" class="form-control" value="{{ $user->third_name }}">
                            <span class="help-block m-b-none">Введите отчество пользователя.</span>
                        </div>
                    </div>
                    {{--<div class="form-group @if($errors->has('password')) has-error  @endif">
                        <label for="password_id" class="col-sm-2 control-label">Пароль:</label>
                        <div class="col-sm-10">
                            <input type="text" id="password_id" name="password" class="form-control" value="{{ \Passworder::gen() }}">
                            <span class="help-block m-b-none">Введите пароль.</span>
                        </div>
                    </div>--}}
                    <div class="form-group @if($errors->has('role')) has-error  @endif">
                        <label for="role_id" class="col-sm-2 control-label">Роль:</label>
                        <div class="col-sm-10">
                            <select id="role_id" name="role" class="form-control">
                                <option value="author" {{ selected('author', $user->role) }}>Автор</option>
                                <option value="admin" {{ selected('admin', $user->role) }}>Администратор</option>
                                <option value="subscriber" {{ selected('subscriber', $user->role) }}>Подписчик</option>
                            </select>
                            <span class="help-block m-b-none">Выберите роль пользователя.</span>
                        </div>
                    </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary">Обновить данные пользователя</button>
                </div>
            </div>
        </section>
    </div>
    </form>
@endsection