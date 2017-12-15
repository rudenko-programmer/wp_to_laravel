@extends('adminpanel.admin-layout')
@section('header','Корзина страниц')
@section('content')
    <div class="col-sm-12">
        <section class="panel panel-default">
            <form id="all-post-form" action="{{ route('delete_chose_page') }}" method="POST">
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
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th width="20"><label class="checkbox m-l m-t-none m-b-none i-checks"><input type="checkbox"><i></i></label></th>
                        <th>Заголовок</th>
                        <th width="30">Ярлык</th>
                        <th>Миниатюра</th>
                        <th>Автор</th>
                        <th>Дата</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pages as $page)
                    <tr>
                        <td><label class="checkbox m-l m-t-none m-b-none i-checks"><input type="checkbox" class="chose_el" name="page[]" value="{{ $page->page_id }}"><i></i></label></td>
                        <td>
                            <p class="row-title">
                                <a href="{{ route("edit_page_view", array('page_id'=>$page->page_id)) }}">
                                    {{ $page->page_title }}
                                </a>
                            </p>
                            <div>
                                <ul class="row-property">
                                    <li><a href="{{ route("edit_page_view", array('page_id'=>$page->page_id)) }}">Изменить</a></li>
                                    <li><a href="#page_del_{{$page->page_id}}" class="page_del_link del-link">Удалить</a></li>
                                    <li><a href="#restore_{{$page->page_id}}" class="restore_link">Востановить</a></li>
                                </ul>
                            </div>

                        </td>
                        <td>{{ $page->page_slug }}</td>
                        <td>
                            <div class="table-img-box">
                                @if($page->page_thumbnail)
                                    <img src="{{ url($page->thumbnail()) }}" alt="">
                                @endif
                            </div>
                        </td>
                        <td>{{ $page->author->first_name }}</td>
                        <td>{{ $page->created_at->format('Y-m-d') }}</td>
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
    @foreach($pages as $page)
        <form method="POST" id="page_del_{{$page->page_id}}" action="{{ route('delete_page',['page_id' => $page->page_id]) }}" accept-charset="UTF-8" style="display: none;" >
            <input name="_method" type="hidden" value="DELETE">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
        </form>
        <form method="POST" id="restore_{{$page->page_id}}" action="{{ route('restore_page',['page_id' => $page->page_id]) }}" accept-charset="UTF-8" style="display: none;" >
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
        </form>
    @endforeach
@endsection