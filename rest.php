<?php

        require_once('constants.php'); //Call the Global File-name   

        class Rest {

            protected $request;
            protected $serviceName;
            protected $param;

            public function __construct(){
                if($_SERVER['REQUEST_METHOD'] !== 'POST'){ // validate the POST request
                    // echo "Method is not post.";
                    $this->throwError(REQUEST_METHOD_NOT_VALID, 'Request Method is Not Valid.');
                }

                $handler = fopen('php://input','r');
                $request =  stream_get_contents($handler);
                $this->validateRequest($request);
                
            }

            public function validateRequest($request){
                if($_SERVER['CONTENT_TYPE'] !== 'application/json'){
                    $this->throwError(REQUEST_CONTENTTYPE_NOT_VALID, 'Request Content Type is Not Valid.');
                }

                $data = json_decode($request, true); //Holder the request array value
                // print_r($data);

                if(!isset($data['name']) || $data['name'] == ""){
                    $this->throwError(API_NAME_REQUIRED, "API Name is Required.");
                }

                $serviceName = $data['param'];
               
                if(!is_array($data['param'])){
                    $this->throwError(API_PARAM_REQUIRED, "API PARAM is Required.");
                }

                $param = $data['param'];

            }

            public function processApi(){

            }

            public function validateParameter($fieldName, $value, $dataType, $required){

            }

            public function throwError($code, $message){
                header("content-type: application/json");
                $errorMsg = json_encode(['error' => ['status' => $code, 'message' => $message]]);
                echo $errorMsg;
                exit;
            }

            public function returnResponse(){

            }

        }



?>