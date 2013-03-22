<?php

/**
 * Description of conexao
 *
 * @author fernando
 */

abstract class MainConnection {

    static    $connection;
    protected $table;
    protected $primaryKey;
    protected static $debug = array();
    protected $errors=array();

    /**
     * @method __construct
     * @return $this->connection
     */
    public function __construct() {
        global $bdconfig;
        if (!$this->connection) {
            $this->connection = new mysqli($bdconfig['server'], $bdconfig['user'], $bdconfig['password'], $bdconfig['database']);
            if (mysqli_connect_errno()) {
                trigger_error(mysqli_connect_error());
            }
            $this->connection->set_charset("utf8");
        }
    }

    public function __destruct() {
        global $config;
        if($config['debug']){
            echo "<div style='word-wrap:break-word; position:fixed; bottom:0; border: 1px solid red; width:auto; padding:10px; font-size:9px;'><pre>";
            echo "<p>ERROS<p>";
            print_r($errors);
            echo "<p>DEBUG</p>";
            print_r($this->debug);
            echo "</pre></div>";
        };
    }

    public function setTable($table) {
        $this->table = $table;
    }

    public function setPrimaryKey($primaryKey) {
        $this->primaryKey = $primaryKey;
    }


    public function execSQL($query){
        $this->debug[]= $query;
        $result = $this->connection->query($query);
        if($result){
            return $result;
        } else {
            $this->errors = $this->connection->error;
            exit;
        }

    }

    public function listAll($where=null,$order=null,$limit=null){
        $query = "SELECT * FROM " . $this->table;
        if(!is_null($where)){$query .= " WHERE " . $where; }
        if(!is_null($order)){$query .= " ORDER BY " . $order; }
        if(!is_null($limit)){$query .= " LIMIT  " . $limit; }
        return $this->execSQL($query);
    }

    public function listByKey($key){
        $query = "SELECT * FROM " . $this->table . " WHERE " . $this->primaryKey . "='" . $key ."'";
        return $this->execSQL($query);
    }

    public function insert($data){
        $query = 'INSERT INTO ' . $this->table . ' (';
        $fields = count($data);
        $counter = 0;
        foreach($data as $field=>$value){
            $fields .= "$field";
            $values .= "'$value'";
            $counter++;
            if($counter != $fields){
                $fields .= ",";
                $values .= ",";
            }
        }
        $query .= $campos . ") VALUES (" . $values . ")";
        return $this->execSQL($query);
    }

    public function update($key, $data){
        $query = "UPDATE " . $this->table . " SET ";
        $fields = count($data);
        $counter = 0;
        foreach($data as $field=>$value){
            $query .="$field = '$value'";
            $counter++;
            if($counter != $fields){
                $query .= ",";
            }
        }
        $query .= " WHERE " . $this->primaryKey . " = '$key'";
        return $this->execSQL($query);
    }

    public function updateByField($fieldKey, $key, $data){
        $query = "UPDATE " . $this->table . " SET ";
        $fields = count($data);
        $counter = 0;
        foreach($data as $field=>$value){
            $query .="$field = '$value'";
            $counter++;
            if($counter != $fields){
                $query .= ",";
            }
        }
        $query .= " WHERE " . $fieldKey . " = '$key'";
        return $this->execSQL($query);
    }

}