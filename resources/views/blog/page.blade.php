@extends('blog.layout')

@section('menu.before')
<li class="active"><a>{{ $page->page_title }}</a></li>
@endsection

@section('content')
<div class="row">

        <!-- Blog Full Post
        ================================================== -->
        <div class="span8 blog">

            <!-- Blog Post 1 -->
            <article>
                <h3 class="title-bg">{{ $page->page_title }}</h3>
                <div class="post-content">
                    @if($page->page_thumbnail != '')
                    <img src="{{ url($page->img()) }}" alt="{{ $page->page_title }}">
                    @endif
                    <div class="post-body">{!! $page->page_content !!}</div>

                    <div class="post-summary-footer">
                        <ul class="post-data">
                            <li><i class="icon-calendar"></i> {{ $page->created_at->format('Y/m/d') }}</li>
                            <li><i class="icon-user"></i> <a href="#">{{ $page->author->first_name }}</a></li>
                        </ul>
                    </div>
                </div>
            </article>

</div><!--Close container row-->
        <!-- Blog Sidebar
        ================================================== -->
        @include('blog.sidebar')

</div>
@endsection