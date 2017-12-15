@extends('adminpanel.admin-layout')
@section('header','Главная страница')
@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="panel b-a">
                <div class="row m-n">
                    <div class="col-md-6 b-b b-r">
                        <a href="#" class="block padder-v hover">
                              <span class="i-s i-s-2x pull-left m-r-sm">
                                <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i>
                                <i class="i i-file2 i-1x text-white"></i>
                              </span>
                              <span class="clear">
                                <span class="h3 block m-t-xs text-danger">{{ $page }}</span>
                                <small class="text-muted text-u-c">Страниц</small>
                              </span>
                        </a>
                    </div>
                    <div class="col-md-6 b-b">
                        <a href="#" class="block padder-v hover">
                              <span class="i-s i-s-2x pull-left m-r-sm">
                                <i class="i i-hexagon2 i-s-base text-success-lt hover-rotate"></i>
                                <i class="i i-docs i-sm text-white"></i>
                              </span>
                              <span class="clear">
                                <span class="h3 block m-t-xs text-success">{{ $post }}</span>
                                <small class="text-muted text-u-c">Статей</small>
                              </span>
                        </a>
                    </div>
                    <div class="col-md-6 b-b b-r">
                        <a href="#" class="block padder-v hover">
                              <span class="i-s i-s-2x pull-left m-r-sm">
                                <i class="i i-hexagon2 i-s-base text-info hover-rotate"></i>
                                <i class="i i-folder i-sm text-white"></i>
                              </span>
                              <span class="clear">
                                <span class="h3 block m-t-xs text-info">{{ $cat }}</span>
                                <small class="text-muted text-u-c">Категорий</small>
                              </span>
                        </a>
                    </div>
                    <div class="col-md-6 b-b">
                        <a href="#" class="block padder-v hover">
                              <span class="i-s i-s-2x pull-left m-r-sm">
                                <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                                <i class="i i-images i-sm text-white"></i>
                              </span>
                              <span class="clear">
                                <span class="h3 block m-t-xs text-primary">{{ $media }}</span>
                                <small class="text-muted text-u-c">Медиафайлов</small>
                              </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection