import Vue from 'vue'
import Medias from './components/Medias.vue'

Vue.component('medias', Medias);

__app = new Vue({
    el: '#media-loop'
});

Dropzone.options.myDropzone = {
    paramName: 'photo',
    maxFileSize: 3,
    acceptedFiles: '.jpg, .jpeg, .png, .bmp, .gif',
    dictDefaultMessage: "Перетащите файлы для загрузки или нажмите на поле",
    init: function() {
        this.on("complete", function(file) {
            $.getJSON(__media.url.getDownload+"/"+JSON.parse(file.xhr.response).id, function(image){
                __app.$children[0].medias.unshift(image[0]);
            }.bind(this));
            this.removeFile(file);
        });
    }
};