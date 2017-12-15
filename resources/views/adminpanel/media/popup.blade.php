<div id="myModal" class="modal fade popup-media-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Медиабиблиотека</h4>
            </div>
            <div class="modal-body">
            <!-- modal body -->
                <div class="col-sm-12" style="height: 100%">
                    <section class="panel panel-default" style="height: 100%">
                        <div class="col-md-12" style="">
                            <br>
                            <form action="{{route('store_photo_path')}}"
                                  method="POST"
                                  class="dropzone"
                                  id="myDropzone"
                                  style="box-sizing: content-box; padding: 0; min-height: 0"
                            >
                                {{ csrf_field() }}

                            </form>
                        </div>
                        <div class="col-md-12" id="media-loop" style="height: 75%; padding: 20px">
                                <popup-medias></popup-medias>
                        </div><div style="clear: both"></div>
                    </section>
                </div><div style="clear: both"></div>
            <!-- modal body end -->
            </div>
            <div class="modal-footer">
            </div>
        </div>

    </div>
</div>
<script src="{{ asset('admin_assets/js/dropzone.js')}}"></script>
<script>
    var __media = {
        url: {
            getMedia: '{{route('get_media')}}',
            deleteMedia: '{{ url('/api/media/delete_media') }}',
            getDownload: '{{ url('/api/media/upload_media') }}'
        },
        csrf: '{{csrf_token()}}'
    };
    var __app = [];

</script>
<script src="{{ asset('admin_assets/js/popup.media.js')}}"></script>