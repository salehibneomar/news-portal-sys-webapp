<?php include 'includes/header.php'; ?>

    <!-- :::::::::: Page Banner Section Start :::::::: -->
    <section class="blog-bg background-img">
        <div class="container">
            <!-- Row Start -->
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-title">News Portal SIO</h2>
                    <!-- Page Heading Breadcrumb Start -->
                    <nav class="page-breadcrumb-item">
                        <ol>
                            <li><a href="index.html">Home <i class="fa fa-angle-double-right"></i></a></li>
                            <!-- Active Breadcrumb -->
                            <li class="active">All News</li>
                        </ol>
                    </nav>
                    <!-- Page Heading Breadcrumb End -->
                </div>
                  
            </div>
            <!-- Row End -->
        </div>
    </section>
    <!-- ::::::::::: Page Banner Section End ::::::::: -->

    <!-- :::::::::: Blog With Right Sidebar Start :::::::: -->
    <section>
        <div class="container">
            <div class="row">
                <!-- Blog Posts Start -->
                <div class="col-md-8">

                <?php

                    $count = $conn->query("SELECT p_id FROM frontend_index_main_section")->num_rows;

                    $viewQuery  ="SELECT p.*, COUNT(cmt.cid) AS 'cmtCount' FROM frontend_index_main_section p LEFT JOIN sv_comments_onp_view cmt ON cmt.pid=p.p_id AND cmt.status=1 AND cmt.visitorStatus=1 GROUP BY p.p_id LIMIT ?, ?";
                    
                    $page = "index.php?";

                    $result = paginationResult($count, $viewQuery, $page);

                    while($row = $result->fetch_assoc()){
                        extract($row);
                ?>

                    <!-- Single Item Blog Post Start -->
                    <div class="blog-post">
                        <!-- Blog Banner Image -->
                        <div class="blog-banner">
                            <a href="single-post.php?post_id=<?=$p_id;?>">
                                <img src="admin/images/posts/<?=$image;?>" >
                                <!-- Post Category Names -->
                                <div class="blog-category-name">
                                    <h6><?=$categoryName;?></h6>
                                </div>
                            </a>
                        </div>
                        <!-- Blog Title and Description -->
                        <div class="blog-description">
                            <a href="single-post.php?post_id=<?=$p_id;?>">
                                <h3 class="post-title"><?=$title;?></h3>
                            </a>
                            <p>
                                <?=$description."...";?>
                            </p>
                            <!-- Blog Info, Date and Author -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="blog-info">
                                        <ul>
                                            <li><i class="fa fa-user"></i>&ensp;<?=$authorName;?></li>
                                            <li><i class="fa fa-clock-o"></i>&ensp;<?=elapsedTime($dateTimePosted);?></li>
                                            <li><i class="fa fa-comment-o"></i>&ensp;<?=$cmtCount;?></li>
                                            <!--<li><i class="fa fa-heart"></i>(50)</li>-->
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-4 read-more-btn">
                                    <a href="single-post.php?post_id=<?=$p_id;?>" class="btn-main">See More <i class="fa fa-angle-double-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single Item Blog Post End -->
                <?php } ?>

                    <!-- Blog Paginetion Design Start -->
                    <div class="paginetion">
                        <ul>
                            <?php
                            echo paginationNavs($page);
                            ?>
                        </ul>
                    </div>
                    <!-- Blog Paginetion Design End -->               
                </div>



                <!-- Blog Right Sidebar -->
                <?php include 'includes/aside.php'; ?>
                <!-- Right Sidebar End -->
            </div>
        </div>
    </section>
    <!-- ::::::::::: Blog With Right Sidebar End ::::::::: -->
    
<?php include 'includes/footer.php'; ?>

<?php include 'includes/bottom.php'; ?>


