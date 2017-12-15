@extends('adminpanel.admin-layout')
@section('header','Новая страница')
@section('content')
    <form class="form-horizontal" method="POST" action="{{ route('create_page_action') }}">
    <input name="_token" type="hidden" value="{{ csrf_token() }}">
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
                Основные параметры страници
            </header>
            <div class="panel-body">
                    <div class="form-group @if($errors->has('page_title')) has-error  @endif">
                        <label for="page_title_id" class="col-sm-2 control-label">Заголовок:</label>
                        <div class="col-sm-10">
                            <input type="text" id="page_title_id" name="page_title" class="form-control" required value="{{ old('page_title') }}">
                            <span class="help-block m-b-none">Введите заголовок страници.</span>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group @if($errors->has('page_slug')) has-error  @endif">
                        <label for="page_slug_id" class="col-sm-2 control-label">Ярлык:</label>
                        <div class="col-sm-10">
                            <input type="text" id="page_slug_id" name="page_slug" class="form-control" required value="{{ old('page_slug') }}">
                            <span class="help-block m-b-none">Введите ярлык страници.</span>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group @if($errors->has('page_content')) has-error  @endif">
                        <label for="page_content_id" class="col-sm-2 control-label">Текст страници</label>
                        <div class="col-sm-10">
                            <textarea id="page_content_id" name="page_content" class="form-control" style="overflow:scroll;height:150px;max-height:150px">{{ old('page_content') }}</textarea>
                            @ckeditor('page_content_id')
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
                            <input type="text" id="meta_keywords_id" name="meta_keywords" class="form-control" value="{{ old('meta_keywords') }}">
                            <span class="help-block m-b-none">Введите мета тег Keywords.</span>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group @if($errors->has('meta_description')) has-error  @endif">
                        <label for="meta_description_id" class="col-sm-2 control-label">Мета тег Description:</label>
                        <div class="col-sm-10">
                            <input type="text" id="meta_description_id" name="meta_description" class="form-control" value="{{ old('meta_description') }}">
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
                            <select name="page_status" class="form-control m-b">
                                <option value="draft" {{ selected('draft', old('page_status')) }}>Черновик</option>
                                <option value="publish" {{ selected('publish', old('page_status')) }}>Опубликовать</option>
                            </select>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                        </div>
                    </div>
            </div>
        </section>
        <section class="panel panel-default">
            <header class="panel-heading font-bold">Миниатюра</header>
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        <img id="media-src" src="" alt="">
                    </div>
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Добавить/Изменить</button>
                    </div>
                    <input type="hidden" id="media-field" name="page_thumbnail" value="">
                </div>
            </div>
        </section>
    </div>
    </form>
@endsection
@section('scripts.footer')
    @include('adminpanel.media.popup')
@endsection