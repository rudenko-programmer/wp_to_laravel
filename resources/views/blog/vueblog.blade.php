@extends('blog.layout')
@section('content')
    <div class="row" id="blog_loop">
        <!-- Blog Posts
        ================================================== -->
        <div class="span6 blog" >

        @foreach($posts as $post)
            <!-- Blog Post 1 -->
                <single-article
                    title="{{ $post->post_title }}"
                    excerpt="{{ $post->excerpt() }}"
                    thumbnail="{{ url($post->thumbnail()) }}"
                    date="{{ $post->created_at->format('Y/m/d') }}"
                    author="{{ $post->author->first_name }}"
                    url="{{ $post->url() }}"
                >
                </single-article>
        @endforeach
        </div>

        <!-- Blog Sidebar
        ================================================== -->
        <div class="span6 blog">
            <posts></posts>
        </div>
    </div>
@endsection
@section('footer')
    <template id="article-template">
        <div>
            <article v-for="post in posts" class="clearfix"  >
                <a v-if="post.thumbnail" :href="post.url">
                    <img :src="post.thumbnail" alt="Post Thumb" class="align-left">
                </a>
                <h4 class="title-bg">
                    <a :href="post.url" v-text="post.title"></a>
                </h4>
                <p v-text="post.except"></p>
                <a :href="post.url" class="btn btn-mini btn-inverse" type="button">Читать далее</a>
                <div class="post-summary-footer">
                    <ul class="post-data-3">
                        <li><i class="icon-calendar"></i>@{{ post.date }}</li>
                        <li><i class="icon-user"></i> <a href="#" v-text="post.author"></a></li>
                        <li style="width:45%"><i class="icon-tags"></i>
                                <a v-for="tag in post.tags" :href="tag.url" v-text="tag.title"></a>
                        </li>
                    </ul>
                </div>
            </article>
        </div>
    </template>
    <template id="single-article-template">
            <article class="clearfix"  >
                <a v-if="thumbnail" :href="url">
                    <img :src="thumbnail" alt="Post Thumb" class="align-left">
                </a>
                <h4 class="title-bg">
                    <a :href="url" v-text="title"></a>
                </h4>
                <p v-text="excerpt"></p>
                <a :href="url" class="btn btn-mini btn-inverse" type="button">Читать далее</a>
                <div class="post-summary-footer">
                    <ul class="post-data-3">
                        <li><i class="icon-calendar"></i>@{{ date }}</li>
                        <li><i class="icon-user"></i> <a href="#" v-text="author"></a></li>
                    </ul>
                </div>
            </article>
    </template>

    <script>
        Vue.component('posts', {
            template: '#article-template',
            data () {
                return {
                    posts: []
                };
            },
            created: function () {
                this.getPosts();
            },
            methods: {
                getPosts: function () {
                    $.getJSON("{{ route('get_posts') }}", function(posts){
                        this.posts = posts;
                    }.bind(this));
                }
            }
        });
        Vue.component('single-article', {
            template: '#single-article-template',
            props:['title', 'excerpt', 'thumbnail', 'date', 'author', 'url'],
        });
        new Vue({
            el: '#blog_loop'
        });
    </script>
@endsection