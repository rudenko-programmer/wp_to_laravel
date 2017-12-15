$(document).ready(function() {
    $('#lets-parse').click(function () {
        if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
            alert('The File APIs are not fully supported in this browser.');
            return;
        }
        input = document.querySelector('#file-selector');
        if (!input) {
            alert("Um, couldn't find the fileinput element.");
        }
        else if (!input.files) {
            alert("This browser doesn't seem to support the `files` property of file inputs.");
        }
        else if (!input.files[0]) {
            alert("Please select a file before clicking 'Load'");
        }
        else {
            file = input.files[0];
            fr = new FileReader();
            fr.onload = function () {
                console.log('parse start');
                parseXML(fr.result);
                console.log('parse complete');
            };
            fr.readAsText(file);
        }
    });

    function parseXML(text) {
        $.post(
            '/adminpanel/wpimporter/ajaxxml',
            {
                '_token': wpimport_csrf,
                '_method': "PUT",
                'wpxml': text
            },
            function () {
                console.log('kkkkkkkk');
            }
        );

        // parseAttachment(xml);
    }

    function parseCategories(cat) {

    }

    function parseAttachment(xml){
        $(xml).find('item').each(function () {
            let type = $(this).find('wp_post_type').first();
            let id = $(this).find('wp_post_id').first();
            let url = $(this).find('wp_attachment_url').first();
             if($(type).text() == 'attachment'){
                console.log($(type).text());
                console.log($(id).text());
                console.log($(url).text());
             }
        });
    }
});