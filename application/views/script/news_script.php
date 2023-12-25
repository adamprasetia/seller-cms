<script>
$(document).ready(function () {
    tinymce.init({
    selector: '#content',
    object_resizing: false,
    toolbar_sticky:true,
    toolbar_sticky_offset: 110,
    height: 500,
    menubar: false,
    resize: true,
    plugins: ['lists hr code media paste link table photos quickbars editphototext fullscreen'],
    relative_urls: false,
    remove_script_host: false,
    toolbar: 'bold italic underline | bullist numlist | table | undo redo | link | fullscreen photos | hr | code | formatselect fontsizeselect | alignleft aligncenter alignright alignjustify',
    quickbars_insert_toolbar: 'photos',
    quickbars_image_toolbar: 'editphototext',
    paste_as_text:true,
    branding: false,
    init_instance_callback: function(editor) {
        editor.on('Change', function(e) {
            $('#content').val(editor.getContent())
        });
    }
    });

    $("#general-modal-iframe").on('load', function () {
        $(this).contents().find(".btn_add_photo").click(function () {
            var id = $(this).attr('data-id');
            var id_tinymce = $(this).attr('data-id-tinymce');
            var caption = $(this).attr('data-title');
            var author = $(this).attr('data-author');
            var imagedata = $("#general-modal-iframe").contents().find('.imagedata-' + id).data();
            tinymce.get(id_tinymce).execCommand('mceInsertContent', false, '<img width="500" height="500" src="' + '<?php echo base_url_fe() ?>/' + imagedata.src + '" data-caption="' + caption + '" data-author="' + author + '">');
            $('#general-modal').modal('hide');
        });
    });
});

</script>