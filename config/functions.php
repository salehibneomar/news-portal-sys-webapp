<?php

function elapsedTime($startDateTime){

    $currentDateTime = date('Y-m-d H:i:s', time());
    $difference      = date_diff(date_create($currentDateTime), date_create($startDateTime));

    $elaspedArray    = array(
             'year'     => $difference->format('%y'),
             'month'    => $difference->format('%m'),
             'day'      => $difference->format('%d'),
             'hour'     => $difference->format('%h'),
             'minute'   => $difference->format('%i'),
             'second'   => $difference->format('%s')
    );

    $elasped = "Just now";

    foreach($elaspedArray as $key=> $out){
        if($out>=1){
            $elasped= ($out>1)? $out." ".$key."s ago" : $out." ".$key." ago";
        break;
        }
    }

    return $elasped;
}

function paginationResult($count, $viewQuery, $page){
    global $conn;

    $limit = 5;
    global $totalPages;
    $totalPages = ceil($count/$limit);

    global $currPage;
    $currPage = 1;

    if(isset($_GET['pg']) && !empty(trim($_GET['pg']))){
        $currPage = trim($_GET['pg']);

        if($currPage<1 || $currPage>$totalPages){
            header("Location: {$page}pg=1");
            exit();
        }

    }
    
    $start = ($currPage-1)*$limit;

    $stmt = $conn->prepare($viewQuery);
    $stmt->bind_param('ss', $start, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result;
}


function paginationNavs($url){
    global $currPage, $totalPages;
    $prevBtnDisabled = ($currPage==1) ? "disabled-link" : null; 
    $nextBtnDisabled = ($currPage==$totalPages) ? "disabled-link" : null;

   
    $startPaging = max(1, $currPage-2);
    $endPaging   = min($startPaging+4, $totalPages);

    $pagingString = '<li class="p-0 blog-prev '.$prevBtnDisabled.'"><a class="d-block p-1" href="'.$url.'pg='.($currPage-1).'"><i class="fa fa-long-arrow-left"></i></a></li> ';



        for($i=$startPaging; $i<=$endPaging; $i++){
            $active = ($i==$currPage) ? "active" : null;
            $pagingString.= '<li class="p-0 '.$active.'">
            <a class="d-block p-1" href="'.$url.'pg='.$i.'">'.$i.'</a>
            </li> ';
        }


    $pagingString.= ' <li class="p-0 blog-next '.$nextBtnDisabled.'"><a class="d-block p-1" href="'.$url.'pg='.($currPage+1).'"><i class="fa fa-long-arrow-right"></i></a></li>';

    return $pagingString;

}

?>