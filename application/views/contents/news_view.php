<div class="box box-default">
    <div class="box-header with-border">
        <div class="pull-left">
            <h4><strong>DATA NEWS</strong></h4>
        </div>
    </div>
    <div class="box-header with-border">
        <a href="<?php echo base_url('news/add') ?>" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> Tambah</a>
        <a href="<?php echo now_url() ?>" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Refresh</a>
        <div class="pull-right">
            <div class="has-feedback">
                <input id="input_search" type="text" class="form-control input-sm" placeholder="Search..." data-url="<?php echo current_url() ?>" data-query-string="<?php echo get_query_string(array('search','page')) ?>" value="<?php echo $this->input->get('search') ?>">
            </div>
        </div>
    </div>
    <div class="box-body no-padding">
        <div class="table-responsive no-margin">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="100">Image</th>
                        <th>Title</th>
                        <th>Deskripsi</th>
                        <th>Created At</th>
                        <th>Published At</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                      <?php
                            $no=1+$offset;
                            foreach ($data as $key => $value){
                      ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><img src="<?php echo base_url_fe().'/'.str_replace('/ori_','/100x100_',$value->image) ?>" alt=""></td>
                        <td><?php echo $value->title; ?></td>
                        <td><?php echo $value->desc; ?></td>
                        <td><?php echo $value->created_at; ?></td>
                        <td><?php echo $value->published_at; ?></td>
                        <td><?php echo $value->status; ?></td>
                        <td>
                            <a class="btn btn-default" href="<?php echo base_url('news/edit/'.$value->id); ?>"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-default" type="button" name="button" data-url="<?php echo base_url('news/delete/'.$value->id); ?>" onclick="return deleteData(this)"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                      <?php $no++; } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="box-footer">
        <label><?php echo isset($total)?$total:'' ?></label>
        <div class="pull-right">
            <?php echo isset($paging)?$paging:'' ?>
        </div>
    </div>
</div>
