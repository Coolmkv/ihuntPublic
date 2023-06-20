<?php

if(!function_exists('renderDataTable')){
    function renderDataTable(CI_DB $db){
        $draw = intval($_GET["draw"]??$_POST["draw"]??0);
        $start = intval($_GET["start"]??$_POST["start"]??0);
        $length = intval($_GET["length"]??$_POST["length"]??0);
        $db_count = clone $db;
        $total_count = $db_count->get()->num_rows();
        if($length && $start){
            $query = $db->limit($length,$start);
        }
        $columns = $_GET["columns"]??$_POST["columns"]??[];
        $search = $_GET["search"]??$_POST["search"]??[];
        if(is_array($columns) && count($columns)){
            $i=0;
            foreach($columns as $column){
                 
                if(!empty($column["name"])){
                    
                    if(!empty($column["searchable"]) && !empty($search["value"])){
                        if($search["regex"]=='true'){
                            if($i==0){
                                $i++;
                            }
                            $query = $query->or_where($column["name"],$search["value"]);
                        }else{
                            $query = $query->or_like($column["name"],$search["value"]);
                        }
                        
                    }
                    if(!empty($column["searchable"]) && !empty($column["search"]["value"])){
                        if($column['search']['regex']=="true"){
                            $query = $query->or_where($column["name"],$column["search"]["value"]);
                        }else{
                            $query = $query->or_like($column["name"],$column["search"]["value"]);
                        }
                        
                    }
                }
            }
        }
        $data =  $db->get();
        $rows = $data->result();
        $i = $start;
        foreach($rows as $item){
            $i++;
            $item->dataRowNum = $i;
             
        }
        $result = array(
            "draw" => $draw,
              "recordsTotal" => $total_count,
              "recordsFiltered" => $data->num_rows(),
              "data" => $rows,
              "query"=>[
                "last_query"=>$db->last_query()
              ]
         );
         echo json_encode($result);
        
    }

    
}
if(!function_exists("getTotal")){
    function getTotal(CI_DB $db){
        return $db->get()->num_rows();
    }
}

if(!function_exists("unAuthenticMessage")){
    function unAuthenticMessage(){
        return ["status"=>"failure","message"=>"Not logged in.","data"=>null];
    }
}
