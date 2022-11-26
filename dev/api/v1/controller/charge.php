<?php
   require_once('../../../vendor/autoload.php');
   use SannyTech\Response;

   if(array_key_exists('email',$_POST) && array_key_exists('amount',$_POST)){
      $email    = trim($_POST['email']);
      $amt      = trim($_POST['amount']);
      $amount   = (int)$amt * 100;
      $tel      = trim($_POST['phone']);
      $provider = trim($_POST['provider']);
      $phone    = '0551234987';

      $token = 'sk_test_70c2757e0f5cafc1513b10426802c7a03a4f3e38';

      /*Generate sequence o numbers in a given string*/
      $sequence = substr(str_shuffle(str_repeat($x='0123456789', ceil(15/strlen($x)) )),1,15);

      if((empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) && empty($amount) || !is_numeric($amount)){
         $response = new Response();
         $response->setSuccess(false);
         $response->setStatusCode(400);
         $response->setMessage("Invalid email or amount");
         $response->send();
         exit;
      } else {
         $url = 'https://api.paystack.co/charge';

         $fields_string =  [
            'email' => $email,
            'amount' => $amount,
            'mobile_money' => [
               'phone' => $phone,
               'provider' => $provider
            ],
            'metadata' => [
               'custom_fields' => [
                  [
                     'display_name' => 'Mobile Number',
                     'variable_name' => 'mobile_number',
                     'value' => $tel
                  ]
               ]
            ],
            'reference' => $sequence
         ];

         $ch = curl_init();

         curl_setopt_array($ch, array(
            CURLOPT_URL => $url,

            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($fields_string),
            CURLOPT_HTTPHEADER => array(
               "Authorization: Bearer $token",
               "Content-Type: application/json"
            ),
         ));

         $res = curl_exec($ch);
         $err = curl_error($ch);

         curl_close($ch);

         if($err) {
            $response = new Response();
            $response->setSuccess(false);
            $response->setStatusCode(400);
            $response->setMessage("cURL Error #:" . $err);
         } else {

            $serverResponse = json_decode($res, true);

            $results = array();
            foreach($serverResponse as $key => $value) {
               $results[$key] = $value;
            }

            /*convert results to object*/
            $serve = (object)$results;
            $response = new Response();

            if(!$serve->status) {
               $response->setSuccess(false);
               $response->setStatusCode(400);
               $response->setMessage($serve->message);
            } else {
               $response->crossOrigin(true);
               $response->setSuccess(true);
               $response->setStatusCode(200);
               $response->setMessage("Payment Successful");
               $response->setData($results);
            }
         }
         $response->send();
         exit;

      }
   } else {
      $response = new Response();
      $response->setStatusCode(405);
      $response->setSuccess(false);
      $response->setMessage("Request method not allowed");
      $response->send();
      exit;
   }