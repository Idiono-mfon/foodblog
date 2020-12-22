<?php
    $per_page = 5;
    
    function prevStr($prev, $page_name){
        return '<li class="page-item" aria-current="page">
        <a href="'.$page_name.'?page='.$prev.'">&laquo;<span class="sr-only">(Previous)</span></a>
        </li> ';
    }

    function nextStr($next, $page_name){
        return '<li class="page-item" aria-current="page">
        <a href="'.$page_name.'?page='.$next.'">&raquo;<span class="sr-only">(Next)</span></a>
        </li>';
    }
  
    function total_pages($total_count){
        global $per_page;
        $total_pages = (int) $total_count/$per_page;
        return ceil($total_pages);
    }

    function offset($current_page){
        global $per_page;
        return $per_page * ( (int) $current_page - 1); 

    }

    function next_page($current_page, $total_pages){
        $next = $current_page + 1;
        return $next <= $total_pages ? $next : false;
    }

    function previous_page($current_page){
        $prev = $current_page - 1;
        return  $prev > 0 ? $prev : false;
    }

    function next_link($current_page, $total_count, $page_name){
        $next = next_page($current_page, total_pages($total_count));
        return ($next) ? nextStr($next, $page_name) : '';
       
    }

    function prev_link($current_page, $page_name){
        $prev = previous_page($current_page);
        return ($prev) ? prevStr($prev, $page_name) : '';
       
    }

    function paginated_str($current_page, $total_count, $page_name){
        // echo $total_count; exit;
        $str = ' <nav aria-label="Page navigation" class="item">
        <ul class="pagination d-flex justify-content-center"> ';
            $str.= prev_link($current_page, $page_name);
        for($i=1; $i<= total_pages($total_count); $i++){
            $one = (int) $current_page === $i ? 'one' : '';
           $str.=' <li class="page-item">
           <a href="'.$page_name.'?page='.$i.'" tabindex="-1" aria-disabled="true" class="'.$one.'">'.$i.'</a>
            </li>';
        }
        $str.= next_link($current_page, $total_count, $page_name);
        $str .= ' </ul></nav> ';
        return $str;

    }



?>