<?php include 'includes/header.php'; ?>

<?php
    $postId = "";
    if(isset($_GET['post_id'])){
        $postId = mysqli_real_escape_string($conn, trim($_GET['post_id']));

        if(empty($postId)){
            header("Location: index.php");
            exit();
        }

        $singlePostQuery = "SELECT sp.*, COUNT(cmt.cid) AS 'cmtCount' FROM single_post sp LEFT JOIN sv_comments_onp_view cmt ON cmt.status=1 AND cmt.pid=sp.p_id AND cmt.visitorStatus=1 WHERE sp.p_id='$postId' GROUP BY sp.p_id";

        $singlePostResult = mysqli_query($conn, $singlePostQuery);

        $data = mysqli_fetch_assoc($singlePostResult);

        if(is_null($data)){
            header("Location: index.php");
            exit();
        }

        extract($data);

        $dateTimePosted = explode(" ",$dateTimePosted);

        $datePosted = intval(date('d', strtotime($dateTimePosted[0]))).date(' M, Y', strtotime($dateTimePosted[0]));
        $timePosted = date('h:i:s a', strtotime($dateTimePosted[1]));

    }
    else{
        header("Location: index.php");
    }

?>
    <!-- :::::::::: Page Banner Section Start :::::::: -->
    <section class="sub-page-section">

    </section>
    <!-- ::::::::::: Page Banner Section End ::::::::: -->



    <!-- :::::::::: Blog With Right Sidebar Start :::::::: -->
    <section>
        <div class="container">
            <div class="row">
                <!-- Blog Single Posts -->
                <div class="col-md-8">

                <div class="blog-single">
                        <!-- Blog Title -->
                        <a href="single-post.php?post_id=<?=$p_id;?>">
                            <h3 class="post-title"><?=$title;?></h3>
                        </a>

                        <!-- Blog Categories -->
                        <div class="single-categories mb-5">
                            <span><?=$singlePostCategoryName;?></span>
                        </div>

                        <!-- Blog Info, Date and Author -->
                        <div class="row mb-5 w-100">
                            <div class="col-md-12">
                                <div class="blog-info">
                                    <ul>
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-12">
                                                <li><i class="fa fa-calendar"></i>&ensp;Date: <?=$datePosted;?></li>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <li><i class="fa fa-clock-o"></i>&ensp;Time: <?=$timePosted;?></li>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <li><i class="fa fa-user"></i>&ensp;Posted By - <?=$singlePostAuthorName;?></li>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <li><i class="fa fa-comment-o"></i>&ensp;Comments (<?=$cmtCount;?>)</li>
                                            </div>

                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Blog Thumbnail Image Start -->
                        <div class="blog-banner blog-single-banner">
                            <a href="#">
                                <img src="admin/images/posts/<?=$image;?>">
                            </a>
                        </div>
                        <!-- Blog Thumbnail Image End -->

                        <!-- Blog Description Start -->
                        <p>
                            <?=$description;?>
                        </p>

                        <!--<div class="blog-description-quote">
                            <p><i class="fa fa-quote-left"></i>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.<i class="fa fa-quote-right"></i></p>
                        </div>

                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est eserunt mollit anim id labor laborumlabor laborum est.
                        </p>
                         Blog Description End -->

                        <!-- Tags -->
                        <div class="single-categories">
                            <h4 class="mb-3">Tags</h4>
                            <?php 
                                $singlePostAllTags = explode(",", $tags);

                                foreach($singlePostAllTags as $tag){
                            ?>

                            <span><?=$tag;?></span>

                            <?php } ?>
                        </div>
                    </div>

                    <!-- Single Comment Section Start -->
                    <div class="single-comments" id="seeComments">
                    <?php
                        $getCommentsQuery         = "SELECT * FROM sv_comments_onp_view  WHERE pid='$postId' AND status=1 AND visitorStatus=1 ORDER BY cid DESC";
                        $allCommentsResult        = mysqli_query($conn, $getCommentsQuery);
                        $totalCommentCountPerPost = mysqli_num_rows($allCommentsResult);
                    ?>
                        <!-- Comment Heading Start -->
                        <div class="row">
                            <div class="col-md-12 mb-5">
                                <?php if($totalCommentCountPerPost==0){ ?>
                                    <div class="alert alert-info rounded-0 border-info">No comments found! Be the first one to comment.</div>
                                <?php }else{ ?>
                                    <h4>Total (<?=$totalCommentCountPerPost;?>) Comments</h4>
                                    <div class="title-border"></div>
                                    <!--<p></p>-->
                                <?php } ?>
                            </div>
                        </div>
                        <!-- Comment Heading End -->

                <?php while($row = mysqli_fetch_assoc($allCommentsResult)){ extract($row) ?>
            
                        <!-- Single Comment Post Start -->
                        <div class="row each-comments">
                            <div class="col-md-2">
                                <!-- Commented Person Thumbnail -->
                                <div class="comments-person">
                                    <img src="assets/images/visitor/default_avatar.jpg" >
                                </div>
                            </div>

                            <div class="col-md-10 no-padding">
                                <!-- Comment Box Start -->
                                <div class="comment-box">
                                    <?php if($hasLoggedInVisitor && $_SESSION['visitorData']['vid']==$vid){ ?>
                                    <div class="navbar comment-drop-down">
                                        <div class="dropdown">
                                            <button class="btn btn-sm bg-transparent border-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right bs-dropdown-menu mt-2" >
                                                <a class="dropdown-item" href="single-post.php?post_id=<?=$pid;?>&operation=edit&edit_id=<?=$cid;?>/#postCommentField">Edit</a>
                                                <a class="dropdown-item" data-toggle="modal" data-target="#cmt_delete_<?=$cid;?>" >Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="cmt_delete_<?=$cid;?>"  role="dialog"  aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Are you sure?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Your comment will be deleted!</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <a href="single-post.php?post_id=<?=$pid;?>&operation=delete&delete_id=<?=$cid;?>" class="btn btn-primary">Okay</a>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="comment-box-header">
                                        <ul>
                                            <li class="post-by-name"><b><?=$visitorName;?></b></li> <br>
                                            <li class="post-by-hour"><small><?=elapsedTime($dateTime);?></small></li>
                                        </ul>
                                    </div>
                                    <p class="mt-2 mb-3"><?=$comment;?></p>
                                </div>
                                <!-- Comment Box End -->
                            </div>
                        </div>
                        <!-- Single Comment Post End -->
                <?php } ?>

                        <!-- Comment Reply Post Start 
                        <div class="row each-comments">
                            <div class="col-md-2 offset-md-2">
                                
                                <div class="comments-person">
                                    <img src="assets/images/corporate-team/team-2.jpg">
                                </div>
                            </div>

                            <div class="col-md-8 no-padding">
                                
                                <div class="comment-box">
                                    <div class="comment-box-header">
                                        <ul>
                                            <li class="post-by-name">Someone Special</li>
                                            <li class="post-by-hour">20 Hours Ago</li>
                                        </ul>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                </div>
                                <
                            </div>
                        </div>
                         Comment Reply Post End -->

                    </div>
                    <!-- Single Comment Section End -->

                    <hr id="postCommentField">

                    <!-- Post New Comment Section Start -->

                    <?php if(!$hasLoggedInVisitor){ ?>
                        <div class="alert alert-info rounded-0 border-info">
                        <b>Want to comment?</b> <br> login <span class="text-muted">(If you already have an account.)</span> Or Register <span class="text-muted">(If you don't have an account.)</span></div>
                    <?php }else{ ?>
                            <div class="post-comments" >
                            <?php $operation = (isset($_GET['operation'])) ? $_GET['operation'] : null; 
                                if($operation=="edit" && $hasLoggedInVisitor){   
                            ?>
                                <?php 
                                    if(isset($_GET['edit_id']) && !empty(trim($_GET['edit_id']))){
                                        $cmtEditId             = mysqli_real_escape_string($conn, trim($_GET['edit_id']));
                                        $getSingleCommentQuery = "SELECT comment AS editComment, cid AS editCommentId FROM site_visitor_comments_on_post WHERE cid='$cmtEditId'";

                                        $getSingleCommentResult = mysqli_query($conn, $getSingleCommentQuery);
                                        $getSingleCommentResult = mysqli_fetch_assoc($getSingleCommentResult);
                                        extract($getSingleCommentResult);
                                    }
                                ?>
                                <h4>Update Your Comment</h4>
                                <div class="title-border"></div>
                                <!-- Form Start -->
                                <form action="" method="POST" class="contact-form">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Comments Textarea Field -->
                                            <div class="form-group" >
                                                <textarea name="comment" class="form-input" placeholder="Your Comments Here..." maxlength="250" required><?=$editComment;?></textarea>
                                                <i class="fa fa-comment-o"></i>
                                            </div>
                                            <input type="hidden" name="pid" value="<?=$postId;?>">
                                            <input type="hidden" name="cid" value="<?=$cmtEditId;?>">
                                            <!-- Post Comment Button -->
                                            <button type="submit" class="btn-main" name="commentUpdateBtn">Update&ensp;<i class="fa fa-edit"></i></button>
                                        </div>
                                    </div>
                                    <!-- Right Side End -->
                                </form>
                                <!-- Form End -->
                            <?php }else if($operation=="delete" && $hasLoggedInVisitor){ 
                                
                                if(isset($_GET['delete_id']) && !empty(trim($_GET['delete_id']))){

                                    $deleteId            = mysqli_real_escape_string($conn, trim($_GET['delete_id']));
                                    $disableCommentQuery = "UPDATE site_visitor_comments_on_post SET status=0 WHERE cid='$deleteId' LIMIT 1";

                                    $disableCommentResult    = mysqli_query($conn, $disableCommentQuery);

                                    if($disableCommentResult){
                                        $_SESSION['toastr']['message']   = array("Comment deleted successfully!");
                                        $_SESSION['toastr']['alertType'] = 'success';
                                        header("Location: single-post.php?post_id=".$postId."/#seeComments");
                                        exit();
                                    }
                                    else{
                                        $_SESSION['toastr']['message']   = array("Error occured!");
                                        $_SESSION['toastr']['alertType'] = 'error';
                                    }
                                }

                            ?>

                            <?php }else{ ?>
                                <h4>Post Your Comment</h4>
                                <div class="title-border"></div>
                                <!-- Form Start -->
                                <form action="" method="POST" class="contact-form">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Comments Textarea Field -->
                                            <div class="form-group" >
                                                <textarea name="comment" class="form-input" placeholder="Your Comments Here..." maxlength="250" required></textarea>
                                                <i class="fa fa-comment-o"></i>
                                            </div>
                                            <input type="hidden" name="pid" value="<?=$postId;?>">
                                            <!-- Post Comment Button -->
                                            <button type="submit" class="btn-main" name="commentAddBtn">Post&ensp;<i class="fa fa-paper-plane-o"></i></button>
                                        </div>
                                    </div>
                                    <!-- Right Side End -->
                                </form>
                                <!-- Form End -->
                            <?php } ?>
                        </div>

                        <?php   
                            if(isset($_POST['commentAddBtn']) && $hasLoggedInVisitor){
                                extract($_POST);

                                $comment = mysqli_real_escape_string($conn, trim($comment));
                                $formErrors  = array();

                                if(empty($comment)){
                                    $formErrors[]="Empty comment cannot be posted!";
                                }

                                if(mb_strlen($comment)>=250){
                                    $formErrors[]="Comment is too large! try to keep under 250 characters.";
                                }

                                if(!empty($formErrors)){
                                    $_SESSION['toastr']['message']   = $formErrors;
                                    $_SESSION['toastr']['alertType'] = 'error';
                                }
                                else{
                                    $vid = $_SESSION['visitorData']['vid'];
                                    $commentDateTime   = date('Y-m-d H:i:s');
                                    $setCommentQuery   = "INSERT INTO site_visitor_comments_on_post(comment, dateTime, pid, vid, status) VALUES('$comment', '$commentDateTime' ,'$pid', '$vid', 1)";

                                    $setCommentResult = mysqli_query($conn, $setCommentQuery);

                                    if($setCommentResult){
                                        $_SESSION['toastr']['message']   = array("Comment added successfully!");
                                        $_SESSION['toastr']['alertType'] = 'success';
                                        header("Location: single-post.php?post_id=".$pid."/#seeComments");
                                        exit();
                                    }
                                    else{
                                        $_SESSION['toastr']['message']   = array("Error occured!");
                                        $_SESSION['toastr']['alertType'] = 'error';
                                    }
                                }
                            }
                            else if(isset($_POST['commentUpdateBtn']) && $hasLoggedInVisitor){
                                extract($_POST);

                                $comment = mysqli_real_escape_string($conn, trim($comment));
                                $formErrors  = array();

                                if(empty($comment)){
                                    $formErrors[]="Empty comment cannot be posted!";
                                }

                                if(mb_strlen($comment)>=250){
                                    $formErrors[]="Comment is too large! try to keep under 250 characters.";
                                }

                                if(!empty($formErrors)){
                                    $_SESSION['toastr']['message']   = $formErrors;
                                    $_SESSION['toastr']['alertType'] = 'error';
                                }
                                else{
                                    $vid = $_SESSION['visitorData']['vid'];
                                    $updateCommentQuery   = "UPDATE site_visitor_comments_on_post SET comment='$comment' WHERE cid='$cid' LIMIT 1";

                                    $updateCommentResult = mysqli_query($conn, $updateCommentQuery);

                                    if($updateCommentResult){
                                        $_SESSION['toastr']['message']   = array("Comment updated successfully!");
                                        $_SESSION['toastr']['alertType'] = 'success';
                                        header("Location: single-post.php?post_id=".$pid."/#seeComments");
                                        exit();
                                    }
                                    else{
                                        $_SESSION['toastr']['message']   = array("Error occured!");
                                        $_SESSION['toastr']['alertType'] = 'error';
                                    }
                                }
                            }
                        ?>


                    <?php } ?>
                    <!-- Post New Comment Section End -->              
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
