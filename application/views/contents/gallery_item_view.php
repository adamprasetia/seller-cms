<div class="col-md-3 col-sm-4 col-xs-12" style="margin-bottom:10px">
    <input type="hidden" name="gallery[]" value="<?php echo !empty($src)?$src:'${src}' ?>">
    <img src="<?php echo config_item('base_domain'); ?><?php echo !empty($src)?$src:'${src}' ?>" alt="" style="background-color:#ffdab3" class="img-responsive img-thumbnail item" title="">
    <div style="position:absolute;bottom:10px;margin-left:10px">                            
        <button class="btn btn-danger btn-xs btn_delete_gallery" type="button" name="button"><i class="fa fa-trash"></i> Delete</button>                            
    </div>
</div>