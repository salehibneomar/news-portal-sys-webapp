<?php

include  '../config/db.php';
include 'session_check.php';

$table            = 'site_visitor';
$primaryKey       = 'vid';
$visitorStatus    = null;
$visitorName      = null;

$columns = array(
            array(
                  'db'=> 'vid',
                  'dt'=> 0,
                  'formatter'=> function($d, $row){
                    return '<span class="badge badge-secondary">'.$d.'</span>';
                  }
            ),
            array(
                'db'=> 'name',
                'dt'=> 1,
                'formatter'=> function($d, $row){
                  global $visitorName;
                  $visitorName = $d;

                  return $d;
                }
            ),
            array('db'=> 'email',            'dt'=> 2),
            array(
                'db'=> 'dateRegistered',
                'dt'=> 3,
                'formatter'=> function($d, $row){
                    $dateRegistered = date('jS M y', strtotime($d));
                    return $dateRegistered;
                }
            ),
            array(
                'db'=> 'status',
                'dt'=> 4,
                'formatter'=> function($d, $row){
                    global $visitorStatus;
                    $visitorStatus = $d;
                    $badgeType     = array("warning", "success", "danger", "secondary");
                    $statusMessage = array("Unverified", "Verified", "Suspended", "Deactivated");
                    return '<span class="badge badge-'.$badgeType[$d].'">'.$statusMessage[$d].'</span>';

                }
            ),
            array(
                'db'=> 'vid',
                'dt'=> 5,
                'formatter'=> function($d, $row){
                    global $visitorName, $visitorStatus;

                    $statusArray = array(0=>"Unverified", 1=>"Verified", 2=>"Suspended", 3=>"Deactivated");

                    $option = "";

                    foreach($statusArray as $key=> $status){
                        $selected = ($key==$visitorStatus) ? "selected" : null;
                        $option.='<option value="'.$key.'" '.$selected.'>'.$status.'</option>';
                    }

                    $action = 
                        '<button class="btn btn-info btn-sm mb-1" data-toggle="modal" data-target="#update_'.$d.'" >
                            <i class="fas fa-user-edit"></i>
                        </button>
                        
                        <div class="modal fade" id="update_'.$d.'" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog ">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title text-center w-100" id="staticBackdropLabel">'.$visitorName.'</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="visitors.php?operation=Update" method="POST">
                        
                                <div class="modal-body">
                                    <div class="form-group p-2">
                                        <label>Status</label>
                                        <select name="status" class="custom-select">'.$option.'</select>
                                    </div>
                                </div>
                                <input type="hidden" name="editId" value="'.$d.'">
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" name="visitorUpdateBtn"><i class="fas fa-edit"></i>&ensp;Update</button>
                                </div>
                                                        
                            </form>
                        </div>
                        </div>
                    </div';

                    return $action;

                }
            )
        );

require( 'ssp.class.php' );

echo json_encode(
    SSP::simple( $_GET, $dbInfo, $table, $primaryKey, $columns )
);

unset($visitorStatus, $visitorName);

ob_end_flush();

?>