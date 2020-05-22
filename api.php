<?php

        class Api extends Rest {

            public function __construct(){
                parent::__construct();
            }

            public function generateToken(){
                // print_r($this->param['pass']);
                $email = $this->validateParameter('email', $this->param['email'], STRING);
                $pass = $this->validateParameter('pass', $this->param['pass'], STRING);
                // echo $email;
                // echo $pass;

                try{
                    /* Start Query to Database */
                    include 'model.php';
                    $user = array();
                    $query_login = $model->login_method($email,$pass);
                    if($result = $model->fetch_data($query_login)){
                        $user['id'] = $result['user_id'];
                        $user['name'] = $result['name'];
                        $user['email'] = $result['email'];
                        $user['password'] = $result['password'];
                        $user['active'] = $result['active'];
                        $user['created_on'] = $result['created_on'];
                    }
                    /* End Query to Database */
                    if($user == null){
                        $this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
                    }
                    if($user['active'] == 1){
                        $this->returnResponse(USER_NOT_ACTIVE, "User is not activated. Please contact to administrator.");
                    }

                    /* Call to generate token */
                    $payload = [
                        'iat' => time(),
                        'iss' => 'localhost',
                        'expire' => time() + (60),
                        'user_id' => $user['id']
                    ];
                    $token = JWT::encode($payload, SECRETE_KEY); /* This will be your token generated */

                    $data = ['token' => $token];
                    $this->returnResponse(SUCCESS_RESPONSE, $data);
                    //echo $token; 
                    // print_r($user);
                }catch(Exception $e){
                    $this->throwError(JWT_PROCESSING_ERROR, $e->getMessage());
                }
                    
            }

            public function validate(){
                echo "pasok";
            }


        }






?>