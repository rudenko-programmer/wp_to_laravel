@extends('blog.layout')

@section('head')
    <link rel="amphtml" href="{{ route('amp_single_blog_page',array('post_slug'=>$post->post_slug)) }}" />
@endsection

@section('menu.before')
<li class="active"><a>{{ $post->post_title }}</a></li>
@endsection

@section('content')
<div class="row">

        <!-- Blog Full Post
        ================================================== -->
        <div class="span8 blog">

            <!-- Blog Post 1 -->
            <article>
                <h3 class="title-bg">{{ $post->post_title }}</h3>
                <div class="post-content">
                    @if($post->post_thumbnail != '')
                    <img src="{{ url($post->img()) }}" alt="{{ $post->post_title }}">
                    @endif
                    <div class="post-body">{!! $post->post_content !!}</div>

                    <div class="post-summary-footer">
                        <ul class="post-data">
                            <li><i class="icon-calendar"></i> {{ $post->created_at->format('Y/m/d') }}</li>
                            <li><i class="icon-user"></i> <a href="#">{{ $post->author->first_name }}</a></li>
                            <li><i class="icon-tags"></i>
                                @foreach($post->tags as $tag)
                                    <a href="{{ route('tag_page',['tag_slug'=>$tag->tag_slug]) }}"> {{ $tag->tag_title }}</a>
                                @endforeach
                            </li>
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