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

                    if(isset($_GET['searchKey'])){
                        $searchKey = strtolower(mysqli_real_escape_string($conn, trim($_GET['searchKey'])));
                        
                        if(empty($searchKey)){
                            header("Location: index.php");
                            exit();
                        }
                        
                        $searchKeyExploded = explode(" ", strtolower($searchKey));
                        $searchKeyModified = trim(str_replace(str_split(",-._+*&()!~`$%^<>?;:'|/\\=") ," ", $searchKey));

                        $searchKeyPrepare  = "p.title LIKE '%".implode("%' OR p.title LIKE '%",$searchKeyExploded)."%' OR p.description LIKE '%".implode("%' OR p.description LIKE '%",$searchKeyExploded)."%' OR p.tags LIKE '%".implode("%' OR p.tags LIKE '%",$searchKeyExploded)."%' OR p.categoryName LIKE '%".implode("%' OR p.categoryName LIKE '%",$searchKeyExploded)."%' OR p.authorName LIKE '%".implode("%' OR p.authorName LIKE '%",$searchKeyExploded)."%' OR p.catParent=(SELECT id FROM category WHERE name LIKE '%$searchKey%' AND parent=0 AND status=1)";

                        $countQuery = "SELECT p.p_id FROM frontend_index_main_section_without_national_sorting_view p WHERE ( ".$searchKeyPrepare." )";

                        $postSearchResultCount = $conn->query($countQuery)->num_rows;

                        $viewQuery  ="SELECT p.*, COUNT(cmt.cid) AS 'srcCmtCount' FROM frontend_index_main_section_without_national_sorting_view p LEFT JOIN sv_comments_onp_view cmt ON cmt.pid=p.p_id AND cmt.status=1 AND cmt.visitorStatus=1 WHERE ( ".$searchKeyPrepare." ) GROUP BY p.p_id  ORDER BY p.p_id DESC LIMIT ?, ?";
                        
                        $page = "post-search.php?searchKey={$searchKey}&";

                        $result = paginationResult($postSearchResultCount, $viewQuery, $page);


                    }
                    else{
                        header("Location: index.php");
                        exit();
                    }

                ?>

                <?php if($postSearchResultCount==0){ ?>
                    <div class="alert alert-info rounded-0 border-info">
                       <b>No records found!</b>
                    </div>
                    
                <?php } else{ ?>
                    <div class="alert alert-success rounded-0 border-success">
                      <span class="badge badge-success"><?=$postSearchResultCount;?></span><?php if($postSearchResultCount==1){ echo ' record '; }else { echo ' records '; } ?> found for search key <b><?=$searchKey;?></b>
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
                                <h3 class="post-title">
                                    <?php 

                                    $titleArray = explode(" ", $title);

                                        foreach($titleArray as $word){

                                            $token = strtolower(trim(str_replace(str_split(",-._+*&()!~`$%^<>?;:'|/\\=") ," ", $word)));

                                            if(in_array($token, $searchKeyExploded) || in_array($word, $searchKeyExploded) || $token==$searchKeyModified 
                                            || is_int(strpos($token, $searchKeyModified))){

                                                $word = '<span class="highlight">'.$word.'</span>';
                                            }

                                            echo " ".$word;
                                        }
                                    ?>
                                </h3>
                            </a>
                            <p>
                                <?php 
                            
                                $descriptionArray = explode(" ", $shortDescription);

                                    foreach($descriptionArray as $word){

                                        $token = strtolower(trim(str_replace(str_split(",-._+*&()!~`$%^<>?;:'|/\\=") ," ", $word)));

                                        if(in_array($token, $searchKeyExploded) || in_array($word, $searchKeyExploded) || $token==$searchKeyModified 
                                        || is_int(strpos($token, $searchKeyModified))){

                                            $word = '<span class="highlight">'.$word.'</span>';
                                        }

                                        echo " ".$word;
                                    }
                                    echo '...';
                                ?>
                                
                            </p>
                            <!-- Blog Info, Date and Author -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="blog-info">
                                        <ul>
                                            <li><i class="fa fa-user"></i>&ensp;<?=$authorName;?></li>
                                            <li><i class="fa fa-clock-o"></i><?=elapsedTime($dateTimePosted);?></li>
                                            <i class="fa fa-comment-o"></i>&ensp;<?=$srcCmtCount;?>
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


