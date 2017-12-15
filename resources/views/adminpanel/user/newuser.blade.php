@extends('adminpanel.admin-layout')
@section('header','Новый пользователь')
@section('content')
    <form class="form-horizontal" method="POST" action="{{ route('create_user_action') }}">
    <input name="_token" type="hidden" value="{{ csrf_token() }}">
    <div class="col-sm-12">
        <section class="panel panel-default">
            <header class="panel-heading font-bold">Настройки пользователя</header>
            <div class="panel-body">
                    <div class="form-group @if($errors->has('login')) has-error  @endif">
                        <label for="user_login_id" class="col-sm-2 control-label">Логин:</label>
                        <div class="col-sm-10">
                            <input type="text" id="user_login_id" name="login" class="form-control" required value="{{ old('login') }}">
                            <span class="help-block m-b-none">Введите логин пользователя.</span>
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('email')) has-error  @endif">
                        <label for="user_email_id" class="col-sm-2 control-label">Email:</label>
                        <div class="col-sm-10">
                            <input type="email" id="user_email_id" name="email" class="form-control" required value="{{ old('email') }}">
                            <span class="help-block m-b-none">Введите email пользователя.</span>
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('first_name')) has-error  @endif">
                        <label for="user_first_name_id" class="col-sm-2 control-label">Имя:</label>
                        <div class="col-sm-10">
                            <input type="text" id="user_first_name_id" name="first_name" class="form-control" required value="{{ old('first_name') }}">
                            <span class="help-block m-b-none">Введите имя пользователя.</span>
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('second_name')) has-error  @endif">
                        <label for="second_name_id" class="col-sm-2 control-label">Фамилия:</label>
                        <div class="col-sm-10">
                            <input type="text" id="second_name_id" name="second_name" class="form-control" value="{{ old('second_name') }}">
                            <span class="help-block m-b-none">Введите фамилию пользователя.</span>
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('third_name')) has-error  @endif">
                        <label for="third_name_id" class="col-sm-2 control-label">Отчество:</label>
                        <div class="col-sm-10">
                            <input type="text" id="third_name_id" name="third_name" class="form-control" value="{{ old('third_name') }}">
                            <span class="help-block m-b-none">Введите отчество пользователя.</span>
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('password')) has-error  @endif">
                        <label for="password_id" class="col-sm-2 control-label">Пароль:</label>
                        <div class="col-sm-10">
                            <input type="text" id="password_id" name="password" class="form-control" value="{{ \Passworder::gen() }}">
                            <span class="help-block m-b-none">Введите пароль.</span>
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('role')) has-error  @endif">
                        <label for="role_id" class="col-sm-2 control-label">Роль:</label>
                        <div class="col-sm-10">
                            <select id="role_id" name="role" class="form-control">
                                <option value="author" {{ selected('author', old('role')) }}>Автор</option>
                                <option value="admin" {{ selected('admin', old('role')) }}>Администратор</option>
                                <option value="subscriber" {{ selected('subscriber', old('role')) }}>Подписчик</option>
                            </select>
                            <span class="help-block m-b-none">Выберите роль пользователя.</span>
                        </div>
                    </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary">Добавить пользователя</button>
                </div>
            </div>
        </section>
    </div>
    </form>
@endsection