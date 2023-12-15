<div class="box box-default">
    <form id="form_data" method="post">
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong>FORM ITEM</strong></h4>
            </div>
        </div>
        <div class="box-body">
            <div class="form-group">
                <label>Nama *</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($data->name)?$data->name:'' ?>">
            </div>
            <div class="form-group">
                <label>Image *</label>
                <input type="button" name="choose" class="btn btn-default btn-sm btn-dialog" value="Pilih Image" data-title="Pilih Image Produk" data-target="image_item" data-url="<?php echo base_url('photo').'?modals=true'; ?>">
                <div class="media">
                    <div class="media-left">
                        <img id="image_item_img" src="<?php echo !empty($data->image)?$this->session_login['session_store']['domain'].'/'.$data->image:''; ?>" class="media-object" style="width: 300px;height: auto;border-radius: 10px;box-shadow: 0 1px 3px rgba(0,0,0,.15);background-color:#3c8dbc">
                        <input type="hidden" id="image_item" name="image" value="<?php echo isset($data->image)?$data->image:''; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea type="text" id="desc" rows="5" name="desc" class="form-control"><?php echo isset($data->desc)?htmlentities($data->desc):'' ?></textarea>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="text" id="price" name="price" class="form-control" value="<?php echo isset($data->price)?$data->price:'' ?>">
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="">- Pilih Kategori -</option>
                    <?php foreach ($category as $key => $value) { ?>
                        <option <?php echo isset($data->category_id) && $data->category_id==$value->id?'selected':''?> value="<?php echo $value->id ?>"><?php echo $value->name ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Ranking</label>
                <input type="number" id="rank" name="rank" class="form-control" value="<?php echo isset($data->rank)?$data->rank:'' ?>">
            </div>
            <div class="form-group">
                <label>New</label>
                <div class="radio">
                    <label>
                    <input type="radio" name="new" value="1" <?php echo isset($data->new) && $data->new=='1'?'checked':'' ?>>
                        Ya
                    </label>
                </div>
                <div class="radio">
                    <label>
                    <input type="radio" name="new" value="0" <?php echo isset($data->new) && $data->new=='0'?'checked':'' ?>>
                        Tidak
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label>Electrified</label>
                <div class="radio">
                    <label>
                    <input type="radio" name="electrified" value="1" <?php echo isset($data->electrified) && $data->electrified=='1'?'checked':'' ?>>
                        Ya
                    </label>
                </div>
                <div class="radio">
                    <label>
                    <input type="radio" name="electrified" value="0" <?php echo isset($data->electrified) && $data->electrified=='0'?'checked':'' ?>>
                        Tidak
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label>Racing</label>
                <div class="radio">
                    <label>
                    <input type="radio" name="racing" value="1" <?php echo isset($data->racing) && $data->racing=='1'?'checked':'' ?>>
                        Ya
                    </label>
                </div>
                <div class="radio">
                    <label>
                    <input type="radio" name="racing" value="0" <?php echo isset($data->racing) && $data->racing=='0'?'checked':'' ?>>
                        Tidak
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label>Cover</label>
                <input type="button" name="choose" class="btn btn-default btn-sm btn-dialog" value="Pilih Cover" data-title="Select Photo item" data-target="cover_item" data-url="<?php echo base_url('photo').'?modals=true'; ?>">
                <div class="media">
                    <div class="media-left">
                        <img id="cover_item_img" src="<?php echo !empty($data->cover)?config_item('base_domain').$data->cover:''; ?>" class="media-object" style="width: 300px;height: auto;border-radius: 10px;box-shadow: 0 1px 3px rgba(0,0,0,.15);background-color:#3c8dbc">
                        <input type="hidden" id="cover_item" name="cover" value="<?php echo isset($data->cover)?$data->cover:''; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Cover versi Mobile</label>
                <input type="button" name="choose" class="btn btn-default btn-sm btn-dialog" value="Pilih Cover" data-title="Select Photo item" data-target="cover_mobile_item" data-url="<?php echo base_url('photo').'?modals=true'; ?>">
                <div class="media">
                    <div class="media-left">
                        <img id="cover_mobile_item_img" src="<?php echo !empty($data->cover_mobile)?config_item('base_domain').$data->cover_mobile:''; ?>" class="media-object" style="width: 300px;height: auto;border-radius: 10px;box-shadow: 0 1px 3px rgba(0,0,0,.15);background-color:#3c8dbc">
                        <input type="hidden" id="cover_mobile_item" name="cover_mobile" value="<?php echo isset($data->cover_mobile)?$data->cover_mobile:''; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Video</label>
                <input type="text" id="video" name="video" class="form-control" value="<?php echo isset($data->video)?$data->video:'' ?>">
                <p><small>Note: isi dengan link youtube</small></p>
                <?php if(!empty($data->video_id)) { ?>
                    <iframe src="https://www.youtube.com/embed/<?php echo $data->video_id ?>" frameborder="0"></iframe>
                <?php } ?>
            </div>
            <div class="form-group">
                <label>Pdf</label>
                <input type="file" name="pdf" id="pdf" class="form-control">
                <?php if(!empty($data->pdf)) { ?>
                    <iframe src="<?php echo config_item('base_domain').'assets/pdf/'.$data->pdf ?>" frameborder="0"></iframe>
                <?php } ?>
            </div>
            <div class="form-group">
                <label>Gallery</label>
                <input type="button" name="choose" class="btn btn-default btn-sm btn-dialog form-control" value="Tambah Gallery" data-title="Select Photo item" data-target="gallery" data-url="<?php echo base_url('photo').'?modals=true'; ?>">
            </div>
            <div class="row gallery">
                <?php if (!empty($data->gallery)) {
                    $gallery = json_decode($data->gallery);
                    if(!empty($gallery)){
                        foreach ($gallery as $key => $value) {
                            $this->load->view('contents/gallery_item_view',['src'=>$value]);    
                        }
                    }
                } ?>
            </div>
        </div>  
        <div class="box-footer">
            <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url('item/index').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan</button>
            <button type="button" class="btn_close btn btn-default" data-redirect="<?php echo base_url('item/index').get_query_string() ?>"><i class='fa fa-close'></i> Kembali</button>
        </div>
    </form>
</div>