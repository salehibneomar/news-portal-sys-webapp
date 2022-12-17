<?php include 'includes/header.php'; ?>

    <!-- :::::::::: Page Banner Section Start :::::::: -->
    <section class="sub-page-section">

    </section>
    <!-- ::::::::::: Page Banner Section End ::::::::: -->

    <!-- :::::::::: Blog With Right Sidebar Start :::::::: -->
    <section>
        <div class="container">
            <div class="row">
                <!-- Blog Posts Start -->
                <div class="col-md-8">

                <?php

                    if(isset($_GET['tag'])){
                        $tag = strtolower(mysqli_real_escape_string($conn, trim($_GET['tag'])));

                        if(empty($tag)){
                            header("Location: index.php");
                            exit();
                        }
                        
                        $countQuery = "SELECT p.p_id FROM frontend_index_main_section_without_national_sorting_view p WHERE  p.tags LIKE '%$tag%' OR p.title LIKE '%$tag%' OR p.description LIKE '%$tag%' OR p.categoryName LIKE '%$tag%' OR p.catParent=(SELECT id FROM category WHERE name LIKE '%$tag%' AND parent=0 AND status=1) ";

                        $postByTagResultCount = $conn->query($countQuery)->num_rows;

                        $viewQuery  ="SELECT p.*, COUNT(cmt.cid) AS 'byTagCmtCount' FROM frontend_index_main_section_without_national_sorting_view p LEFT JOIN sv_comments_onp_view cmt ON cmt.pid=p.p_id AND cmt.status=1 AND cmt.visitorStatus=1 WHERE ( p.tags LIKE '%$tag%' OR p.title LIKE '%$tag%' OR p.description LIKE '%$tag%' OR p.categoryName LIKE '%$tag%' OR p.catParent=(SELECT id FROM category WHERE name LIKE '%$tag%' AND parent=0 AND status=1)) GROUP BY p.p_id  ORDER BY p.p_id DESC LIMIT ?, ?";

                        $page = "post-by-tag.php?tag={$tag}&";
                    
                        $result = paginationResult($postByTagResultCount, $viewQuery, $page);

                    }
                    else{
                        header("Location: index.php");
                        exit();
                    }

                ?>

                <?php if($postByTagResultCount==0){ ?>
                    <div class="alert alert-info rounded-0 border-info">
                       <b>No records found!</b>
                    </div>
                    
                <?php } else{ ?>
                    <div class="alert alert-success rounded-0 border-success">
                      <span class="badge badge-success"><?=$postByTagResultCount;?></span><?php if($postByTagResultCount==1){ echo ' record '; }else { echo ' records '; } ?> found for the tag <b><?=$tag;?></b>
                    </div>
                <?php

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
                                <?=$shortDescription."...";?>
                            </p>
                            <!-- Blog Info, Date and Author -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="blog-info">
                                        <ul>
                                            <li><i class="fa fa-user"></i>&ensp;<?=$authorName;?></li>
                                            <li><i class="fa fa-clock-o"></i><?=elapsedTime($dateTimePosted);?></li>
                                            <li><i class="fa fa-comment-o"></i>&ensp;<?=$byTagCmtCount;?></li>
                                            <!--<li><i class="fa fa-heart"></i>(50)</li>-->
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-4 read-more-btn">
                                    <a href="single-post.php?post_id=<?=$p_id;?>" class="btn-main">Read More <i class="fa fa-angle-double-right"></i></a>
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
                    
                <?php }  ?> 

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


