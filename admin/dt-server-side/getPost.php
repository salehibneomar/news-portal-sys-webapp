<?php

include  '../config/db.php';
include 'session_check.php';

$authorId          = null;
$authorRole        = null;
$loggedInUserId    = $_SESSION['userData']['id'];
$loggedInUserRole  = $_SESSION['userData']['role'];

$table            = 'postView';
$primaryKey       = 'p_id';

$columns = array(
            array(
                  'db'=> 'p_id',
                  'dt'=> 0,
                  'formatter'=> function($d, $row){
                    global $conn, $authorRole, $authorId;  
                    $userRoleGetQuery = "SELECT userRole, authorId FROM postView WHERE p_id='$d' LIMIT 1";
                    $result           = mysqli_fetch_assoc(mysqli_query($conn, $userRoleGetQuery));
                    $authorId         = $result['authorId'];
                    $authorRole       = $result['userRole'];

                    return '<span class="badge badge-secondary">'.$d.'</span>';
                  }
            ),
            array(
                  'db'=> 'image',
                  'dt'=> 1,
                  'formatter'=> function($d, $row){
                    $image = (empty(trim($d))) ? 'images/posts/default_banner.jpg' : 'images/posts/'.$d;
                    
                    return '<img class="post-table-image" src="'.$image.'">';

                  }
            ),
            array(
                  'db'=> 'title',
                  'dt'=> 2,
                  'formatter'=> function($d, $row){
                      return '<span class="d-inline-block truncate-text">'.$d.'</span>';
                  }
                ),
            array('db'=> 'categoryName',    'dt'=> 3),
            array(
                'db'=> 'userName',
                'dt'=> 4,
                'formatter'=> function($d, $row){
                    global $authorRole;
                    $badgeType  = array("","primary", "secondary");
              
                    return '<span class="badge badge-'.$badgeType[$authorRole].'">'.$d.'</span>';
                    
                }
            ),
            array(
                'db'=> 'dateTimePosted',
                'dt'=> 5,
                'formatter'=> function($d, $row){
                    
                    $datePosted = date('jS M y', strtotime($d));

                    return $datePosted;

                }
            ),
            array(
                'db'=> 'status',
                'dt'=> 6,
                'formatter'=> function($d, $row){
                    $status    = ($d==1) ? 'Published' : 'Draft';
                    $badgeType  = array("secondary", "success");
              
                    return '<span class="badge badge-'.$badgeType[$d].'">'.$status.'</span>';

                }
            ),
            array(
                'db'=> 'p_id',
                'dt'=> 7,
                'formatter'=> function($d, $row){
                    
                    global $loggedInUserId, $loggedInUserRole, $authorRole, $authorId;

                    $delete = '
                    <button class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#delete_'.$d.'" >
                        <i class="fas fa-trash">
                        </i>
                    </button>

                    <div class="modal fade" id="delete_'.$d.'" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center w-100" id="staticBackdropLabel">Are you sure?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                You won\'t be able revert this choice!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <a href="posts.php?operation=Delete&delete_id='.$d.'" class="btn btn-primary">Okay</a>
                            </div>
                            </div>
                        </div>
                    </div>';

                    $update = '
                    <a class="btn btn-info btn-sm mb-1" href="posts.php?operation=Edit&edit_id='.$d.'">
                        <i class="fas fa-pencil-alt">
                        </i>
                    </a>';

                    $view   = '
                    <a class="btn btn-success btn-sm mb-1" href="single-post.php?pid='.$d.'">
                        <i class="fas fa-eye">
                        </i>
                    </a>';

                    $action = $view;

                    if(($loggedInUserRole==2 && $loggedInUserId==$authorId) || 
                    (($loggedInUserRole==1 && $loggedInUserId==$authorId) || ($authorRole==2 && $loggedInUserRole==1))
                    ){
                        $action = $view." ".$update." ".$delete;
                    }

                    return $action;
                    
                }
            )
        );

require( 'ssp.class.php' );


echo json_encode(
    SSP::complex( $_GET, $dbInfo, $table, $primaryKey, $columns )
);

unset($authorId, $authorRole);

ob_end_flush();

?>