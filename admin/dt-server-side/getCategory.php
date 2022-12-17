<?php

include  '../config/db.php';
include 'session_check.php';

$table      = 'category';
$primaryKey = 'id';

$columns = array(
    array( 
        'db' => 'id', 
        'dt' => 0,
        'formatter'=> function($d, $row){
            return '<span class="badge badge-secondary">'.$d.'</span>';
    }),
    array( 'db' => 'name', 'dt' => 1 ),
    array(
        'db'        => 'parent',
        'dt'        => 2,
        'formatter' => function( $d, $row ) {
            if($d==0){
                return '<span class="badge badge-primary">Primary</span>';
            }
            else{
                global $conn;
                $getParentCategoryQuery = "SELECT name AS 'parentName' FROM category WHERE id = '$d'";

                $parentCategoryName = mysqli_fetch_assoc(mysqli_query($conn, $getParentCategoryQuery))['parentName'];
            
                return '<span class="badge badge-secondary">'.$parentCategoryName.'</span>';
            }
        }
    ),
    array(
        'db'        => 'status',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {

            $status     = ($d==1) ? 'Active' : 'In-active';
            $badgeType  = array("danger", "success");

            return '<span class="badge badge-'.$badgeType[$d].'">'.$status.'</span>';
        }
    ),
    array(
        'db' => 'id',
        'dt' => 4,
        'formatter' => function($d, $row){
            $delete  = '
        <button  class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#deleteCategory_'. $d.'">
            <i class="fa fa-trash" aria-hidden="true"></i>
        </button>

            <div class="modal fade" id="deleteCategory_'.$d.'" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                <a href="category.php?delete='.$d.'" class="btn btn-primary">Okay</a>
                </div>
            </div>
            </div>
        </div> ';

        $update = '<a class="btn btn-info btn-sm mb-1" href="category.php?edit_id='.$d.'">
                        <i class="fas fa-pencil-alt">
                        </i>
                   </a>';

        $action =  $update." ".$delete;       

            return $action;

        }
    )
);

require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $dbInfo, $table, $primaryKey, $columns )
);

ob_end_flush();

?>