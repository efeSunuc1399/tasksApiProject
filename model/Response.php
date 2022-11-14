<?php

class Response {

    private $_success;
    private $_httpStatusCode;
    private $_messages;
    private $_data;
    private $_toCache;
    private $_responseData = array();

    public function setSuccess($success){
        $this->_success = $success;
    }

    public function setHttpStatusCode($httpStatusCode){
        $this->_httpStatusCode = $httpStatusCode;
    }

    public function addMessages($message){
        $this->_messages[] = $message;
    }

    public function setData($data){
        $this->_data = $data;
    }

    public function toCache($toCache){
        $this->_toCache = $toCache;
    }

    public function send() {
        header('Content-type: application/json;charset=utf-8');

        if($this->_toCache == true){
            header('Cache-control: max-age=3600');
        } else {
            // When you set it to 'no-cache and no-store' it will always retrieve the data from the server
            header('Cache-control: no-cache, no-store');
        }

        // Here we check whether if '_success' is a boolean or 'httpStatusCode' is a numeric value
        if(($this->_success !== false && $this->_success !== true) || !is_numeric($this->_httpStatusCode)){
            // this function outputs status code only on devtools so we want status code to be seen in dev tools if the 'if statement' above eveluates to true
            http_response_code(500);

            // 500 stands for 'SERVER ERROR'
            $this->_responseData['statusCode'] = 500;
            $this->_responseData['success'] = false;
            $this->addMessages("Response Creation Error");
            $this->_responseData['messages'] = $this->_messages;
        } else {
            http_response_code(200);

            $this->_responseData['statusCode'] = $this->_httpStatusCode;
            $this->_responseData['success'] = $this->_success;
            $this->_responseData['messages'] = $this->_messages;
            $this->_responseData['data'] = $this->_data;
        }

        echo json_encode($this->_responseData);
    }

}