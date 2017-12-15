@extends('adminpanel.admin-layout')
@section('header','Категория - "'.$cat->cat_title.'"')
@section('content')

    @if($code == 1)
        <div class="col-sm-12">
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <i class="fa fa-ok-sign"></i>Категория успешно сохранена !</a>
        </div>
        </div>
    @endif
    <form class="form-horizontal" method="POST" action="{{ route('edit_cat_action') }}">
        <input name="_method" type="hidden" value="PUT">
        <input name="_token" type="hidden" value="{{ csrf_token() }}">
        <input name="cat_id" type="hidden" value="{{ $cat->cat_id }}">
        <div class="col-sm-8">
            <section class="panel panel-default">
                <header class="panel-heading font-bold">
                    <ul class="nav nav-pills pull-right">
                        <li>
                            <a href="#" class="panel-toggle text-muted">
                                <i class="fa fa-caret-down text-active"></i>
                                <i class="fa fa-caret-up text"></i>
                            </a>
                        </li>
                    </ul>
                    Основные параметры категории
                </header>
                <div class="panel-body">
                    <div class="form-group @if($errors->has('cat_title')) has-error  @endif">
                        <label for="cat_title_id" class="col-sm-2 control-label">Заголовок:</label>
                        <div class="col-sm-10">
                            <input type="text" id="cat_title_id" name="cat_title" class="form-control" required value="{{ $cat->cat_title }}">
                            <span class="help-block m-b-none">Введите заголовок категории.</span>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group @if($errors->has('cat_slug')) has-error  @endif">
                        <label for="cat_slug_id" class="col-sm-2 control-label">Ярлык:</label>
                        <div class="col-sm-10">
                            <input type="text" id="cat_slug_id" name="cat_slug" class="form-control"
                                   required value="{{ $cat->cat_slug }}" pattern="^[a-zA-Z0-9\-]+$">
                            <span class="help-block m-b-none">Введите ярлык категории.</span>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group @if($errors->has('cat_content')) has-error  @endif">
                        <label for="cat_content_id" class="col-sm-2 control-label">Текст категории</label>
                        <div class="col-sm-10">
                            <textarea id="cat_content_id" name="cat_content" class="form-control" style="overflow:scroll;height:150px;max-height:150px">{{ $cat->cat_content }}</textarea>
                            @ckeditor('cat_content_id')
                        </div>
                    </div>
                </div>
            </section>
            <section class="panel panel-default">
                <header class="panel-heading font-bold">
                    <ul class="nav nav-pills pull-right">
                        <li>
                            <a href="#" class="panel-toggle text-muted">
                                <i class="fa fa-caret-down text-active"></i>
                                <i class="fa fa-caret-up text"></i>
                            </a>
                        </li>
                    </ul>
                    Сео опции
                </header>
                <div class="panel-body">
                    <div class="form-group @if($errors->has('meta_keywords')) has-error  @endif">
                        <label for="meta_keywords_id" class="col-sm-2 control-label">Мета тег Keywords:</label>
                        <div class="col-sm-10">
                            <input type="text" id="meta_keywords_id" name="meta_keywords" class="form-control" value="{{ $cat->meta_keywords }}">
                            <span class="help-block m-b-none">Введите мета тег Keywords.</span>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group @if($errors->has('meta_description')) has-error  @endif">
                        <label for="meta_description_id" class="col-sm-2 control-label">Мета тег Description:</label>
                        <div class="col-sm-10">
                            <input type="text" id="meta_description_id" name="meta_description" class="form-control" value="{{ $cat->meta_description }}">
                            <span class="help-block m-b-none">Введите мета тег Description.</span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-sm-4">
            <section class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Статус</label>
                        <div class="col-sm-10">
                            <select name="cat_status" class="form-control m-b">
                                <option value="draft" @if($cat->cat_status === 'draft') selected  @endif>Черновик</option>
                                <option value="publish" @if($cat->cat_status === 'publish') selected  @endif>Опубликовать</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Родительская категория</label>
                        <div class="col-sm-10">
                            <select name="parent_id" class="form-control m-b">
                                    <option @if($cat->parent_id == 0) selected @endif value="0">Не выбрано</option>
                                    @foreach($categories as $cat_item)
                                        <option
                                                @if($cat->parent_id == $cat_item->cat_id) selected @endif value="{{ $cat_item->cat_id }}"
                                                @if($cat->cat_id == $cat_item->cat_id) disabled @endif value="{{ $cat_item->cat_id }}"
                                        >{{ $cat_item->_prefix().$cat_item->cat_title }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <a href="{{ url('/adminpanel/newcat') }}" >
                                <span>Новая категория</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <section class="panel panel-default">
                <header class="panel-heading font-bold">Миниатюра</header>
                <div class="panel-body">
                    <div class="form-group">
                            <div class="col-sm-12">
                                @if($cat->cat_thumbnail)
                                    <img id="media-src" src="{{ url($cat->thumbnail()) }}" alt="">
                                @else
                                    <img id="media-src" src="" alt="">
                                @endif
                            </div>
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Добавить/Изменить</button>
                            </div>
                            <input type="hidden" id="media-field" name="cat_thumbnail" value="{{ $cat->cat_thumbnail }}">
                    </div>
                </div>
            </section>
        </div>
    </form>
@endsection
@section('scripts.footer')
    @include('adminpanel.media.popup')
@endsection