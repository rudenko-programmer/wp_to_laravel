<template>
    <div class="media-loop-container">
        <div class="row media-gallery-row" v-for="chunk in chunkedMedias">
            <div v-for="image in chunk" class="col-xs-2 media-gallery-item-box">
                <div class="gallery-image-box">
                    <button @click="deleteImage(image.id)" class="btn btn-rounded btn-md btn-icon btn-default delete-media">
                        <i class="fa fa-trash-o"></i>
                    </button>
                    <button @click="addImage(image.id)" class="btn btn-md btn-icon btn-default add-media">
                        <i class="fa fa-plus"></i>
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
                                '_token': __media.csrf,
                                '_method': "DELETE",
                                'id': id
                            },
                            function () {
                                obj.removeItem(id);
                            }
                    )
                }
            },
            addImage: function (id) {
                for (var i = 0; i < this.medias.length; i++) {
                    if (this.medias[i].id === id) {
                        $('#media-field').val(this.medias[i].name);
                        $('#media-src').attr('src', this.medias[i].thumb);
                        $('.close').click();
                        break;
                    }
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
                return _.chunk(this.medias, 6);
            }
        }
    }
</script>