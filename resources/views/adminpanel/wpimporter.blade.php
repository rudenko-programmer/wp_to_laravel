@extends('adminpanel.admin-layout')
@section('header','WordPress Importer')
@section('content')
    <div class="col-sm-12">
        <section class="panel panel-default">
            <header class="panel-heading font-bold"></header>
            <div class="panel-body">
                    <form action="{{ route('wp_load_xml') }}"
                          method="POST"
                          enctype="multipart/form-data"
                    >
                        {{ csrf_field() }}
                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Файл для импорта</label>
                            <div class="col-sm-10">
                                <input type="file" name="wpxml" value="Загрузить XML" accept="application/xml" class="filestyle" data-buttonText="Загрузить" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline v-middle input-s">
                            </div>
                        </div>
                        <input name="_method" type="hidden" value="PUT">
                        <input type="submit" class="btn btn-s-md btn-success" value="Начать импорт">
                    </form>
                    <form action="{{ route('wp_do_xml') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Файл для импорта</label>
                            <div class="col-sm-10">
                                <textarea name="wpxml" id="" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                        </div>
                        <input name="_method" type="hidden" value="PUT">
                        <input type="submit" class="btn btn-s-md btn-success" value="Выполнить">
                    </form>
                <h1>Импорт используя JQuery</h1>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Файл для импорта</label>
                    <div class="col-sm-10">
                        <input id="file-selector" type="file" name="wpxml" value="Загрузить XML" accept="application/xml" class="filestyle" data-buttonText="Загрузить" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline v-middle input-s">
                    </div>
                </div>
                <input type="button" id="lets-parse" class="btn btn-s-md btn-success" value="Начать импорт">

                <div class="col-md-8 col-md-offset-2">
                    @if(isset($data))
                        @foreach($data as $key => $item)
                            <div class="col-md-12">
                                <h2>{{ $key }} => {{ $item }}</h2>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts.footer')
    <script>
        let wpimport_csrf = '{{ csrf_token() }}';
    </script>
    <script src="{{ asset('admin_assets/js/wpimport.js')}}"></script>
@endsection