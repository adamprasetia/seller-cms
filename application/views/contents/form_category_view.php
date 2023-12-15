<div class="box box-default">
    <form id="form_data" method="post">
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong>FORMULIR CATEGORY</strong></h4>
            </div>
        </div>
        <div class="box-body">
            <div class="form-group">
                <input type="hidden" id="id" name="id" value="<?php echo isset($data->id)?$data->id:'' ?>">
                <label>Nama *</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($data->name)?$data->name:'' ?>">
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" id="title" name="title" class="form-control" value="<?php echo isset($data->title)?$data->title:'' ?>">
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea type="text" id="desc" rows="5" name="desc" class="form-control"><?php echo isset($data->desc)?$data->desc:'' ?></textarea>
            </div>
        </div>
        <div class="box-footer">
            <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url('category/index').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan</button>
            <button type="button" class="btn_close btn btn-default" data-redirect="<?php echo base_url('category/index').get_query_string() ?>"><i class='fa fa-close'></i> Kembali</button>
        </div>
    </form>
</div>