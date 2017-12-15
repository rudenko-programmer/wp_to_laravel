@extends('adminpanel.admin-layout')
@section('header','Метки')
@section('content')
    <div class="col-sm-5">
        <section class="panel panel-default">
            <form class="form-horizontal" method="POST" action="{{ route('new_tag_action') }}">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <header class="panel-heading font-bold">Новая метка</header>
                <div class="panel-body">
                    <div class="form-group @if($errors->has('tag_title')) has-error  @endif">
                        <label for="tag_title_id" class="col-sm-2 control-label">Название:</label>
                        <div class="col-sm-10">
                            <input type="text" id="tag_title_id" name="tag_title" class="form-control" required value="{{ old('tag_title') }}">
                            <span class="help-block m-b-none">Введите название Метки.</span>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group @if($errors->has('tag_slug')) has-error  @endif">
                        <label for="tag_slug_id" class="col-sm-2 control-label">Ярлык:</label>
                        <div class="col-sm-10">
                            <input type="text" id="tag_slug_id" name="tag_slug" class="form-control" value="{{ old('tag_slug') }}">
                            <span class="help-block m-b-none">Введите ярлык метки.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary">Добавить метку</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
    <div class="col-sm-7">
        <section class="panel panel-default">
            <form id="all-post-form" action="{{ route('delete_chose_tag') }}" method="POST">
                {!! csrf_field() !!}
                <input type='hidden' name='_method' value='DELETE'>

            <div class="row wrapper">
                <div class="">
                    <div class="col-sm-6 text-left">
                        {{ $tags->render() }}
                    </div>

                </div>
                <div class="col-sm-12 m-b-xs">
                    <select  id="chose_select" name="_method" class="input-sm form-control input-s-lg inline v-middle">
                        <option value="">Выберите действие</option>
                        <option value="DELETE">Удалить выбраные</option>
                    </select>
                    <button class="btn btn-sm btn-default">Подтвердить</button>
                    <small class="text-muted inline m-t-sm m-b-sm"> Выводится {{ $tags->firstItem() }}-{{ $tags->lastItem() }} из {{ $tags->total() }} елементов</small>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light"  style="table-layout: fixed; word-wrap: break-word">
                    <thead>
                    <tr>
                        <th width="20"><label class="checkbox m-l m-t-none m-b-none i-checks"><input type="checkbox"><i></i></label></th>
                        <th>Заголовок</th>
                        <th>Ярлык</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tags as $tag)
                    <tr>
                        <td><label class="checkbox m-l m-t-none m-b-none i-checks"><input type="checkbox" class="chose_el" name="tag[]" value="{{ $tag->tag_id }}"><i></i></label></td>
                        <td>
                            <p class="row-title">
                                {{ $tag->tag_title }}
                            </p>
                            <div>
                                <ul class="row-property">
                                    <li><a href="#tag_del_{{$tag->tag_id}}" class="tag_del_link del-link">Удалить</a></li>
                                </ul>
                            </div>

                        </td>
                        <td>{{ $tag->tag_slug }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-xs-12 text-left">
                            {{ $tags->render() }}
                        </div>
                    </div>
                </footer>
            </form>
        </section>
    </div>
    @foreach($tags as $tag)
        <form method="POST" id="tag_del_{{$tag->tag_id}}" action="{{ route('delete_tag',['tag_id' => $tag->tag_id]) }}" accept-charset="UTF-8" style="display: none;" >
            <input name="_method" type="hidden" value="DELETE">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
        </form>
    @endforeach
@endsection