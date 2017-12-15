@extends('adminpanel.admin-layout')
@section('header','Все пользователи')
@section('content')
    <div class="col-sm-12">
        <section class="panel panel-default">
            <form id="all-post-form" action="" method="POST">
                {!! csrf_field() !!}
                <input type='hidden' name='_method' value='DELETE'>
                <div class="row wrapper">
                    <div class="col-sm-5 m-b-xs">
                        <select  id="chose_select" name="_method" class="input-sm form-control input-s-lg inline v-middle">
                            <option value="">Выберите действие</option>
                            <option value="DELETE">В корзину выбраные</option>
                        </select>
                        <button class="btn btn-sm btn-default">Подтвердить</button>
                    </div>
                    <div class="col-sm-5 m-b-xs">
                        <a href="" class="btn btn-sm btn-default"><i class="i i-trashcan"></i> Корзина</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped b-t b-light">
                        <thead>
                        <tr>
                            <th width="20"><label class="checkbox m-l m-t-none m-b-none i-checks"><input type="checkbox"><i></i></label></th>
                            <th width="" >Ф.И.О.</th>
                            <th width="30%">Логин</th>
                            <th>Email</th>
                            <th>Миниатюра</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td><label class="checkbox m-l m-t-none m-b-none i-checks"><input type="checkbox" class="chose_el" name="post[]" value="{{ $user->user_id }}"><i></i></label></td>
                                <td>
                                    <p class="row-title">
                                        <a href="{{ route('edit_user_view', array('user_id' => $user->user_id)) }}">
                                            {{ $user->fullName() }}
                                        </a>
                                    </p>
                                    <div>
                                        <ul class="row-property">
                                            <li><a href="{{ route('edit_user_view', array('user_id' => $user->user_id)) }}">Изменить</a></li>
                                            <li><a href="#post_del_{{$user->user_id}}" class="post_del_link del-link">Удалить</a></li>
                                            <li><a href="">Просмотреть</a></li>
                                        </ul>
                                    </div>

                                </td>
                                <td>{{ $user->login }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="table-img-box">
                                        @if($user->user_thumbnail)
                                            <img src="{{ url($user->thumbnail()) }}" alt="">
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{--<footer class="panel-footer">
                    <div class="row">
                        <div class="col-sm-6 text-center">
                            <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                        </div>
                        <div class="col-sm-6 text-right text-center-xs">
                            <ul class="pagination pagination-sm m-t-none m-b-none">
                                <li><a href="#"><i class="fa fa-chevron-left"></i></a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#"><i class="fa fa-chevron-right"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </footer>--}}
            </form>
        </section>
    </div>
    @foreach($users as $user)
        <form method="POST" id="user_del_{{$user->user_id}}" action="{{--{{ route('to_trash_post',['post_id' => $post->post_id]) }}--}}" accept-charset="UTF-8" style="display: none;" >
            <input name="_method" type="hidden" value="DELETE">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
        </form>
    @endforeach
@endsection