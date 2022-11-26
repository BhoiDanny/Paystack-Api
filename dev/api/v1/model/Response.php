<?php
namespace SannyTech;

   class Response
   {
      private $success;
      private $httpStatusCode;
      private $message = array();
      private $data;
      private $toCache = false;
      private $crossOrigin = false;
      private $responseData = array();

      public function setSuccess($success)
      {
         $this->success = $success;
      }

      public function setStatusCode($httpStatusCode)
      {
         $this->httpStatusCode = $httpStatusCode;
      }

      public function setMessage($message)
      {
         $this->message[] = $message;
      }

      public function setData($data)
      {
         $this->data = $data;
      }

      public function toCache($toCache)
      {
         $this->toCache = $toCache;
      }

      public function crossOrigin($crossOrigin)
      {
         $this->crossOrigin = $crossOrigin;
      }

      public function send()
      {
         header('Content-type: application/json;charset=utf-8');

            if ($this->toCache === true) {
               header('Cache-control: max-age=60');
            } else {
               header('Cache-control: no-cache, no-store');
            }

            if ($this->crossOrigin === true) {
               header('Access-Control-Allow-Origin: *');
            }

            if (($this->success !== false && $this->success !== true) || !is_numeric($this->httpStatusCode)) {
               http_response_code(500);
               $this->responseData['statusCode'] = 500;
               $this->responseData['success'] = false;
               $this->setMessage("Response Error");
               $this->responseData['response'] = $this->message;
            } else {
               http_response_code($this->httpStatusCode);
               $this->responseData['statusCode'] = $this->httpStatusCode;
               $this->responseData['success'] = $this->success;
               $this->responseData['response'] = $this->message;
               $this->responseData['data'] = $this->data;
            }

            echo json_encode($this->responseData);

      }

      public function sendResponse()
      {
         header('Content-type: application/json;charset=utf-8');

            if ($this->toCache === true) {
               header('Cache-control: max-age=60');
            } else {
               header('Cache-control: no-cache, no-store');
            }

            if ($this->crossOrigin === true) {
               header('Access-Control-Allow-Origin: *');
            }

            if (($this->success !== false && $this->success !== true) || !is_numeric($this->httpStatusCode)) {
               http_response_code(500);
               $this->responseData['statusCode'] = 500;
               $this->responseData['success'] = false;
               $this->setMessage("Response Error");
               $this->responseData['response'] = $this->message;
            } else {
               http_response_code($this->httpStatusCode);
               $this->responseData['statusCode'] = $this->httpStatusCode;
               $this->responseData['success'] = $this->success;
               $this->responseData['response'] = $this->message;
               $this->responseData['data'] = $this->data;
            }

            return json_encode($this->responseData);

      }

   }