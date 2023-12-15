<script>
$(document).ready(function(){

$('#input_file').change(function() {
    var redirect = $(this).attr('data-redirect');

    console.log(redirect);

    $.ajax({
        url: $('#form-data').attr('action'),
        type: 'POST',
        data: new FormData($('#form-data')[0]),
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        beforeSend: function() {
            $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
        },
        success:function(str){
            
            if (str.status) {

                var title   = 'Success!' 
                var tipe    = 'success';
                var message = '</br>Photo Has Been Uploaded';

                if(str.fail>0){
                    title       = 'Something Wrong!';
                    tipe        = 'warning';
                    message     = '<br />Check your Image! <br/> Only JPG & PNG type image allowed <br/> with Maximum size 1 MB';
                }

                console.log(title, tipe, message, str.fail);

                swal({
                    title:title,
                    text:str.upload + " Uploaded, " + str.fail + " Failed" + message,
                    html: true,
                    type:tipe
                });

                if (redirect && str.fail == 0) {         
                    setTimeout(function(){
                        window.location = redirect;
                    },2000);                                           
                }

            }else{
                sweetAlert("Oops...", "Upload failed!!!", "error");                    
            }
            
            $('.overlay').remove();
        },
        error: function(xhr, textStatus, errorThrown){
            sweetAlert("Oops...", "Something went wrong!", "error");
            $('.overlay').remove();
        }               
    });
});

$('body').on('click', '.btn-edit', function(){
    $('#photo-id-modal').val($(this).attr('data-id'));
    $('#photo-modal').modal('show');
});

$('#photo-modal').on('shown.bs.modal', function (e) {
    console.log('show modal');
    getImageData(function(data){
        setFormModal(data);
    });
});

$('#photo-modal').on('hidden.bs.modal', function (e) {
    console.log('hide modal');
    cropDestroy();
    $('.overlay').remove();
});
});
</script>