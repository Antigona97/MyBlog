<body class="hold-transition sidebar-mini pace-primary">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <?php require "partial/layout/top-nav.html"; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php require "partial/layout/sidebar-menu.html"; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Categories</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Categories</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <form action="<?php echo URL; ?>dashboard/addCategory" method="POST">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Category</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body">
            <label>Category Name</label>
            <input name="category" class="form-control"/>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <div class="row">
              <button class="btn btn-secondary">Cancel</button>
              <button type="submit" class="btn btn-success float-right">Create</button>
            </div>
          </div>
          <!-- /.card-footer-->
        </div>
      </form>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
