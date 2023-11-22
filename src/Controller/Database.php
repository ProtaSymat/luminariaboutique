<?php
namespace Mathys\Controller;

    use PDO;
    use PDOException;

    class Database{
        protected $table;
        protected $format;
        protected $method;
        protected $lastResult;
        protected $data;
        protected $connexion;
        protected $query;
        
        private $availableKeys =["post","filters"];
        protected $filters;
        protected $post;

        private $host;
        private $username;
        private $password;
        private $port;
        private $db_name;

    
        private function loadConfig($db_name = null) {
            $config = file_get_contents('./configs/database.json');
            $config = json_decode($config, true);
            $this->db_name = $config['db_name'];
            $this->host = $config['host'];
            $this->port = $config['port'];
            $this->username = $config['user'];
            $this->password = $config['password'];
        }
    
        public function __construct($db_name = null) {
            $this->loadConfig($db_name);
            $this->connect();
        }

        public function prepare($sql) {
            return $this->connexion->prepare($sql);
        }
        
        private function connect() : bool {
            try {
                $connexion = new PDO("mysql:host=$this->host;port=$this->port;dbname=$this->db_name;charset=utf8mb4", $this->username, $this->password);
                $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connexion = $connexion;
                return true;
            } catch (PDOException $e) {
                die("Erreur connexion à la BDD" . $e->getMessage());
                return false;
            }
        }

        public function table($tablename)
        {
            $this->table = $tablename;
            return $this;
        }
        public function get($data){
            $this->method = "get";
            $this->makeQuery($data);
            return $this;
        }
        public function post($data){
            $this->method = "post";
            $this->makeQuery($data);
            return $this;
        }
        public function delete($data,$force = false){
            $this->method = "soft-delete";
            if($force){
                $this->method = "delete";
            }
            $this->makeQuery($data);
            return $this;
        }
        public function update($data){
            $this->method = "update";
            $this->makeQuery($data);
            return $this;
        }
        public function getData(){
            return $this->data;
        }
        public function makeQuery($data){
            $this->data = $data;
            $this->setFormat();
            $this->build();
        }
        public function getMethod(){
            return $this->method;
        }
        private function setFormat(){
            $format = "";
            switch ($this->method) {
                case 'post':
                    $format = "INSERT INTO %s %s VALUES %s ;";
                    break;
                case 'soft-delete':
                case 'update':
                    $format = "UPDATE %s SET %s WHERE %s ;";
                    break;
                case 'delete':
                    $format = "DELETE FROM %s WHERE %s ;";
                    break;
                case 'get':
                default:
                    $format = "SELECT %s FROM %s WHERE %s ;";
                    break;
            }
            $this->format = $format;
        }
        public function getFormat(){
            return $this->format;
        }
        public function getQuery(){
            return $this->query;
        }
        public function getTable(){
            return $this->table;
        }
        public function setColumns(){
    
        }
        public function makeColumnName($raw){
            if(is_string($raw)){
                if($raw == "*"){
                    return $raw;
                }
                else{
                    $raw = '`'.$raw.'`';
                } 
            }
            return $raw;
        }
        public function makeSqlValue($raw){
                    if(is_string($raw)){
                        $raw = '"'.$raw.'"';
                    } 
                    if($raw === true){
                        $raw = 'TRUE';
                    }
                    if($raw === false){
                        $raw = 'FALSE';
                    }
                    return $raw;
        }
        public function makeListing($list =[], $separator = "," ,$prefix ="", $suffix = "", $sqlVal = false,$encapsuler = ""){
            $res = $prefix;
            $index = 0;
            foreach ($list as $value) {
                if($sqlVal){
                    $res .= $this->makeSqlValue($value);
                } else {
                    $res .= $encapsuler . $value . $encapsuler;
                }
                
                if(!(count($list) == ($index + 1 ))){
                    $res .= $separator;
                }
                $index += 1;
            }
            $res .= $suffix;
            return $res;
        }
        public function parseParams($dataKey = 'filters', $separatedBy = " AND "){
            $res = "1";
            if(isset($this->getData()[$dataKey])){
                $res = "";
                $this->setParams($dataKey,$this->getData()[$dataKey])  ;
                $filters = [];
                foreach ($this->getParams($dataKey) as $key => $filter) {
                    if (is_array($filter) && $filter[0] === 'LIKE') {
                        $filterValue = $this->makeSqlValue($filter[1]);
                        $filters[] = "$key LIKE $filterValue";
                    } else {
                        $filterValue = $this->makeSqlValue($filter);
                        $filters[] = "$key = $filterValue";
                    }
                }
                $res .= implode($separatedBy, $filters);
            }
            return $res;
        }
    
        private function setParams($key,$data){
            if(in_array($key,$this->availableKeys)){
                $this->$key = $data ;
                return $this;
            }
        }
        public function getParams($key){
            if(in_array($key,$this->availableKeys)){
                return $this->$key;
            }
        }
        private function setQuery($query){
            $this->query = $query;
            return $this;
        }

        public function lastInsertId() {
            return $this->connexion->lastInsertId();
        }
        private function build(){
            switch ($this->getMethod()) {
                case 'post':
                    $query = "";
    
                    if(isset($this->data['post'])){
                        $columns = array_keys($this->data["post"]);
                        foreach($columns as $key => $value){
                            $columns[$key] = $this->makeColumnName($value);
                        }
                        $columns = $this->makeListing($columns, ',', '(',')');
                        $values = $this->makeListing($this->data['post'], ',', '(',')',true);
                        $query = sprintf($this->getFormat(), $this->table, $columns, $values);
                    }
                    break;
                case 'update':
                    $query = sprintf($this->getFormat(), $this->table, $this->parseParams('post', ' , '), $this->parseParams());
                    break;
                case 'soft-delete':
                    $query = sprintf($this->getFormat(), $this->table, "`status` = \"offline\"", $this->parseParams());
                    break;
                case 'delete':
                    $query = sprintf($this->getFormat(), $this->table, $this->parseParams());
                    break;
                case 'get':
                    $columns = "*";
                    if(isset($this->data['cols'])){
                        $columns= $this->makeListing($this->data['cols'],',');
                        $columns = explode(",",$columns);
                        foreach($columns as $key => $value){
                            $columns[$key] = $this->makeColumnName($value);
                        }
                        $columns = implode(",",$columns);
                    }
                    
                    $query = sprintf($this->getFormat(),$columns, $this->table, $this->parseParams());
                    break;
                default:
                    $query = sprintf($this->getFormat(),"*", $this->table, $this->parseParams());
                    break;
            }
            $this->query = $query;
        }
        public function do() {
            try {
                if ($this->connexion) {
                    $this->lastResult = $this->connexion->query($this->getQuery());
            
                    if (!$this->lastResult) {
                        die('Erreur SQL: ' . $this->connexion->errorInfo()[2]);
                    }
                } else {
                    die('Erreur: La connexion à la base de données est nulle.');
                }
            
                return $this->lastResult;
            } catch (\PDOException $e) {
                die('Erreur PDO: ' . $e->getMessage());
            }
        }
        
        
        

        public function addUser($pseudo, $password, $mail, $role) {
        
            $query = $this->connexion->prepare("INSERT INTO utilisateurs (pseudo, password, mail, role) VALUES (?, ?, ?, ?)");
            $query->execute([$pseudo, $password, $mail, $role]);
        
            return $query->rowCount() > 0;
        }
        
        public function getUserByPseudo($pseudo) {
            $query = $this->connexion->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo");
            $query->bindParam(":pseudo", $pseudo);
            $query->execute();
        
            return $query->fetch(\PDO::FETCH_ASSOC);
        }

        public function resetPassword($pseudo, $password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
            $query = $this->connexion->prepare("UPDATE utilisateurs SET password = :password WHERE pseudo = :pseudo");
            $query->bindParam(":password", $hashedPassword);
            $query->bindParam(":pseudo", $pseudo);
        
            $query->execute();
            
            return $query->rowCount() > 0;
        }

        public function getUserByPseudoAndMail($pseudo, $mail) {
            $query = $this->connexion->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo AND mail = :mail");
            $query->bindParam(":pseudo", $pseudo);
            $query->bindParam(":mail", $mail);
            $query->execute();
        
            return $query->fetch(\PDO::FETCH_ASSOC);
        }
        
        public function updateUser($id, $pseudo, $mail, $telephone, $adresse) {

            $query = $this->connexion->prepare("UPDATE utilisateurs SET pseudo = :pseudo, mail = :mail, telephone = :telephone, adresse = :adresse WHERE id = :id");
            $query->bindParam(":pseudo", $pseudo);
            $query->bindParam(":mail", $mail);
            $query->bindParam(":telephone", $telephone);
            $query->bindParam(":adresse", $adresse);
            $query->bindParam(":id", $id);
        
            if($query->execute()) {
                return true;
            } else {
                return false;
            }
        }
}

