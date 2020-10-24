<?php
function halt($data=[]){
    echo "<pre style='color:red'>";
    print_r($data);
    exit("</pre>");
}
function json($data=array()){
    header('content-type:application/json;charset=utf-8');
    return json_encode($data);
}