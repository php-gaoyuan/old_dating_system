<?php
class dbex {
    var $rowCount;
    var $perPage;
    var $currPage;
    var $totalPage;
    private $con=null;
    public function __construct()
    {
        if(!$this->con){
            global $dbServs;
            $this->con= dbtarget('r', $dbServs);
        }
    }

    public function setPages($perPage, $currPage = 1) {
        if (empty($currPage)) {
            $currPage = 1;
        }
        $this->perPage = $perPage;
        $this->currPage = $currPage;
    }
    public function setNopages() {
        $this->perPage = '';
    }
    public function getRs($sql,$type="") {
        $query_res = array();
        if ($this->perPage) {
            $sql_count = "select count(*) as total_count " . strstr($sql, "from"); //查询总数
            $result_count = mysqli_query($this->con,$sql_count);
            $data_count = mysqli_fetch_assoc($result_count);
            $this->rowCount = $data_count['total_count'];
            $sql.= " limit " . ($this->currPage - 1) * $this->perPage . "," . $this->perPage;
            //echo $this->rowCount;exit;
        }
        $result = mysqli_query($this->con,$sql);
        if ($this->perPage) {
            //return $this->rowCount;
            $total_rs = $this->rowCount;
            $per_page = $this->perPage;
            $curr_page = $this->currPage;
            $total_page = floor(abs($total_rs - 1) / $per_page) + 1; //总页数
            $this->totalPage = $total_page;
            //限制超页错误
            if ($curr_page > $total_page) {
                echo '<script type="text/javascript">history.go(-1);</script>';
                exit;
            }
        }
        //echo "<pre>";print_r($sql);//exit;
        //echo $this->totalPage;exit;
        if($type=='arr'){
            while ($rsRow = mysqli_fetch_assoc($result)) {
                $query_res[] = $rsRow;
            }
        }else{
            while ($rsRow = mysqli_fetch_array($result)) {
                $query_res[] = $rsRow;
            }
        }
        mysqli_free_result($result);
        return $query_res;
    }
    public function getALL($sql,$type="") {
        $this->setNopages();
        return $this->getRs($sql,$type);
    }
    public function getRow($sql,$type="") {
        $result = mysqli_query($this->con,$sql);
        if($type=='arr'){
            $data = mysqli_fetch_assoc($result);
            return $data;
        }
        $data = mysqli_fetch_array($result);
        mysqli_free_result($result);
        return $data;
    }
    public function exeUpdate($sql) {
        if (mysqli_query($this->con,$sql)) {
            return mysqli_affected_rows($this->con);
        } else {
            return false;
        }
    }
    public function create($sql) {
        $result = mysqli_query($this->con,$sql);
        $create = mysqli_fetch_array($result);
        mysqli_free_result($result);
        return $create;
    }
    public function affected_rows($sql) {
        return mysqli_affected_rows($this->con);
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        if($this->con) mysqli_close($this->con);
    }
}
?>
