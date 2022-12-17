<div class="col-md-4">

<!-- Latest News -->
<div class="widget latest-news-responsive-margin">
    <h4>Latest News</h4>
    <div class="title-border"></div>
    
    <!-- Sidebar Latest News Slider Start -->
    <div class="sidebar-latest-news owl-carousel owl-theme">
        <!-- Latest News Start -->
        <?php
            $latestNewsQuery  = "SELECT p_id AS 'latestPid', title 'latestPostTitle', image 'latestPostImage', SUBSTRING(description, 1, 50) AS 'latestPostDescription' FROM post WHERE status=1 ORDER BY p_id DESC LIMIT 3";
            $latestNewsResult = mysqli_query($conn, $latestNewsQuery);

            while($row = mysqli_fetch_assoc($latestNewsResult)){
                extract($row);
        ?>
        <div class="item">
            <div class="latest-news">
                <!-- Latest News Slider Image -->
                <div class="latest-news-image">
                    <a href="single-post.php?post_id=<?=$latestPid;?>">
                        <img src="admin/images/posts/<?=$latestPostImage;?>">
                    </a>
                </div>
                <!-- Latest News Slider Heading -->
                <h5><?=$latestPostTitle;?></h5>
                <!-- Latest News Slider Paragraph -->
            </div>
        </div>
        <?php } ?>
        <!-- Latest News End -->
        
    </div>
    <!-- Sidebar Latest News Slider End -->
</div>


<!-- Search Bar Start -->
<div class="widget"> 
        <!-- Search Bar -->
        <h4>Blog Search</h4>
        <div class="title-border"></div>
        <div class="search-bar">
            <!-- Search Form Start -->
            <form method="GET" action="post-search.php">
                <div class="form-group">
                    <input type="text" name="searchKey" maxlength="50" placeholder="Search Here" autocomplete="off" class="form-input">
                </div>

                <div class="read-more-btn">
                    <button type="submit" class="w-100 btn-main">Search&ensp;<i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
            </form>
            <!-- Search Form End -->
        </div>
</div>
<!-- Search Bar End -->

<!-- Recent Post -->
<div class="widget">
    <h4>Recent Posts</h4>
    <div class="title-border"></div>
    <div class="recent-post">
    <?php
    
        $recentPostQuery = "SELECT p.p_id AS 'recentPostId', p.title AS 'recentPostTitle', p.image AS 'recentPostImage', p.dateTimePosted AS 'recentPostDateTime', COUNT(cmt.cid) AS 'recentPostCmtCount' FROM frontend_index_main_section_without_national_sorting_view p LEFT JOIN sv_comments_onp_view cmt ON cmt.pid=p.p_id AND cmt.status=1 AND cmt.visitorStatus=1 GROUP BY p.p_id ORDER BY p.p_id DESC LIMIT 5";

        $recentPostResult = mysqli_query($conn, $recentPostQuery);

        while($row = mysqli_fetch_assoc($recentPostResult)){
            extract($row);
    ?>
        <!-- Recent Post Item Content Start -->
        <div class="recent-post-item">
            <div class="row">
                <!-- Item Image -->
                <div class="col-md-4">
                    <img src="admin/images/posts/<?=$recentPostImage;?>">
                </div>
                <!-- Item Tite -->
                <div class="col-md-8 no-padding">
                    <h5><a href="single-post.php?post_id=<?=$recentPostId;?>"><?=$recentPostTitle;?></a></h5>
                    <ul>
                        <li><i class="fa fa-clock-o"></i><?=elapsedTime($recentPostDateTime);?></li>
                        <li><i class="fa fa-comment-o"></i><?=$recentPostCmtCount;?></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Recent Post Item Content End -->
    <?php
        }
    ?>
    </div>
</div>

<!-- All Category -->
<div class="widget">
    <h4>Blog Categories</h4>
    <div class="title-border"></div>
    <!-- Blog Category Start -->
    <div class="blog-categories">
        <ul>
            <!-- Category Item -->
            <?php 
                $widgetCategoryQuery = "SELECT c.name AS 'widgetCategoryName', COUNT(p.p_id) AS 'counts' FROM category c LEFT JOIN post p ON (p.categoryId IN (SELECT id FROM category WHERE parent=c.id AND status=1) OR p.categoryId=c.id) AND p.status=1 WHERE c.status=1 GROUP BY c.name ORDER BY c.name ASC";

                $widgetCategoryResult = mysqli_query($conn, $widgetCategoryQuery);

                while($row = mysqli_fetch_assoc($widgetCategoryResult)){
                    extract($row);
                
            ?>
            <li>
                <i class="fa fa-check"></i>
                <a href="post-by-category.php?category=<?=$widgetCategoryName;?>"><?=$widgetCategoryName;?></a>
                <span>[<?=$counts;?>]</span>
            </li>
            <?php } ?>
        </ul>
    </div>
    <!-- Blog Category End -->
</div>

<!-- Recent Comments -->

<!--
<div class="widget">
    <h4>Recent Comments</h4>
    <div class="title-border"></div>
    <div class="recent-comments">
        
        <!-- Recent Comments Item Start 
        <div class="recent-comments-item">
            <div class="row">
                <!-- Comments Thumbnails 
                <div class="col-md-4">
                    <i class="fa fa-comments-o"></i>
                </div>
                <!-- Comments Content 
                <div class="col-md-8 no-padding">
                    <h5>admin on blog posts</h5>
                    <!-- Comments Date 
                    <ul>
                        <li>
                            <i class="fa fa-clock-o"></i>Dec 15, 2018
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Recent Comments Item End

    </div>
</div>
Recent Comments Item End -->

<!-- Meta Tag -->
<div class="widget">
    <h4>Recent Tags</h4>
    <div class="title-border"></div>
    <!-- Meta Tag List Start -->
    <div class="meta-tags">
        <?php 
            $tagsQuery = "SELECT tags FROM post WHERE status=1 ORDER BY p_id DESC LIMIT 8 ";
            $tagsResult = mysqli_query($conn, $tagsQuery);
            $tagsArray = array();

            $tagsString = "";

            while($row = mysqli_fetch_assoc($tagsResult)){
                extract($row);
                $tagsString.=($tags.",");
                
            }

            $tagsArray = explode(",",$tagsString);
            $tagsArray = array_unique($tagsArray);

            foreach($tagsArray as $key=> $tag){
                if($key == array_key_last($tagsArray)){ break; }
        ?>
        <span><a class="text-white d-inline-block" href="post-by-tag.php?tag=<?=$tag;?>"><?=$tag;?></a></span>
        <?php } ?>
    </div>
    <!-- Meta Tag List End -->
</div>

</div>