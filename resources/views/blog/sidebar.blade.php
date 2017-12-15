<div class="span4 sidebar">
    <!--Categories-->
    <h5 class="title-bg" style="margin-top: 0">Категории</h5>
    <ul class="post-category-list">
        @foreach(\App\Category::getNotEmpty() as $cat)
            <li><a href="{{ route('cat_page',['cat_slug'=>$cat->cat_slug]) }}"><i class="icon-plus-sign"></i>{{ $cat->cat_title }} ({{ $cat->posts()->count() }})</a></li>
        @endforeach
    </ul>
</div>