<?php

    $postErr = isset($this->post_err) ? true : false;
    $postErrMsg = isset($this->post_err) ? $this->post_err : '';

?>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- navbar -->
  <?php require "partial/layout/top-nav.html";?>
  <!-- /.navbar -->
  <?php require "partial/layout/sidebar-menu.html"; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add post</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add post</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <?php if($postErr) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $postErrMsg ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
      <form action="<?=URL; ?>dashboard/doAdd" method="POST" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-9">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">General</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="inputName">Title</label>
                  <input type="text" id="inputName" name="header" class="form-control">
                </div>
                <div class="form-group">
                  <label for="inputDescription">Post Description<sup>*</sup></label>
                  <textarea id="inputDescription" name="content" class="form-control form-control-lg" rows="12"></textarea>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-md-3">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Budget</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>Status</label>
                  <select class="custom-select" name="status">
                      <?php foreach ($this->status as $status): ?>
                          <option value="<?= $status->id ?>"><?= $status->status;?></option>
                      <?php endforeach;  ?>
                  </select>
                </div>
                <div  class="form-group">
                  <label for="inputTags">Tags</label>
                  <input name='tags' type="text" id="inputTags" class="form-control"/>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Categories</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="inputCategories">All Categories</label><br/>
                  <select style="width: 100%" id="inputCategories" name="category_id[]" multiple>
                        <?php foreach ($this->data as $item): ?>
                          <option value="<?= $item->id ?>"><?= $item->category_name;?></option>
                        <?php endforeach;  ?>
                  </select>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Featured Images</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group">
                    <label for="title">Image Upload: <sup>*</sup></label>
                    <input type="file" class="form-control-file text-upload font-weight-bold" name="post_file" id="inputFile" onchange="readUrl(this)" data-title="Click or Drag and drop a file">
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <a href="#" class="btn btn-secondary">Cancel</a>
            <input type="submit" value="Create new Post" class="btn btn-success float-right">
          </div>
        </div>
      </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->