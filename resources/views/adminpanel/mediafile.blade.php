@extends('adminpanel.admin-layout')
@section('header','Медиабиблиотека')
@section('content')
    <div class="col-sm-12">
        <section class="panel panel-default">
            <div class="col-md-8 col-md-offset-2">
                <form action="{{route('store_photo_path')}}"
                      method="POST"
                      class="dropzone"
                      id="myDropzone"
                >
                    {{ csrf_field() }}

                </form>
            </div>
            <div class="col-md-8 col-md-offset-2" id="media-loop">
                {{--@if(count($media))
                    @foreach($media->chunk(4) as $photos)
                        <div class="row media-gallery-row">
                            @foreach($photos as $item)
                                <div class="col-xs-6 col-sm-3 media-gallery-item-box">
                                    {!! linkTo('<i class="i i-cross2"></i>', "/adminpanel/media/delete/{$item->id}", 'DELETE', 'media-img-'.$item->id) !!}

                                    <a href="{{ url($item->getFullImg()) }}" data-lity>
                                        <img src="{{ url($item->getThumbnail()) }}" style="width: 100%" alt="">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endif--}}
                <div class="row media-gallery-row">
                    <medias></medias>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts.footer')
    <script src="{{ asset('admin_assets/js/dropzone.js')}}"></script>
    <script>
        var __media = {
            url: {
                getMedia: '{{route('get_media')}}',
                deleteMedia: '{{ url('/api/media/delete_media') }}',
                getDownload: '{{ url('/api/media/upload_media') }}'
            },
            scrf: '{{csrf_token()}}'
        };
        var __app = [];

    </script>
    <script src="{{ asset('admin_assets/js/build.js')}}"></script>
@endsection