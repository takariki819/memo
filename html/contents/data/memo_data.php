<?php 
require("login.php");

class Data extends Login{
    private $pdo;
    function __construct(){
        parent::__construct();
        $this->pdo=parent::getPdo();
    }
    public function memo(){
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $action=filter_input(INPUT_GET,"action");
            switch($action){
                case "add":
                    $this->add();
                    break;
                case "edit":
                    $b=$this->search_data();
                    echo json_encode($b);
                    break;
                case "toggle":
                    $this->toggle();
                    break;
                case "delete":
                    $this->delete();
                    break;
                case "save":
                    $this->save();
                    break;
            }
            exit;
        }
    }
    public function save(){
        $id=filter_input(INPUT_POST,"id");
        $title=filter_input(INPUT_POST,"title");
        $comment=filter_input(INPUT_POST,"comment");
        $stmt=$this->pdo->prepare("UPDATE memo SET title=:title , comment=:comment WHERE id=$id");
        $stmt->bindValue("title",$title,\PDO::PARAM_STR);
        $stmt->bindValue("comment",$comment,\PDO::PARAM_STR);
        $stmt->execute();
    }
    public function delete(){
        $id=filter_input(INPUT_POST,"id");
        $this->pdo->query("DELETE FROM memo WHERE id=$id");
    }
    public function toggle(){
        $id=filter_input(INPUT_POST,"id");
        $this->pdo->query("UPDATE memo SET favorite=NOT favorite WHERE id=$id");
    }
    public function search_data(){
        $key=filter_input(INPUT_POST,"key");
        $stmt=$this->pdo->prepare("SELECT * FROM memo WHERE title LIKE :key OR comment LIKE :key");
        $stmt->bindValue("key",'%'.$key.'%',\PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function add(){
        $title=filter_input(INPUT_POST,"title");
        $comment=filter_input(INPUT_POST,"comment");
        $stmt=$this->pdo->prepare("INSERT INTO memo(title,comment) VALUES(:title,:comment)");
        $stmt->bindValue("title",$title,\PDO::PARAM_STR);
        $stmt->bindValue("comment",$comment,\PDO::PARAM_STR);
        $stmt->execute();
    }
    public function get_favorite_data(){
        $stmt=$this->pdo->query("SELECT * FROM memo WHERE favorite=1");
        return $stmt->fetchAll();
    }
}
?>