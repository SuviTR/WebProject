<?php
/**
 * Author: suviTR & heikkeket
 * Date: 26.4.2019
 * Time: 11.55
 */
class Database{

    //Specify your own database credentials
    private $hostname = "localhost";
    private $db_name = "webproject";
    private $username = "webuser";
    private $password = "webpass";
    private $config = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    public $conn;

    //The database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->hostname
                . ";dbname=" . $this->db_name,
                $this->username, $this->password,
                $this->config);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

?>

