<section class="content-header">
<h1>
Dashboard
<small>Control panel</small>
</h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
<li class="active">Dashboard</li>
</ol>
</section>
<section class="content">
    
    <div class="form-group">
        <label for="">Store</label>
        <select name="session_store" id="session_store" class="form-control">
            <?php foreach ($store as $key => $value) { ?>
                <option value="<?php echo $value->id ?>" <?php echo $this->session_login['session_store']['id']==$value->id ? 'selected':'' ?>><?php echo $value->title ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="row">
<div class="col-lg-3 col-xs-6">

<div class="small-box bg-aqua">
<div class="inner">
<h3><?php echo number_format($total_category) ?></h3>
<p>Total Category</p>
</div>
<div class="icon">
<i class="ion ion-bag"></i>
</div>
<a href="<?php echo base_url('category') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>

<div class="col-lg-3 col-xs-6">

<div class="small-box bg-yellow">
<div class="inner">
<h3><?php echo number_format($total_item) ?></h3>
<p>Total Produk</p>
</div>
<div class="icon">
<i class="ion ion-person-add"></i>
</div>
<a href="<?php echo base_url('item') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>

</div>

</section>