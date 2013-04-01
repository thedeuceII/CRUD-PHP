<?php
/**
 * CRUD-PHP
 *
 * Basic CRUD to construct simple applications in PHP
 * @package CRUD-PHP
 * @author Wildiney Di Masi <criacao@wildiney.com>
 * @version 1.0
 * @license http://creativecommons.org/licenses/by-sa/3.0/legalcode
 * @link https://github.com/wildiney/CRUD-PHP.git
 */


/**
 * CLASS MainConnection
 *
 * @name MainConnection
 * @package CRUD-PHP
 */
abstract class MainConnection {
    /**
     * $connection
     *
     * Start the conection with the database
     *
     * @todo protect the static var
     * @access public
     * @name $connection
     * @staticvar string $connection
     * @var static
     */
    static    $connection;

    /**
     * $table
     *
     * Store the instance table name
     *
     * @name $table
     */
    /**#@+
     * @access protected
     * @var string
     */
    protected $table;

    /**
     * $primaryKey
     *
     * Store the table primary key
     *
     * @name $primaryKey
     */
    protected $primaryKey;
    /**#@-*/
    /**
     * $debug
     *
     * Help to debug the application
     *
     * @name $debug
     * @access protected
     * @var int
     */
    protected static $debug = array();

    /**
     * $errors
     *
     * Make an array with the errors
     *
     * @name $errors
     * @access protected
     * @var array
     */
    protected $errors=array();

    /**
     * Method Constructor
     *
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

    /**
     * Method __destruct
     *
     * If $debug is set as true, you'll see all sql variables.
     *
     * @global type $config
     */
    public function __destruct() {
        /**
         * Variable from config.inc.php
         */
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

    /**
     * Method setTable
     *
     * @access public
     * @param string $table
     * @return string
     */
    public function setTable($table) {
        $this->table = $table;
    }

    /**
     * Method setPrimaryKey
     *
     * @access public
     * @param string $primaryKey
     * @return string|int
     */
    public function setPrimaryKey($primaryKey) {
        $this->primaryKey = $primaryKey;
    }

    /**
     * Method execSQL
     *
     * @param string $query
     * @return string
     */
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

    /**
     * Method listAll
     *
     * Method to select all registers. Can be based in a single condition using $where
     *
     * @param string $where
     * @param string $order
     * @param int $limit
     * @return array
     */
    public function listAll($where=null,$order=null,$limit=null){
        $query = "SELECT * FROM " . $this->table;
        if(!is_null($where)){$query .= " WHERE " . $where; }
        if(!is_null($order)){$query .= " ORDER BY " . $order; }
        if(!is_null($limit)){$query .= " LIMIT  " . $limit; }
        return $this->execSQL($query);
    }

    /**
     * Method listByKey
     *
     * Method to select a register based on his primary key
     *
     * @param string $key
     * @return array
     */
    public function listByKey($key){
        $query = "SELECT * FROM " . $this->table . " WHERE " . $this->primaryKey . "='" . $key ."'";
        return $this->execSQL($query);
    }

    /**
     * Method insert
     *
     * Method to insert data
     *
     * @param array $data
     * @return bool
     */
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
        $query .= $fields . ") VALUES (" . $values . ")";
        return $this->execSQL($query);
    }

    /**
     * Method update
     *
     * Method to update data
     *
     * @param string $key
     * @param array $data
     * @return bool
     */
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

    /**
     * Method updateByField
     *
     * Method to update a register based in a field
     *
     * @param string $fieldKey
     * @param mixed $key
     * @param array $data
     * @return bool
     */
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