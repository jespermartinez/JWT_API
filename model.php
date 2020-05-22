<?php
  
        error_reporting(E_ERROR | E_PARSE);
        class model{

            function __construct() {
                try{
                    if(@$_SERVER['HTTP_HOST'] == 'localhost')
                        include($_SERVER["DOCUMENT_ROOT"]."/jwt_api/config.php");       
                    else
                        include($_SERVER["DOCUMENT_ROOT"]."/config.php");   

                    $this->dbhost = $host;
                    $this->dbuser = $db_user;
                    $this->dbpass = $db_password;            
                    $this->dbname = $db_name;
                    
                    $this->InitDB();
                }catch(Exception $e){
                    echo "Database Error ".$e->getMessage();
                }
            }


            function InitDB(){
                $this->con = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass)  or die(mysqli_error($this->con));
                mysqli_select_db($this->con, $this->dbname) or die(mysqli_error($this->con));  
            }

            public function fetch_data($post){
                return mysqli_fetch_assoc($post);
            } 
            public function query($post){
                return mysqli_query($this->con,$post);
            }
            public function numrows($post){
                return mysqli_num_rows($post);
            }

            /*  Query Method Call  */
            public function login_method($email,$pass){
                return $this->query('SELECT * FROM tbl_users WHERE email = "'.$email.'" AND password = "'.$pass.'"  ');
            }


        }

        $model = new model();

?>