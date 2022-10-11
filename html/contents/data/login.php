<?php 
date_default_timezone_set('Asia/Tokyo');
session_start();
require("pw.php");
class Login{
    private $pdo;
    function __construct(){
        $this->pdo=new PDO($_SESSION["db"],$_SESSION["user"],$_SESSION["pw"]);
    }
    public function log(){
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $action=filter_input(INPUT_GET,"action");
            switch($action){
                case "login":
                    $b=$this->login();
                    echo json_encode($b);
                    break;
                case "logout":
                    $this->logout();
                    break;
                case "log_check":
                    $b=$this->log_check();
                    echo json_encode($b);
                    break;
            }  
            exit;
        }
    }
    public function log_check(){
        if(isset($_SESSION["token"])){
            return true;
        }else{
            return false;
        }
    }
    public function login(){
        $pw=filter_input(INPUT_POST,"pw");
        $stmt=$this->pdo->query("SELECT * FROM login WHERE id=$pw");
            if(!empty($stmt->fetch())){
                $_SESSION["token"]=rand();
                return true;
            }else{
                return false;
            }
    }
    public function logout(){
        unset($_SESSION["token"]);
    }
    public function getPdo(){
        return $this->pdo;
    }
}

class token_set{
    function __construct(){
        if(!isset($_SESSION["token"])){
            echo "<a href=../../index.php>
            <font size='45px'>loginしてください</font>
            </a>";
            exit;
        }
    }
}
?>