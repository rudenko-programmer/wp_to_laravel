<template>
    <div>
        <div class="row media-gallery-row" v-for="chunk in chunkedMedias">
            <div v-for="image in chunk" class="col-xs-6 col-sm-3 media-gallery-item-box">

                    <div class="gallery-image-box">
                        <button @click="deleteImage(image.id)" class="btn btn-rounded btn-md btn-icon btn-default delete-media">
                            <i class="fa fa-times"></i>
                        </button>
                        <a :href="image.full" data-lity>
                        <img :src="image.thumb" style="width: 100%" alt="">
                        </a>
                    </div>

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
                $.getJSON(__media.url.getMedia, function(medias){
                    this.medias = medias;
                }.bind(this));
            },
            deleteImage: function (id) {
                var obj = this;
                if(confirm('Вы уверены что хотите удалить картинку ?')) {
                    $.post(
                            __media.url.deleteMedia+ "/" + id,
                            {
                                '_token': __media.scrf,
                                '_method': "DELETE",
                                'id': id
                            },
                            function () {
                                obj.removeItem(id);
                            }
                    )
                }
            },
            removeItem: function (id) {
                for (var i = 0; i < this.medias.length; i++) {
                    if (this.medias[i].id === id) {
                        this.medias.splice(i, 1);
                    }
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