 <header class="masthead" style="background-image: url('<?=URL?>public/img/home-bg.jpg')">
      <?php require "partial/navbar.php";?>
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>My Blog</h1>
                    <span class="subheading"></span>
                </div>
            </div>
        </div>
    </div>
  </header>

<!-- Here comes the main content -->
<div class="container"> <!-- START: div#content -->
    <section>
    <div class="card-columns">
        <?php if(is_array($this->post) || is_object($this->post)) {
        foreach($this->post as $item) :?>
        <div class="card">
            <a href="<?=URL?>home/show/<?=$item->url?>">
                <img class="card-img-top" src="<?=$item->thumb?>" alt="Card image cap">
            </a>
            <div class="card-body">
                <?php foreach ($this->category as $category) :?>
                <a class="card-text mb-0 text-muted" href="<?=URL?>category/showCategory/<?=$category->url;?>">
                        <?php if ($item->id == $category->post_id){
                            echo $category->category_name;
                        } "<br/>";
                        endforeach; ?>
                </a>

                <h5 class="card-title"><?= $item->header ?></h5>
                <p class="card-text"><?=substr($item->content,0,100)?>...<a href="<?= URL; ?>home/show/<?= $item->url; ?>">read more</a></p>
                <div class="row">
                    <div class="col">
                        <p class="card-text"><small class="text-muted"><?= $item->timestamp ?></small></p>
                    </div>

                    <div class="col">
                        <p class="card-text pull-right"><small class="text-muted">Posted by: </br><?= $item->fullname;?></small></p>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; }?>
    </div>

