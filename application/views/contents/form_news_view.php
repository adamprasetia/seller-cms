<form id="form_data" method="post">
    <div class="box box-default" style="position: sticky;top: 50px;z-index: 9;">
        <div class="box-footer">
            <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url('news/index').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan</button>
            <button type="button" class="btn_close btn btn-default" data-redirect="<?php echo base_url('news/index').get_query_string() ?>"><i class='fa fa-close'></i> Kembali</button>
        </div>
    </div>
    <div class="box box-default">
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong>FORM NEWS</strong></h4>
            </div>
        </div>
        <div class="box-body">
            <div class="form-group">
                <label>Judul *</label>
                <input type="text" id="title" name="title" class="form-control" value="<?php echo isset($data->title)?$data->title:'' ?>">
                <small>Note : Gunakan judul yang mudah di cari oleh user</small>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="button" name="choose" class="btn btn-default btn-sm btn-dialog" value="Pilih Image" data-title="Pilih Image Produk" data-target="image_news" data-url="<?php echo base_url('photo').'?modals=true'; ?>">
                <div class="media">
                    <div class="media-left">
                        <img id="image_news_img" src="<?php echo !empty($data->image)?base_url_fe().'/'.$data->image:''; ?>" class="media-object" style="width: 300px;height: auto;border-radius: 10px;box-shadow: 0 1px 3px rgba(0,0,0,.15);background-color:#3c8dbc">
                        <input type="hidden" id="image_news" name="image" value="<?php echo isset($data->image)?$data->image:''; ?>">
                    </div>
                </div>
                <small>Note : Image yang akan digunakan pada thumbnail artikel</small>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea type="text" id="desc" rows="5" name="desc" class="form-control"><?php echo isset($data->desc)?$data->desc:'' ?></textarea>
                <small>Note : Gunakan deskripsi yang relevant sehingga memudahkan orang-orang untuk menemukan website kamu lewat pencarian search engine (google)</small>
            </div>
            <div class="form-group">
                <label>Konten</label>
                <textarea type="text" id="content" rows="5" name="content" class="form-control"><?php echo isset($data->content)?$data->content:'' ?></textarea>
                <small>Note : Konten yang baik akan memudahkan user mengakses website kamu lewat pencarian search engine (google)</small>
            </div>
            <div class="form-group">
                <label>Status</label>
                <div class="radio">
                    <label>
                    <input type="radio" name="status" value="PUBLISH" <?php echo isset($data->status) && $data->status=='PUBLISH'?'checked':'' ?>>
                        Publish
                    </label>
                </div>
                <div class="radio">
                    <label>
                    <input type="radio" name="status" value="DRAFT" <?php echo (isset($data->status) && $data->status=='DRAFT') || empty($data->status)?'checked':'' ?>>
                        Draft
                    </label>
                </div>
                <small>Note : Jika 'Publish' maka news akan ditampilkan</small>
            </div>
        </div>  
        <div class="box-footer">
            <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url('news/index').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan</button>
            <button type="button" class="btn_close btn btn-default" data-redirect="<?php echo base_url('news/index').get_query_string() ?>"><i class='fa fa-close'></i> Kembali</button>
        </div>
    </div>
</form>