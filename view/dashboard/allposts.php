<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!--NavBar-->
    <?php require 'partial/layout/top-nav.html'; ?>
    <!--SideBar-->
    <?php require 'partial/layout/sidebar-menu.html'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">All Posts</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects" id="myTable">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                      <th style="width: 6%">
                        Title
                      </th>
                      <th style="width: 6%">
                          Author
                      </th>
                      <th style="width: 6%">
                          Categories
                      </th>
                      <th style="width: 6%" class="text-center">
                          Status
                      </th>
                      <th style="width: 6%">
                        Tags
                      </th>
                    <th style="width: 20%">
                    </th>
                  </tr>
              </thead>
              <tbody id="sortable">
              <?php if(is_array($this->posts) || is_object($this->posts)){
                foreach($this->posts as $post) :?>
                  <tr >
                      <td>
                          #
                      </td>
                      <td>
                          <a>
                              <?= $post->header ?>
                          </a>
                      </td>
                      <td>
                          <a>
                              <?= $post->fullname;?>
                          </a>
                      </td>
                      <td>
                          <span>
                              <a>
                                  <?php foreach ($this->category as $category) :
                                      if ($post->id == $category->post_id){
                                          echo $category->category_name;
                                      } "<br/>"; endforeach; ?>
                              </a>
                          </span>
                      </td>
                      <td>
                          <?=$post->status;?>
                      </td>

                      <td>
                          <?php $parts=explode(',',$post->tags);
                          foreach($parts as $tag) :?>
                              <span><?=$tag?></span>
                          <?php endforeach;?>
                      </td>
                      <td class="project-actions text-right">
                          <?php if(Session::get('user')['permission'] == "Admin"): ?>
                          <a href="<?= URL; ?>category/show/<?= $post->url; ?>" class="btn btn-primary btn-sm">
                              <i class="fas fa-folder"></i>View</a>
                          <a href="<?= URL; ?>dashboard/edit/<?= $post->url; ?>" class="btn btn-info btn-sm">
                              <i class="fas fa-pencil-alt"></i>Edit</a>
                          <a href="<?= URL; ?>dashboard/delete/<?= $post->url; ?>" id="deletePost" class="btn btn-danger btn-sm">
                              <i class="fas fa-trash"></i>Delete</a>
                      </td>
                          <?php elseif(Session::get('user')['permission'] == "Editor"): ?>
                              <td>
                                <a href="<?= URL; ?>category/show/<?= $post->url; ?>" class="btn btn-primary btn-sm">View</a>
                                <a href="<?= URL; ?>dashboard/edit/<?= $post->url; ?>" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i>Edit</a>
                              </td>
                          <td>
                            <?php elseif(Session::get('user')['permission'] == "Guest"): ?>
                                <a href="<?= URL; ?>category/show/<?= $post->url; ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-folder"></i>View</a>
                            <?php endif; ?>
                          </td>
                  </tr>
                <?php endforeach; }?>
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </section>
    <!-- /.content -->
  <!-- /.content-wrapper -->