<!DOCTYPE html>
<html lang="en" class="app">
<head>
    <meta charset="utf-8" />
    <title>Scale | Web Application</title>
    <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.4.0/css/bulma.min.css" type="text/css" />--}}
    <link rel="stylesheet" href="{{ asset('admin_assets/css/bootstrap.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('admin_assets/css/animate.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('admin_assets/css/font-awesome.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('admin_assets/css/icon.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('admin_assets/css/font.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('admin_assets/css/app.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('admin_assets/css/dropzone.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('admin_assets/css/lity.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('admin_assets/css/custom.css')}}" type="text/css" />

    <link rel="stylesheet" href="{{ asset('admin_assets/js/calendar/bootstrap_calendar.css')}}" type="text/css" />

    <!--[if lt IE 9]>
    <script src="{{ asset('admin_assets/js/ie/html5shiv.js')}}"></script>
    <script src="{{ asset('admin_assets/js/ie/respond.min.js')}}"></script>
    <script src="{{ asset('admin_assets/js/ie/excanvas.js')}}"></script>
    <![endif]-->
    @yield('head')
    <style>
        .delete.is-medium {
            height: 24px;
            width: 24px;
        }
        .delete {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -moz-appearance: none;
            -webkit-appearance: none;
            background-color: rgba(10,10,10,.2);
            border: none;
            border-radius: 290486px;
            cursor: pointer;
            display: inline-block;
            font-size: 1rem;
            height: 20px;
            outline: 0;
            position: relative;
            vertical-align: top;
            width: 20px;
        }
        .delete:after, .delete:before {
            background-color: #fff;
            content: "";
            display: block;
            left: 50%;
            position: absolute;
            top: 50%;
            -webkit-transform: translateX(-50%) translateY(-50%) rotate(45deg);
            transform: translateX(-50%) translateY(-50%) rotate(45deg);
            -webkit-transform-origin: center center;
            transform-origin: center center;
        }

        *:before, *:after {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
    </style>
</head>
<body class="" >
<section class="vbox">
    <header class="bg-white header header-md navbar navbar-fixed-top-xs box-shadow">
        <div class="navbar-header aside-дп dk">
            <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
                <i class="fa fa-bars"></i>
            </a>
            <a href="{{ url('/') }}" class="navbar-brand">
                <span class="hidden-nav-xs">Панель администратора</span>
            </a>
        </div>
        <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="thumb-sm avatar pull-left">
              {{--<img src="admin_assets/images/a0.png" alt="...">--}}
            </span>
                    {{ Auth::user()->first_name }} {{ Auth::user()->second_name }}<b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInRight">
                    <li>
                        <span class="arrow top"></span>
                        <a href="#">Settings</a>
                    </li>
                    <li>
                        <a href="profile.html">Profile</a>
                    </li>
                    <li>
                        <a href="docs.html">Help</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ url('/logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();" >Выйти</a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>

                </ul>
            </li>
        </ul>
    </header>
    <section>
        <section class="hbox stretch">
            <!-- .aside -->
            <aside class="bg-black aside-md hidden-print hidden-xs" id="nav">
                <section class="vbox">
                    <section class="w-f scrollable">
                        <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2">

                            <!-- nav -->
                            <nav class="nav-primary hidden-xs">
                                <div class="text-muted text-sm hidden-nav-xs padder m-t-sm m-b-sm">Start</div>
                                <ul class="nav nav-main" data-ride="collapse">
                                    <li
                                        @if(Request::url() == route('new_page_view')
                                        || Request::url() == route('all_page_view'))
                                        class="active"
                                        @endif
                                    >
                                        <a href="{{ route('all_page_view') }}" class="auto">
                                            <span class="pull-right text-muted">
                                              <i class="i i-circle-sm-o text"></i>
                                              <i class="i i-circle-sm text-active"></i>
                                            </span>
                                            <i class="i i-file2 icon">
                                            </i>
                                            <span class="font-bold">Страницы</span>
                                        </a>
                                        <ul class="nav dk">
                                            <li >
                                                <a href="{{ route('all_page_view') }}" class="auto">
                                                    <i class="i i-dot"></i>
                                                    <span>Все страницы</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('new_page_view') }}" class="auto">
                                                    <i class="i i-dot"></i>
                                                    <span>Новая страница</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li
                                        @if(Request::url() == route('new_cat_view')
                                        || Request::url() == route('all_cat_view'))
                                        class="active"
                                        @endif
                                    >
                                        <a href="{{ route('all_cat_view') }}" class="auto">
                                            <span class="pull-right text-muted">
                                              <i class="i i-circle-sm-o text"></i>
                                              <i class="i i-circle-sm text-active"></i>
                                            </span>
                                            <i class="i i-folder icon">
                                            </i>
                                            <span class="font-bold">Категории</span>
                                        </a>
                                        <ul class="nav dk">
                                            <li>
                                                <a href="{{ route('all_cat_view') }}" class="auto">
                                                    <i class="i i-dot"></i>
                                                    <span>Все категории</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('new_cat_view') }}" class="auto">
                                                    <i class="i i-dot"></i>
                                                    <span>Новая категория</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li
                                        @if(Request::url() == route('new_post_view')
                                        || Request::url() == route('all_post_view')
                                        || Request::url() == route('all_tag_view'))
                                        class="active"
                                        @endif
                                    >
                                        <a href="{{ route('all_post_view') }}" class="auto">
                                            <span class="pull-right text-muted">
                                              <i class="i i-circle-sm-o text"></i>
                                              <i class="i i-circle-sm text-active"></i>
                                            </span>
                                            <i class="i i-docs icon">
                                            </i>
                                            <span class="font-bold">Статьи</span>
                                        </a>
                                        <ul class="nav dk">
                                            <li>
                                                <a href="{{ route('all_post_view') }}" class="auto">
                                                    <i class="i i-dot"></i>
                                                    <span>Все статьи</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('new_post_view') }}" class="auto">
                                                    <i class="i i-dot"></i>
                                                    <span>Новая статья</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('all_tag_view') }}" class="auto">
                                                    <i class="i i-dot"></i>
                                                    <span>Метки</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li
                                        @if(Request::url() == url('/adminpanel/media'))
                                        class="active"
                                        @endif
                                    >
                                        <a href="{{ url('/adminpanel/media') }}" class="auto">
                                            <span class="pull-right text-muted">
                                              <i class="i i-circle-sm-o text"></i>
                                              <i class="i i-circle-sm text-active"></i>
                                            </span>
                                            <i class="i i-pictures icon">
                                            </i>
                                            <span class="font-bold">Медиафайлы</span>
                                        </a>
                                        <ul class="nav dk">
                                            <li class="active">
                                                <a href="{{ url('/adminpanel/media') }}" class="auto">
                                                    <i class="i i-dot"></i>
                                                    <span>Медиафайлы</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li
                                        @if(Request::url() == route('all_user_view')
                                            || Request::url() == route('new_user_view'))
                                        class="active"
                                        @endif
                                    >
                                        <a href="{{ route('all_user_view') }}" class="auto">
                                            <span class="pull-right text-muted">
                                              <i class="i i-circle-sm-o text"></i>
                                              <i class="i i-circle-sm text-active"></i>
                                            </span>
                                            <i class="i i-users3 icon">
                                            </i>
                                            <span class="font-bold">Пользователи</span>
                                        </a>
                                        <ul class="nav dk">
                                            <li>
                                                <a href="{{ route('all_user_view') }}" class="auto">
                                                    <i class="i i-dot"></i>
                                                    <span>Все пользователи</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('new_user_view') }}" class="auto">
                                                    <i class="i i-dot"></i>
                                                    <span>Новый пользователь</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li
                                        @if(Request::url() == url('/adminpanel/wpimporter'))
                                        class="active"
                                        @endif
                                    >
                                        <a href="#" class="auto">
                                            <span class="pull-right text-muted">
                                              <i class="i i-circle-sm-o text"></i>
                                              <i class="i i-circle-sm text-active"></i>
                                            </span>
                                            <i class="i i-paperclip icon">
                                            </i>
                                            <span class="font-bold">Расширения</span>
                                        </a>
                                        <ul class="nav dk">
                                            <li class="active">
                                                <a href="{{ url('/adminpanel/wpimporter') }}" class="auto">
                                                    <i class="fa fa-wordpress"></i>
                                                    <span>WordPress Importer</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <div class="line dk hidden-nav-xs"></div>
                            </nav>
                            <!-- / nav -->
                        </div>
                    </section>

                    <footer class="footer hidden-xs no-padder text-center-nav-xs">
                        <a href="modal.lockme.html" data-toggle="ajaxModal" class="btn btn-icon icon-muted btn-inactive pull-right m-l-xs m-r-xs hidden-nav-xs">
                            <i class="i i-logout"></i>
                        </a>
                        <a href="#nav" data-toggle="class:nav-xs" class="btn btn-icon icon-muted btn-inactive m-l-xs m-r-xs">
                            <i class="i i-circleleft text"></i>
                            <i class="i i-circleright text-active"></i>
                        </a>
                    </footer>
                </section>
            </aside>
            <!-- /.aside -->
            <section id="content">
                <section class="hbox stretch">
                    <section>
                        <section class="vbox">
                            <section class="scrollable padder">
                                <section class="row m-b-md">
                                    <div class="col-sm-12">
                                        <h3 class="m-b-xs text-black">@yield('header')</h3>
                                    </div>
                                </section>
                                <div class="row">
                                    @yield('content')
                                </div>
                            </section>
                        </section>
                    </section>
                </section>
                <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
            </section>
        </section>
    </section>
</section>
@yield('media-block')
<script src="{{ asset('admin_assets/js/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{ asset('admin_assets/js/bootstrap.js')}}"></script>
<!-- datepicker -->
<script src="{{ asset('admin_assets/js/datepicker/bootstrap-datepicker.js')}}"></script>
<!-- slider -->
<script src="{{ asset('admin_assets/js/slider/bootstrap-slider.js')}}"></script>
<!-- file input -->
<script src="{{ asset('admin_assets/js/file-input/bootstrap-filestyle.min.js')}}"></script>
<!-- wysiwyg -->
<script src="{{ asset('admin_assets/js/wysiwyg/jquery.hotkeys.js')}}"></script>
<script src="{{ asset('admin_assets/js/wysiwyg/bootstrap-wysiwyg.js')}}"></script>
<script src="{{ asset('admin_assets/js/wysiwyg/demo.js')}}"></script>
<!-- App -->
<script src="{{ asset('admin_assets/js/app.js')}}"></script>
<script src="{{ asset('admin_assets/js/slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{ asset('admin_assets/js/charts/easypiechart/jquery.easy-pie-chart.js')}}"></script>
<script src="{{ asset('admin_assets/js/charts/sparkline/jquery.sparkline.min.js')}}"></script>
<script src="{{ asset('admin_assets/js/charts/flot/jquery.flot.min.js')}}"></script>
<script src="{{ asset('admin_assets/js/charts/flot/jquery.flot.tooltip.min.js')}}"></script>
<script src="{{ asset('admin_assets/js/charts/flot/jquery.flot.spline.js')}}"></script>
<script src="{{ asset('admin_assets/js/charts/flot/jquery.flot.pie.min.js')}}"></script>
<script src="{{ asset('admin_assets/js/charts/flot/jquery.flot.resize.js')}}"></script>
<script src="{{ asset('admin_assets/js/charts/flot/jquery.flot.grow.js')}}"></script>
<script src="{{ asset('admin_assets/js/charts/flot/demo.js')}}"></script>

<script src="{{ asset('admin_assets/js/chosen/chosen.jquery.min.js')}}"></script>
<script src="{{ asset('admin_assets/js/spinner/jquery.bootstrap-touchspin.min.js')}}"></script>
<script src="{{ asset('admin_assets/js/calendar/bootstrap_calendar.js')}}"></script>
<script src="{{ asset('admin_assets/js/calendar/demo.js')}}"></script>

<script src="{{ asset('admin_assets/js/sortable/jquery.sortable.js')}}"></script>
<script src="{{ asset('admin_assets/js/app.plugin.js')}}"></script>

<script src="{{ asset('admin_assets/js/lity.min.js')}}"></script>
<script src="{{ asset('admin_assets/js/lodash.min.js')}}"></script>

<script src="{{ asset('admin_assets/js/custom.js')}}"></script>
<script src="{{ asset('js/vue.js') }}"></script>
@yield('scripts.footer')

</body>
</html>