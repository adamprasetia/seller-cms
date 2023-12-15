<script>
$(document).ready(function () {
    tinymce.init({
    selector: '#desc',
    object_resizing: false,
    height: 500,
    menubar: false,
    resize: true,
    plugins: ['lists hr code media paste link table photos quickbars editphototext fullscreen'],
    relative_urls: false,
    remove_script_host: false,
    toolbar: 'bold italic underline | bullist numlist | table | undo redo | link | fullscreen photos | hr | code | formatselect fontsizeselect',
    quickbars_insert_toolbar: 'photos',
    quickbars_image_toolbar: 'editphototext',
    paste_as_text:true,
    branding: false,
    init_instance_callback: function(editor) {
        editor.on('Change', function(e) {
            $('#desc').val(editor.getContent())
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
            tinymce.get(id_tinymce).execCommand('mceInsertContent', false, '<img width="500" height="500" src="' + '<?php echo $this->session_login['session_store']['domain'] ?>/' + imagedata.src + '" data-caption="' + caption + '" data-author="' + author + '">');
            $('#general-modal').modal('hide');
        });
    });
});

</script>