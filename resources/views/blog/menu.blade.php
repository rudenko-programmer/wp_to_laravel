<div class="span7 navigation">
    <div class="navbar hidden-phone">

        <ul class="nav">
            @yield('menu.before')
            <li @if(Request::url() === url('/')) class="active" @endif><a href="{{ url('/') }}">Главная</a></li>
            <li @if(Request::url() == url('/blog')) class="active" @endif><a href="{{ url('/blog') }}">Блог</a></li>
            @if (Auth::guest())
                <li @if(Request::url() == url('/login')) class="active" @endif><a href="{{ url('/login') }}">Войти</a></li>
                <li @if(Request::url() == url('/register')) class="active" @endif><a href="{{ url('/register') }}">Регистрация</a></li>
            @else
                <li>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" ><i class="icon-user"></i> {{ Auth::user()->first_name }} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        @if(Auth::user()->isAdmin())
                            <li>
                                <a href="{{ url('/adminpanel') }}">Панель администратора</a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ url('/logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                Выйти
                            </a>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            @endif
        </ul>

    </div>

    <!-- Mobile Nav
    ================================================== -->
    <form action="#" id="mobile-nav" class="visible-phone">
        <div class="mobile-nav-select">
            <select onchange="window.open(this.options[this.selectedIndex].value,'_top')">
                <option value="">Меню...</option>
                <option value="{{ url('/') }}">Главная</option>
                <option value="{{ url('/blog') }}">Блог</option>
                @if (Auth::guest())
                    <option value="{{ url('/login') }}">Войти</option>
                    <option value="{{ url('/register') }}">Регистрация</option>
                @endif
            </select>
        </div>
    </form>

</div>