<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <img style="background-color:#ffdab3" src="<?php echo isset($data->url)?$this->session_login['session_store']['domain'].'/'.$data->url:'' ?>" alt="<?php echo isset($data->title)?$data->title:'' ?>" class="img-responsive img-thumbnail">
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <form id="form_data" action="<?php echo $action ?>" method="post">
                <div class="form-group">
                    <input type="hidden" id="id" name="id" value="<?php echo isset($data->id)?$data->id:'' ?>">
                    <label>Title</label>
                    <input autocomplete="off" type="text" id="title" name="title" class="form-control" value="<?php echo isset($data->title)?$data->title:'' ?>">
                </div>
                <div class="form-group">
                    <label>Author</label>
                    <input autocomplete="off" type="text" id="author" name="author" class="form-control" value="<?php echo isset($data->author)?$data->author:'' ?>">
                </div>
                <div class="form-group">
                    <label>Credit</label>
                    <input autocomplete="off" type="text" id="credit" name="credit" class="form-control" value="<?php echo isset($data->credit)?$data->credit:'' ?>">
                </div>
                <div class="form-group">
                    <button type="button" name="button" class="btn btn-sm btn-primary btn_action" data-action="<?php echo $action ?>" data-idle="Update" data-form="#form_data" data-process="Updating..." data-form="#form_data" data-redirect="<?php echo base_url('photo/index').get_query_string() ?>">Update</button>
                    <?php if(!$this->input->get('modals')): ?>
                    <button type="button" name="button" class="btn btn-sm btn-default btn_action" data-title="Edit Photo" data-redirect="<?php echo base_url('photo/index').get_query_string() ?>">Close</button>
                    <?php endif; ?>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
