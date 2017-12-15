@extends('blog.layout')
@section('content')
    <div class="row">
        <!-- Blog Posts
        ================================================== -->
        <div class="span8 blog">
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
        </div>

        <!-- Blog Sidebar
        ================================================== -->
        @include('blog.sidebar')

    </div>
@endsection