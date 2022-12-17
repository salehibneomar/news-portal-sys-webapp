<?php

include  '../config/db.php';
include 'session_check.php';

$table            = 'sv_comments_onp_view';
$primaryKey       = 'cid';
$commentStatus    = null;
$fullComment      = null;
$where            = null;
$getSinglePostId  = null;

if(isset($_GET['getSinglePostId']) && $_GET['getSinglePostId']!=null && !empty($_GET['getSinglePostId'])){
    $getSinglePostId = $_GET['getSinglePostId'];
    $where = "pid='$getSinglePostId'";
}

$columns = array(
            array(
                  'db'=> 'cid',
                  'dt'=> 0,
                  'formatter'=> function($d, $row){
                    return '<span class="badge badge-secondary">'.$d.'</span>';
                  }
            ),
            array(
                'db'=> 'pid',
                'dt'=> 1,
                'formatter'=> function($d, $row){
                    return '<span class="badge badge-info">'.$d.'</span>';
                  }
            ),
            array(
                'db'=> 'postTitle',
                'dt'=> 2,
                'formatter'=> function($d, $row){
                    global $fullPostTitle;
                    $fullPostTitle = $d;
                    return mb_substr($d, 0, 15)."...";
                }
              ),
            array(
                  'db'=> 'comment',
                  'dt'=> 3,
                  'formatter'=> function($d, $row){
                      global $fullComment;
                      $fullComment = $d;
                      return '<span class="d-inline-block truncate-text">'.$d.'</span>';
                  }
                ),
            array(
                'db'=> 'dateTime',
                'dt'=> 4,
                'formatter'=> function($d, $row){
                    global $fullDate;
                    $fullDate = $d;
                    $date = date('jS M y', strtotime($d));
                    return $date;
                }
            ),
            array('db'=> 'visitorName', 'dt'=> 5),
            array(
                'db'=> 'status',
                'dt'=> 6,
                'formatter'=> function($d, $row){
                    global $commentStatus;
                    $commentStatus = $d;
                    $badgeType     = array("danger", "success");
                    $statusMessage = array("Hidden", "Public");
                    return '<span class="badge badge-'.$badgeType[$d].'">'.$statusMessage[$d].'</span>';
                }
            ),
            array(
                'db'=> 'cid',
                'dt'=> 7,
                'formatter'=> function($d, $row){
                    
                    global $commentStatus, $fullComment, $getSinglePostId;

                    $formUrl = "post-comments.php?operation=Update";

                    if($getSinglePostId!=null){
                        $formUrl = "single-post.php?pid=".$getSinglePostId."&operation=updateCommentOnSinglePost";
                    }

                    $view = '<button class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#view_'.$d.'" >
                    <i class="fas fa-eye"></i>
                    </button>

                    <div class="modal fade" role="dialog" id="view_'.$d.'" data-backdrop="static">
                        <div class="modal-dialog ">
                            <div class="modal-content">
                                
                                    <div class="modal-header">
                                        <h5 class="modal-title text-center w-100" >Full Comment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>'.$fullComment.'</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                
                            </div>
                        </div>
                    </div>';

                    $statusArray = array(0=>"Hide", 1=>"Public");

                    $option = "";

                    foreach($statusArray as $key=> $status){
                        $selected = ($key==$commentStatus) ? "selected" : null;
                        $option.='<option value="'.$key.'" '.$selected.'>'.$status.'</option>';
                    }

                    $update = 
                        '<button class="btn btn-info btn-sm mb-1" data-toggle="modal" data-target="#update_'.$d.'" >
                        <i class="fas fa-edit"></i>
                        </button>
                        
                        <div class="modal fade" id="update_'.$d.'" data-backdrop="static" >
                        <div class="modal-dialog ">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title text-center w-100" >Comment ID = '.$d.'</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="'.$formUrl.'" method="POST">
                        
                                <div class="modal-body">
                                    <div class="form-group p-2">
                                        <label>Status</label>
                                        <select name="status" class="custom-select">'.$option.'</select>
                                    </div>
                                </div>
                                <input type="hidden" name="editId" value="'.$d.'">
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" name="commentUpdateBtn"><i class="fas fa-edit"></i>&ensp;Update</button>
                                </div>
                                                        
                            </form>
                        </div>
                        </div>
                    </div';


                    $action = $view." ".$update;

                    return $action;

                }
            )
        );

require( 'ssp.class.php' );


echo json_encode(
    SSP::complex( $_GET, $dbInfo, $table, $primaryKey, $columns, $where )
);

unset( $commentStatus, $fullComment );

ob_end_flush();

?>