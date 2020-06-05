<body class="hold-transition sidebar-mini">
<div class="wrapper">
        <!--NavBar-->
    <?php require 'partial/layout/top-nav.html'; ?>
    <!--SideBar-->
    <?php require 'partial/layout/sidebar-menu.html'; ?>
  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
        <h1>Recent Comments</h1>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <?php foreach ($this->comments as $comment) :?>
                        <div class="row">
                            <div class="col-xs-2 col-md-1">
                                <img src="http://placehold.it/80" class="img-circle img-responsive" alt="" /></div>
                            <div class="col-xs-10 col-md-11">
                                <div>
                                    <a><?=$comment->header;?></a>
                                    <div class="mic-info">
                                        By: <a href="#"><?=$comment->firstname?><?=$comment->lastname;?></a> <?=$comment->timestamp?>
                                    </div>
                                </div>
                                <div class="comment-text">
                                    <?=$comment->comment_content;?>
                                </div>
                                <div class="action">
                                    <?php if(Session::get('user')['permission'] == "Admin"): ?>
                                    <a type="button" href="<?=URL?>category/approved/<?=$comment->id;?>" class="btn btn-success btn-xs" title="Approved" value="">
                                        <span class="fas fa-check"></span>
                                    </a>
                                    <?php elseif(Session::get('user')['permission'] == "Editor"): ?>
                                    <a type="button" href="" class="btn btn-primary btn-xs" title="Edit">
                                        <span class="fas fa-pencil-alt"></span>
                                    </a>
                                    <a type="button" class="btn btn-danger btn-xs" title="Delete">
                                        <span class="fas fa-trash"></span>
                                    </a>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </li>
                </ul>
                <a href="#" class="btn btn-primary btn-sm btn-block" role="button"><span class="glyphicon glyphicon-refresh"></span> More</a>
            </div>
        </section>
    </div>
</div>