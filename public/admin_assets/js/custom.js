$(document).ready(function() {
    $('.cat_del_link').bind('click', function () {
        if(confirm('Вы уверены что хотите удалить категорию ?')) {
            $($(this).attr('href')).submit();
        }
        return false;
    });
    $('.post_del_link').bind('click', function () {
        if(confirm('Вы уверены что хотите удалить статью ?')) {
            $($(this).attr('href')).submit();
        }
        return false;
    });
    $('.page_del_link').bind('click', function () {
        if(confirm('Вы уверены что хотите удалить страницу ?')) {
            $($(this).attr('href')).submit();
        }
        return false;
    });
    $('.tag_del_link').bind('click', function () {
        if(confirm('Вы уверены что хотите удалить метку ?')) {
            $($(this).attr('href')).submit();
        }
        return false;
    });
    $('.restore_link').bind('click', function () {
        if(confirm('Вы уверены что востановить запись ?')) {
            $($(this).attr('href')).submit();
        }
        return false;
    });
    $('form[class^="class-media-img-"]').bind('submit',function(){
        if(!confirm('Вы уверены что хотите удалить картинку')){
            return false;
        }
    });
    $('form#all-post-form').bind('submit',function(){
        if($('#chose_select').val() == ''
            || !$('.chose_el:checked').length
            || !confirm('Вы уверены что хотите удалить записи'))
            return false

    });
});