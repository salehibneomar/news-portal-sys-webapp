<?php

include  '../config/db.php';
include 'session_check.php';


$table            = 'user';
$primaryKey       = 'id';
$loggedInUserId   = $_SESSION['userData']['id'];
$iteRole          = null;

$columns = array(
            array(
                  'db'=> 'id',
                  'dt'=> 0,
                  'formatter'=> function($d, $row){
                    return '<span class="badge badge-secondary">'.$d.'</span>';
                  }
            ),
            array(
                  'db'=> 'image',
                  'dt'=> 1,
                  'formatter'=> function($d, $row){
                    $image = (empty(trim($d)) || $d==null) ? 'images/users/default_avatar.jpg' : 'images/users/'.$d;
                    
                    return '<img class="user-image-table-sm" src="'.$image.'">';

                  }
            ),
            array('db'=> 'name',     'dt'=> 2),
            array('db'=> 'email',    'dt'=> 3),
            array('db'=> 'phone',    'dt'=> 4),
            array(
                'db'=> 'role',
                'dt'=> 5,
                'formatter'=> function($d, $row){
                    global $iteRole;
                    $iteRole    = $d;

                    $role       = ($d==1) ? 'Admin' : 'Editor';
                    $badgeType  = array("","primary", "secondary");
              
                    return '<span class="badge badge-'.$badgeType[$d].'">'.$role.'</span>';

                }
            ),
            array(
                'db'=> 'status',
                'dt'=> 6,
                'formatter'=> function($d, $row){
                    $status    = ($d==1) ? 'Active' : 'In-active';
                    $badgeType  = array("danger", "success");
              
                    return '<span class="badge badge-'.$badgeType[$d].'">'.$status.'</span>';

                }
            ),
            array(
                'db'=> 'joinedDate',
                'dt'=> 7,
                'formatter'=> function($d, $row){
                    
                    $dateJoined = date('jS M y', strtotime($d));

                    return $dateJoined;
                }
            ),
            array(
                'db'=> 'id',
                'dt'=> 8,
                'formatter'=> function($d, $row){
                    global $iteRole;
                    
                    $view   = '
                    <a class="btn btn-success btn-sm mb-1" href="user-profile.php?uid='.$d.'">
                        <i class="fas fa-eye">
                        </i>
                    </a>';

                    $delete = '
                    <button class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#delete_'.$d.'" >
                        <i class="fas fa-trash">
                        </i>
                    </button>
                    
                    <div class="modal fade" id="delete_'.$d.'" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog ">
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
                          <a href="users.php?operation=Delete&delete_id='.$d.'" class="btn btn-primary">Okay</a>
                        </div>
                      </div>
                    </div>
                </div>';

                    $update = '
                    <a class="btn btn-info btn-sm mb-1" href="users.php?operation=Edit&edit_id='.$d.'">
                        <i class="fas fa-pencil-alt">
                        </i>
                    </a>';

                    $action = $view;

                    if($iteRole==2){
                        $action = $view." ".$update." ".$delete;
                    }

                    return $action;
                    
                }
            )
        );

require( 'ssp.class.php' );

$where = "id!={$loggedInUserId}";

echo json_encode(
    SSP::complex( $_GET, $dbInfo, $table, $primaryKey, $columns,$where )
);

unset($iteRole);

ob_end_flush();

?>