require('./bootstrap');

Vue.component('medias', required ('components/Medias.vue'));
var app = new Vue({
    el: '#media-loop'
});