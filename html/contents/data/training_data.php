<?php 
require("login.php");

class Training extends Login{
    private $pdo;
    function __construct(){
        parent::__construct();
        $this->pdo=parent::getPdo();
    }
    public function training(){
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $action=filter_input(INPUT_GET,"action");
            switch($action){
                case "menu_register":
                    $res=$this->register();
                    echo json_encode($res);
                    break;
                case "delete":
                    $res=$this->delete();
                    echo json_encode($res);
                    break;
                case "register_count":
                    $b=$this->register_count();
                    echo json_encode($b);
                    break;
                case "history":
                    $list=$this->history();
                    echo json_encode($list);
                    break;
                case "tr_delete":
                    $b=$this->tr_delete();
                    echo json_encode($b);
                    break;
            }
            exit;
        }
    }
    public function tr_delete(){
        try{
            $record=filter_input(INPUT_POST,"record");
            $this->pdo->query("DELETE FROM training WHERE id=$record");
        }catch(Exception $e){
            return false;
        }
        return true;
    }
    public function history(){
        $stmt=$this->pdo->query("SELECT * FROM training");
        return $stmt->fetchAll();
    }

    public function register_count(){
        try{
            $date=date('Y/m/d H:i:s');
            $stmt=$this->pdo->query("SHOW COLUMNS FROM training");
            $column_list=$stmt->fetchAll(PDO::FETCH_COLUMN);
            array_shift($column_list);
            array_pop($column_list);
            $column_array=[];
            $i=0;
            foreach($column_list as $column){
                    $column_array[$i]=(int)filter_input(INPUT_POST,$column);
                    $i++;
            }
            if(count($column_array) === 5){
                $this->pdo->exec("INSERT INTO training($column_list[0],$column_list[1],$column_list[2],$column_list[3],$column_list[4],dt) VALUES($column_array[0],$column_array[1],$column_array[2],$column_array[3],$column_array[4],'$date')");
            }
            if(count($column_array) === 4){
                $this->pdo->exec("INSERT INTO training($column_list[0],$column_list[1],$column_list[2],$column_list[3],dt) VALUES($column_array[0],$column_array[1],$column_array[2],$column_array[3],'$date')");
            }
            if(count($column_array) === 3){
                $this->pdo->exec("INSERT INTO training($column_list[0],$column_list[1],$column_list[2],dt) VALUES($column_array[0],$column_array[1],$column_array[2],'$date')");
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }
        return [$column_list , $column_array];
    }

    public function delete(){
        try{
            $target_column=filter_input(INPUT_POST,"column");
            $this->pdo->query("ALTER TABLE training DROP COLUMN $target_column");
        }catch(Exception $e){
            return $e->getMessage();
        }
        return true;
    }
    public function register(){
        try{
            $column=filter_input(INPUT_POST,"val");
            $this->pdo->query("ALTER TABLE training ADD $column varchar(10)");
            $this->pdo->query("ALTER TABLE training MODIFY dt DATETIME AFTER $column");
        }catch(Exception $e){
            return $e->getMessage();
        }
        return true;
    }
    public function get_training_column(){
        $stmt=$this->pdo->query("SHOW COLUMNS FROM training");
        $column=$stmt->fetchAll(PDO::FETCH_COLUMN);
        return $column;
    }
}
?>