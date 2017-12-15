@extends('adminpanel.admin-layout')
@section('header','Все категории')
@section('content')
    <div class="col-sm-12">
        <section class="panel panel-default">
            <form id="all-post-form" action="{{ route('to_trash_chose_cat') }}" method="POST">
                {!! csrf_field() !!}
                <input type='hidden' name='_method' value='DELETE'>
                <div class="row wrapper">
                    <div class="col-sm-5 m-b-xs">
                        <select  id="chose_select" name="_method" class="input-sm form-control input-s-lg inline v-middle">
                            <option value="">Выберите действие</option>
                            <option value="DELETE">Удалить выбраные</option>
                        </select>
                        <button class="btn btn-sm btn-default">Подтвердить</button>
                    </div>
                    <div class="col-sm-5 m-b-xs">
                        <a href="{{ route('trash_cat_view') }}" class="btn btn-sm btn-default"><i class="i i-trashcan"></i> Корзина</a>
                    </div>
                </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light"  style="table-layout: fixed; word-wrap: break-word">
                    <thead>
                    <tr>
                        <th width="20"><label class="checkbox m-l m-t-none m-b-none i-checks"><input type="checkbox"><i></i></label></th>
                        <th width="35%">Заголовок</th>
                        <th width="25%">Ярлык</th>
                        <th>Миниатюра</th>
                        <th>Дата</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $cat)
                        <tr>
                            <td><label class="checkbox m-l m-t-none m-b-none i-checks"><input class="chose_el" type="checkbox" name="cat[]" value="{{$cat->cat_id}}"><i></i></label></td>
                            <td>
                                <p class="row-title">
                                    <a href="{{ route('edit_cat_view', array('cat_id'=>$cat->cat_id)) }}">
                                        {{ $cat->_prefix().$cat->cat_title }}
                                    </a>
                                </p>
                                <div>
                                    <ul class="row-property">
                                        <li><a href="{{ route('edit_cat_view', array('cat_id'=>$cat->cat_id)) }}">Изменить</a></li>
                                        <li><a href="#cat_del_{{$cat->cat_id}}" class="cat_del_link del-link">В корзину</a></li>
                                        <li><a href="{{ route('cat_page', ['cut_slug' => $cat->cat_slug]) }}">Просмотреть</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td width="30%">{{ $cat->cat_slug }}</td>
                            <td>
                                <div class="table-img-box">
                                    @if($cat->cat_thumbnail)
                                        <img src="{{ url($cat->thumbnail()) }}" alt="">
                                    @endif
                                </div>
                            </td>
                            <td>{{ $cat->created_at->format('Y-m-d') }}</td>
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
    @foreach($categories as $cat)
        <form method="POST" id="cat_del_{{$cat->cat_id}}" action="{{ route('to_trash_cat',['cat_id' => $cat->cat_id]) }}" accept-charset="UTF-8" style="display: none;" >
            <input name="_method" type="hidden" value="DELETE">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
        </form>
    @endforeach
@endsection