<template>
    <div>
        <div class="row media-gallery-row" {{--v-for="chunk as chunkedMedias"--}}>
            <div v-for="image in medias" class="col-xs-6 col-sm-3 media-gallery-item-box">
                <button @click="deleteImage(image.id)" class="btn btn-rounded btn-sm btn-icon btn-default delete-media">
                    <i class="fa fa-times"></i>
                </button>
                <a :href="image.full" data-lity>
                    <img :src="image.thumb" style="width: 100%" alt="">
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                medias: []
            };
        },
        mounted: function () {
            this.getMedias();
        },
        methods: {
            getMedias: function () {
                $.getJSON("{{ route('get_media') }}", function(medias){
                    this.medias = medias;
                }.bind(this));
            },
            deleteImage: function (id) {
                if(confirm('Вы уверены что хотите удалить картинку ?')) {
                    obj = this;
                    $.post(
                            "{{ url('/api/media/delete_media') }}/" + id,
                            {
                                '_token': "{{csrf_token()}}",
                                '_method': "DELETE",
                                'id': id
                            },
                            function () {
                                for (var i = 0; i < obj.medias.length; i++) {
                                    if (obj.medias[i].id === id) {
                                        obj.medias.splice(i, 1);
                                    }
                                }
                            }
                    )
                }
            }
        },
        computed: {
            chunkedMedias: function () {
             return _.chunk(this.medias, 4);
             }
        }
    }
</script>