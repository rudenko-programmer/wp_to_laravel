@extends('adminpanel.admin-layout')
@section('header','Медиабиблиотека')
@section('content')
    <div class="col-sm-12">
        <section class="panel panel-default">
            <form action="{{route('store_photo_path')}}"
                  method="POST"
                  class="dropzone"
                  id="myDropzone"
            >
                {{ csrf_field() }}
            </form>
            <div class="col-md-8 col-md-offset-2">
                @if(count($media))
                    @foreach($media->chunk(4) as $photos)
                        <div class="row media-gallery-row">
                            @foreach($photos as $item)
                                <div class="col-xs-6 col-sm-3 media-gallery-item-box">
                                    {!! linkTo('<i class="i i-cross2"></i>', "/adminpanel/media/delete/{$item->id}", 'DELETE', 'media-img-'.$item->id) !!}

                                    <form method='POST'
                                          action='{{ route('add_photo_to', array('type' => $type, 'id'=>$id)) }}'
                                          class='add-photo-form-class'>
                                        <input type="hidden" name="media_id" value="{{ $item->id }}">
                                        <input type='hidden' name='_method' value='PUT'>
                                        {!! csrf_field() !!}
                                        <button type='submit'><i class="i i-plus2"></i></button>
                                    </form>

                                    <a href="{{ url($item->getFullImg()) }}" data-lity>
                                        <img src="{{ url($item->getThumbnail()) }}" style="width: 100%" alt="">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endif
            </div>
        </section>
    </div>
@endsection
@section('scripts.footer')
    <script src="{{ asset('admin_assets/js/dropzone.js')}}"></script>
    <script>
        Dropzone.options.myDropzone = {
            paramName: 'photo',
            maxFileSize: 3,
            acceptedFiles: '.jpg, .jpeg, .png, .bmp, .gif',
            dictDefaultMessage: "Перетащите файлы для загрузки или нажмите на поле"
        };
    </script>
@endsection