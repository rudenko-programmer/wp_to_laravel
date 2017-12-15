@extends('blog.layout')

@section('content')
    <div class="row">
        <div class="span6 offset3">
            <h2>Вход</h2>
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
                <div class="control-group {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="control-label">E-Mail адрес</label>
                    <div class="controls">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="control-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="control-label">Пароль</label>
                    <div class="controls">
                        <input id="password" type="password" class="form-control" name="password" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="control-group span24">
                    <div class="controls">
                        <div class="checkbox">
                            <label class="checkbox">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Запомнить
                            </label>
                        </div>
                    </div>
                    <div class="controls">
                        <a class="btn btn-link" href="{{ url('/password/reset') }}">
                            Забыли пароль ?
                        </a>
                    </div>
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">
                            Войти
                        </button>
                    </div>
                    <div>
                        <hr>
                        <h4>Войти с помощью</h4>
                        <a class="btn btn-link" href="{{ route('social_redirect',['provider'=>'facebook']) }}">
                            <img src="{{ asset('img/social/Facebook.png')}}" alt="Login with Facebook" width="80">
                        </a>
                        <a class="btn btn-link" href="{{ route('social_redirect',['provider'=>'google']) }}">
                            <img src="{{ asset('img/social/Google-plus.png')}}" alt="Login with Google" width="80">
                        </a>
                        <a class="btn btn-link" href="{{ route('social_redirect',['provider'=>'linkedin']) }}">
                            <img src="{{ asset('img/social/Linkedin.png')}}" alt="Login with LinkedIn" width="80">
                        </a>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
