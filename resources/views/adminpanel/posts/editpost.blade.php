@extends('adminpanel.admin-layout')

@section('head')
    <link rel="stylesheet" href="{{ asset('admin_assets/css/choices.min.css')}}" type="text/css" />
@endsection

@section('header',$post->post_title)

@section('content')

    @if($code == 1)
        <div class="col-sm-12">
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <i class="fa fa-ok-sign"></i>Статья успешно сохранена !</a>
        </div>
        </div>
    @endif
    <form class="form-horizontal" method="POST" action="{{ route('edit_post_action') }}">
        <input name="_method" type="hidden" value="PUT">
        <input name="_token" type="hidden" value="{{ csrf_token() }}">
        <input name="post_id" type="hidden" value="{{ $post->post_id }}">
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
                    Основные параметры статьи
                </header>
                <div class="panel-body">
                    <div class="form-group @if($errors->has('post_title')) has-error  @endif">
                        <label for="post_title_id" class="col-sm-2 control-label">Заголовок:</label>
                        <div class="col-sm-10">
                            <input type="text" id="post_title_id" name="post_title" class="form-control" required value="{{ $post->post_title }}">
                            <span class="help-block m-b-none">Введите заголовок статьи.</span>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group @if($errors->has('post_slug')) has-error  @endif">
                        <label for="post_slug_id" class="col-sm-2 control-label">Ярлык:</label>
                        <div class="col-sm-10">
                            <input type="text" id="post_slug_id" name="post_slug" class="form-control" required value="{{ $post->post_slug }}">
                            <span class="help-block m-b-none">Введите ярлык статьи.</span>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group @if($errors->has('post_content')) has-error  @endif">
                        <label for="post_content_id" class="col-sm-2 control-label">Текст статьи</label>
                        <div class="col-sm-10">
                            <textarea id="post_content_id" name="post_content" class="form-control" style="overflow:scroll;height:150px;max-height:150px">{{ $post->post_content }}</textarea>
                            @ckeditor('post_content_id')
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
                            <input type="text" id="meta_keywords_id" name="meta_keywords" class="form-control" value="{{ $post->meta_keywords }}">
                            <span class="help-block m-b-none">Введите мета тег Keywords.</span>
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group @if($errors->has('meta_description')) has-error  @endif">
                        <label for="meta_description_id" class="col-sm-2 control-label">Мета тег Description:</label>
                        <div class="col-sm-10">
                            <input type="text" id="meta_description_id" name="meta_description" class="form-control" value="{{ $post->meta_description }}">
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
                            <select name="post_status" class="form-control m-b">
                                <option value="draft" {{ selected('draft', $post->post_status) }}>Черновик</option>
                                <option value="publish" {{ selected('publish', $post->post_status) }}>Опубликовать</option>
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
                            <a href="{{ route('new_post_view') }}" >
                                <span>Новая статья</span>
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
                            @if($post->post_thumbnail)
                                <img id="media-src" src="{{ url($post->thumbnail()) }}" alt="">
                            @else
                                <img id="media-src" src="" alt="">
                            @endif
                        </div>
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Добавить/Изменить</button>
                        </div>
                        <input type="hidden" id="media-field" name="post_thumbnail" value="{{ $post->post_thumbnail }}">
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
                    Метки
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <select name="post_tags[]" multiple="multiple" id="tag-select">
                            </select>
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
                    Категории
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-sm-12">
                            @foreach($categories as $cat)
                                <div class="checkbox i-checks" style="width:90%; float: left">
                                    <label>
                                        <input type="checkbox" @if(in_array($cat->cat_id ,$selectcategories)) checked @endif name="post_categories[]" value="{{ $cat->cat_id }}">
                                        <i></i>
                                        {{ $cat->_prefix().$cat->cat_title }}
                                        <input type="radio" class="main_cat_input" name="main_cat" {{ checked($post->main_cat, $cat->cat_id) }} id="main-category-{{ $cat->cat_id }}" value="{{ $cat->cat_id }}">
                                        <label for="main-category-{{ $cat->cat_id }}"><span class="is_main_cat">Сделать основной</span><span class="main_cat">Основная</span></label>
                                    </label>
                                </div>

                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </form>
@endsection
@section('scripts.footer')
    <script src="{{ asset('admin_assets/js/choices.min.js')}}"></script>
    <script>
        $(document).ready(function() {

            new Choices('#tag-select', {
                search: true,
                removeItemButton: true,
                choices: [
                    @foreach($tags as $tag)
                    {value: '{{ $tag->tag_id }}', label: '{{ $tag->tag_title }}', @if(in_array($tag->tag_id ,$selecttags)) selected: true @endif },
                    @endforeach
                ],
            });
        });
    </script>
    @include('adminpanel.media.popup')
@endsection