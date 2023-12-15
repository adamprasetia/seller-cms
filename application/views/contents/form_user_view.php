<div class="box box-default">
    <form id="form_data" method="post" autocomplete="off">
        <div class="box-header with-border">
            <div class="pull-left">
                <h4><strong>FORMULIR PENGGUNA</strong></h4>
            </div>
        </div>
        <div class="box-body">
            <div class="form-group">
                <input type="hidden" id="id" name="id" value="<?php echo isset($data->id)?$data->id:'' ?>">
                <label>Nama Lengkap *</label>
                <input type="text" id="fullname" name="fullname" class="form-control" value="<?php echo isset($data->fullname)?$data->fullname:'' ?>">
            </div>
            <div class="form-group">
                <label>Email *</label>
                <input type="text" id="email" name="email" class="form-control"
                    value="<?php echo isset($data->email)?$data->email:'' ?>">
            </div>
            <div class="form-group">
                <label>Telepon</label>
                <input type="text" id="phone" name="phone" class="form-control"
                    value="<?php echo isset($data->phone)?$data->phone:'' ?>">
            </div>
            <div class="form-group">
                <label>Password *</label>
                <input autocomplete="new-password" type="password" class="form-control" name="password" id="password" value=""><br>
                <button class="btn btn-sm" onclick="random_password()">Set Random Password</button>
                <span id="password-text"></span>
                <script>
                    function random_password(){
                        var random_pass = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
                        document.getElementById('password').value=random_pass;
                        document.getElementById('password-text').innerHTML = random_pass;
                    }
                </script>
            </div>
            <div class="form-group">
                <label>Hak Akses *</label>
                <?php $roles = $this->db->get('role')->result(); ?>
                <?php foreach ($roles as $role) { ?>
                    <div class="checkbox"><label><input type="checkbox" <?php echo (!empty($data_role) && in_array($role->id, $data_role)?'checked':'')?> name="role[]" value="<?php echo $role->id ?>"> <?php echo $role->name ?></label></div>
                <?php } ?>
            </div>
            <div class="form-group">
                <label>Store *</label>
                <?php $stores = $this->db->get('store')->result(); ?>
                <?php foreach ($stores as $store) { ?>
                    <div class="checkbox"><label><input type="checkbox" <?php echo (!empty($data_store) && in_array($store->id, $data_store)?'checked':'')?> name="store[]" value="<?php echo $store->id ?>"> <?php echo $store->title ?></label></div>
                <?php } ?>
            </div>
        </div>

        <div class="box-footer">
            <button type="button" class="btn_action btn btn-primary" data-redirect="<?php echo base_url('user/index').get_query_string() ?>" data-action="<?php echo $action ?>" data-form="#form_data" data-idle="<i class='fa fa-save'></i> Simpan" data-process="Menyimpan..."><i class='fa fa-save'></i> Simpan</button>
            <button type="button" class="btn_close btn btn-default" data-redirect="<?php echo base_url('user/index').get_query_string() ?>"><i class='fa fa-close'></i> Kembali</button>
        </div>
    </form>
</div>