<div class="box box-default">
    <form id="form_data" method="post">
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong>FORMULIR <?php echo $title ?></strong></h4>
            </div>
        </div>
        <div class="box-body">
            <div class="form-group">
                <input type="hidden" id="id" name="id" value="<?php echo isset($data->id)?$data->id:'' ?>">
                <label>Title *</label>
                <input type="text" id="title" name="title" class="form-control" value="<?php echo isset($data->title)?$data->title:'' ?>">
            </div>
            <div class="form-group">
                <label>Image *</label>
                <input type="button" name="choose" class="btn btn-default btn-sm btn-dialog" value="Pilih Image" data-title="Pilih Image Store" data-target="image_item" data-url="<?php echo base_url('photo').'?modals=true'; ?>">
                <div class="media">
                    <div class="media-left">
                        <img id="image_item_img" src="<?php echo !empty($data->image)?$this->session_login['session_store']['domain'].'/'.$data->image:''; ?>" class="media-object" style="width: 300px;height: auto;border-radius: 10px;box-shadow: 0 1px 3px rgba(0,0,0,.15);background-color:#3c8dbc">
                        <input type="hidden" id="image_item" name="image" value="<?php echo isset($data->image)?$data->image:''; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Domain</label>
                <input type="text" id="domain" name="domain" class="form-control" value="<?php echo isset($data->domain)?$data->domain:'' ?>">
            </div>
            <div class="form-group">
                <label>Storage</label>
                <input type="text" id="storage" name="storage" class="form-control" value="<?php echo isset($data->storage)?$data->storage:'' ?>">
            </div>
        </div>
        <div class="box-footer">
            <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url($table.'/index').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan</button>
            <button type="button" class="btn_close btn btn-default" data-redirect="<?php echo base_url($table.'/index').get_query_string() ?>"><i class='fa fa-close'></i> Kembali</button>
        </div>
    </form>
</div>