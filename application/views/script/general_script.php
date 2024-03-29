<script>
// Method or Function
function updateButton(t, status) {
  if (!status) {
    $(t).html($(t).attr('data-idle'));
    $(t).prop('disabled', false);
    $('.overlay').remove();
  } else {
    $(t).html($(t).attr('data-process'));
    $(t).prop('disabled', true);
    $('.box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
  }
}

function htmlEntities(str) {
  return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}
// Event Listener
$('form').submit(function (e) {
  e.preventDefault();
});

$(document).on('click', '.btn_action', function () {
  var form = $(this).attr('data-form');
  var action = $(this).attr('data-action');
  var redirect = $(this).attr('data-redirect');
  var t = $(this);
  if (action) {

    $.ajax({
      url: action,
      method: 'post',
      data: new FormData($(form)[0]),
      processData: false,
      contentType: false,
      // dataType: 'json',
      beforeSend: function () {
        updateButton(t, true);
      },
      success: function (str) {
        var obj = jQuery.parseJSON(str);

        var tipe = 'success';
        var title = 'Success!';
        var message = 'Data berhasil disimpan';

        if (obj.tipe != undefined) {
            tipe = obj.tipe;
        }

        if (obj.title != undefined) {
            title = obj.title;
        }

        if (obj.message != undefined) {
            message = obj.message;
        }

        if (obj.redirect != undefined) {
            redirect = obj.redirect;
        }

        swal({
            title: title,
            type: tipe,
            text: message,
            timer: 2000,
            showConfirmButton: false
        });

        if (obj.tipe == undefined && obj.tipe != 'error') {

          if (redirect) {
            setTimeout(function () {
              window.location = redirect;
            }, 2000);
          }

        }

        updateButton(t, false);
      },
      error: function (xhr, textStatus, errorThrown) {
        sweetAlert("Oops...", "Terjadi Kesalahan!", "error");
        updateButton(t, false);
      }
    });

  } else {
    if (redirect) {
      window.location = redirect;
    }
  }
});

function deleteData(t) {
  swal({
    title: "Kamu yakin ?",
    text: "Kamu mungkin tidak bisa mengembalikan data yang sudah dihapus!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Hapus sekarang!",
    closeOnConfirm: false
  },
    function () {
      $.ajax({
        url: $(t).attr("data-url"),
        type: 'POST',
        dataType: 'json',
        success: function (data) {
          swal({
              title: 'Deleted!',
              type: 'success',
              text: 'Data berhasil dihapus',
              timer: 2000,
              showConfirmButton: false
          });

          setTimeout(function () {
            location.reload();
          }, 2000);
        },
        error: function (xhr, textStatus, errorThrown) {
          sweetAlert("Oops...", "Terjadi Kesalahan!", "error");
          // setTimeout(function() {
          //   location.reload();
          // }, 2000);
        }
      });
    });
};

function restoreData(t) {
  swal({
    title: "Are you sure?",
    text: "You can recover this data!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes, restore it!",
    closeOnConfirm: false
  },
    function () {
      $.ajax({
        url: $(t).attr("data-url"),
        type: 'POST',
        dataType: 'json',
        success: function (data) {
          swal("Restored!", "Your data has been restored.", "success");
          setTimeout(function () {
            location.reload();
          }, 2000);
        },
        error: function (xhr, textStatus, errorThrown) {
          sweetAlert("Oops...", "Something went wrong!", "error");
          // setTimeout(function() {
          //   location.reload();
          // }, 2000);
        }
      });
    });
};

$('body').on('click', '.btn-dialog', function () {
  var title = $(this).attr('data-title');
  var src = $(this).attr('data-url');
  var target = $(this).attr('data-target');
  $('#general-modal-title').html(title);
  $('#general-modal-iframe').attr('src', src);
  $('#general-modal-iframe').attr('data-target', target);
  $('#general-modal').modal('show');
});

$(document).on('keypress', '#input_search', function (e) {
  if (e.which == 13) {
    var url = $(this).attr('data-url');
    var queryString = $(this).attr('data-query-string');
    if (queryString) {
      url += queryString + '&search=' + $(this).val();
    } else {
      url += '?search=' + $(this).val();
    }
    window.location = url;
    return false;
  }
});

var form_original_data = $("#form_data").serialize(); 
$(document).on('click', '.btn_close', function () {
  var t = $(this);
  var redirect = $(t).attr('data-redirect');
  if ($("#form_data").serialize() != form_original_data) {
  swal({
    title: "Kamu yakin ?",
    text: "Kamu mungkin memiliki perubahan yang belum disimpan yang akan hilang!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Tidak masalah!",
    closeOnConfirm: false
  }, function () {
    window.location = redirect;
  });
  }else{
    window.location = redirect;
  }
});

function changeStatus(t) {
  var st = $(t).attr('data-status') == 2 ? 'PUBLISH' : 'DRAFT';
  swal({
    title: 'Change to ' + st + '?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Yes',
    closeOnConfirm: false
  },
    function () {
      $.ajax({
        url: $(t).attr('data-url'),
        type: 'POST',
        dataType: 'json',
        success: function (data) {
          swal('Success!', '', 'success');
          location.reload();
        },
        error: function (xhr, textStatus, errorThrown) {
          sweetAlert('Oops...', 'Something went wrong!', 'error');
        }
      });
    });
};

$('.datetimepicker').datepicker({
    dateFormat: 'dd/mm/yy',
    changeMonth: true,
    changeYear: true
  });

  $('.input-uang').priceFormat({
		prefix: '',
		thousandsSeparator: ',',
		centsLimit: 0
	});

  $('.input-select2').select2();

  $("#general-modal-iframe").on('load',function () {   
        var target = $(this).attr('data-target');
        $(this).contents().find('.btn_add_photo').click(function () {
            var src = $(this).attr('data-src');         
            var gallery_view = `<?php $this->load->view('contents/gallery_item_view',['src'=>'']) ?>`
            if(target == 'gallery'){
              $('.gallery').append(gallery_view);
            }else{
              $('#'+target+'_img').attr('src','<?php echo @base_url_fe() ?>/'+src);
              $('#'+target).val(src);   
              $('#'+target+'_btn').show();   
            }

            $('#general-modal').modal('hide');
        });
    });

    $("body").on('click', '.btn-image-delete', function(){
      var target = $(this).attr('data-target');
      $('#'+target+'_img').attr('src','');
      $('#'+target).val('');
      $(this).hide();
    })


    $(".button_view_detail").click(function(){

    $.ajax({
        url: $(this).attr("data-url"),
        type: 'GET',
        success: function(data) {
            $('.modal-body').html(data)
            $('#general-modal-title').html('Detail')
            $('#general-modal').modal('show');
        },
        error: function(xhr, textStatus, errorThrown) {
        console.log(xhr);
        console.log(textStatus);
        console.log(errorThrown);
        sweetAlert("Oops...", "Something went wrong!", "error");
        }
    });
    });

    $('body').on('click', '.btn_delete_gallery', function(){
      $(this).parent().parent().remove();
    })

</script>