@extends('blog.layout')
@section('content')
<div class="row">

        <!-- Blog Full Post
        ================================================== -->
        <div class="span8 blog">

            <!-- Blog Post 1 -->
            <article>
                <h3 class="title-bg">{{ $category->cat_title }}</h3>
                <div class="post-content">
                    @if($category->post_thumbnail != '')
                    <img src="{{ url($category->img()) }}" alt="{{ $category->cat_title }}">
                    @endif
                    <div class="post-body">{!! $category->cat_content !!}</div>
                </div>
            </article>

            @foreach($posts as $post)
            <!-- Blog Post 1 -->
                <article class="clearfix">
                    @if($post->post_thumbnail)
                        <a href="{{ $post->url() }}">
                            <img src="{{ url($post->thumbnail()) }}" alt="Post Thumb" class="align-left">
                        </a>
                    @endif
                    <h4 class="title-bg">
                        <a href="{{ $post->url() }}">
                            {{ $post->post_title }}
                        </a>
                    </h4>
                    <p>{{ $post->excerpt() }}</p>
                    <a href="{{ $post->url() }}" class="btn btn-mini btn-inverse" type="button">Читать далее</a>
                    <div class="post-summary-footer">
                        <ul class="post-data-3">
                            <li><i class="icon-calendar"></i> {{ $post->created_at->format('Y/m/d') }}</li>
                            <li><i class="icon-user"></i> <a href="#">{{ $post->author->first_name }}</a></li>
                            <li style="width:45%"><i class="icon-tags"></i>
                                @foreach($post->tags as $tag)
                                    <a href="{{ route('tag_page',['tag_slug'=>$tag->tag_slug]) }}"> {{ $tag->tag_title }}</a>
                                @endforeach
                            </li>
                        </ul>
                    </div>
                </article>
            @endforeach
            <!-- Pagination -->
            <div class="pagination">
                {{ $posts->render() }}
            </div>

</div><!--Close container row-->
        <!-- Blog Sidebar
        ================================================== -->
        @include('blog.sidebar')

</div>
@endsection