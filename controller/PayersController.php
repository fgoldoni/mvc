<?php

class PayersController extends Controller{
    
    private $pwd='7RSDGNQFWWJ455WF';
    private $user='triplea1191_api1.gmail.com';
    private $signature='AFcWxV21C7fd0v3bYYYRCpSSRl31AJgMXGgQBm-WRFIY.r3K0zfu1B9R';
    private $endpoint = "https://api-3t.sandbox.paypal.com/nvp";
    private $RETURNURL="/webroot/payers/process";
    private $CANCELURL="/webroot/payers/cancel";
    
    public function init($user = false, $pwd = false, $signature = false, $prod = false){
		if($user){
			$this->user = $user;
		}
		if($pwd){
			$this->pwd = $pwd;
		}
		if($signature){
			$this->signature = $signature;
		}
		if($prod){
			$this->endpoint = str_replace('sandbox.','', $this->endpoint);
		}
	}

    public function request($method, $params){
		$params = array_merge($params, array(
				'METHOD' => $method,
				'VERSION' => '74.0',
				'USER'	 => $this->user,
				'SIGNATURE' => $this->signature,
				'PWD'	 => $this->pwd
		));
		$params = http_build_query($params);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $this->endpoint,
			CURLOPT_POST=> 1,
			CURLOPT_POSTFIELDS => $params,
			CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_SSLVERSION => 6,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_VERBOSE => 1
		));
		$response = curl_exec($curl);
		$responseArray = array();
		parse_str($response, $responseArray);
		if(curl_errno($curl)){
			$this->errors = curl_error($curl);
			curl_close($curl);
			return false;
		}else{
			if($responseArray['ACK'] == 'Success'){
				curl_close($curl);
				return $responseArray;
			}else{
				$this->errors = $responseArray;
				curl_close($curl);
				return false;
			}
		}
	}
    public function paypal() { 
        $port=10;         
        $totalttc=$_SESSION['total'];
        $params=array(            
            'RETURNURL'=>   Lien.$this->RETURNURL,
            'CANCELURL'=>  Lien.$this->CANCELURL,
            'PAYMENTREQUEST_0_AMT'=>$totalttc + $port,
            'PAYMENTREQUEST_0_CURRENCYCODE'=>'EUR',
            'PAYMENTREQUEST_0_SHIPPINGAMT'=>$port,
            'PAYMENTREQUEST_0_ITEMAMT'=>$totalttc
        );
        $products=$_SESSION['products'];
        foreach ($products as $k=>$product){
            $params["L_PAYMENTREQUEST_0_NAME$k"]=$product->name;
            $params["L_PAYMENTREQUEST_0_DESC$k"]=$product->description;
            $params["L_PAYMENTREQUEST_0_AMT$k"]=$product->price;
            $params["L_PAYMENTREQUEST_0_QTY$k"]=$_SESSION['panier'][$product->id];
            
        }
        $response = $this->request('SetExpressCheckout', $params);
        if($response){            
	$paypal = 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token=' . $response['TOKEN'];
        header("Location: $paypal");        
        }else{
	var_dump($this->errors);
	die('Erreur ');
    }}  
    
    public function process() {
        //***********************************************
        $headers = 'From: Goldoni <fgoldonid1@fgoldoni.de>'."\r\n";
        $headers.= "Reply-to: \"Goldoni\" <triplea1191@gmail.com>"."\r\n";
        $boutique='triplea1191@gmail.com';
        $headers .= 'Mime-Version: 1.0'."\r\n";
        $boundary = md5(uniqid(microtime(), TRUE));
        $headers .= 'Content-Type: multipart/mixed;boundary='.$boundary."\r\n";
        $headers .= "\r\n";
         // Subject
        $subject = 'Confirmation de votre Commande et details';
 
        // clé aléatoire de limite
        
        //*****************************************
        if(!isset($_GET['token'])&&!isset($_GET['PayerID']))$this->redirect('products/panier');
        $port=10;
        $totalttc=$_SESSION['total'];
        $response = $this->request('GetExpressCheckoutDetails', array(
	'TOKEN' => $_GET['token']
       ));
        $data['buyerName'] = $response['LASTNAME']; 
        $data['buyerVorname'] = $response['FIRSTNAME'];
        $data['buyerCode'] = $response['COUNTRYCODE'];
        $data['buyerNamen'] = $response['SHIPTONAME'];
        $data['buyerStrasse'] = $response['SHIPTOSTREET'];
        $data['buyercity'] = $response['SHIPTOCITY'];
        $data['buyerPLZ'] = $response['SHIPTOZIP'];
        $data['buyerCountry'] = $response['SHIPTOCOUNTRYNAME'];
        $data['buyerWarung'] = $response['CURRENCYCODE'];
        $data['buyerPrice'] = $response['AMT'];
        $data['buyerTravel'] = $response['SHIPPINGAMT'];
        $data['buyerEmail'] = $response['EMAIL'];
        $products=$_SESSION['products'];        
        $file_name =IMAGE.DS.'image.png';
        //echo $message;
        $email=$_SESSION['User']->email;
        
        
         
        if($response){
           if($response['CHECKOUTSTATUS'] == 'PaymentActionCompleted'){
             $_SESSION['span']='Ce paiement a déjà été validé';
             $this->redirect('products/panier');
             exit();
          }
          }else{
                        var_dump($this->errors);
                        $this->Session->setFlash('Ce paiement a déjà été validé','error');
                        $this->redirect('products/panier');
                        exit();
           }
            $params = array(
                        'TOKEN' => $_GET['token'],
                        'PAYERID'=> $_GET['PayerID'],
                        'PAYMENTACTION' => 'Sale',
                        
                        'PAYMENTREQUEST_0_AMT' => $totalttc + $port,
                        'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR',
                        'PAYMENTREQUEST_0_SHIPPINGAMT' => $port,
                        'PAYMENTREQUEST_0_ITEMAMT' => $totalttc,
                );
                $products=$_SESSION['products'];
                foreach($products as $k => $product){
                        $params["L_PAYMENTREQUEST_0_NAME$k"]=$product->name;
                        $params["L_PAYMENTREQUEST_0_DESC$k"]='';
                        $params["L_PAYMENTREQUEST_0_AMT$k"]=$product->price;
                        $params["L_PAYMENTREQUEST_0_QTY$k"]=$_SESSION['panier'][$product->id];
                }
                $response = $this->request('DoExpressCheckoutPayment',$params);
                if($response){
                        var_dump($response);
                        //die(); important a sauvegarder
                        $id=$response['PAYMENTINFO_0_TRANSACTIONID'];
                        $_SESSION['span']='Paiement éffectué';
                        
                        //Envoi d'email
                        

                        // Function mail()
                        mail($boutique, $subject, $this->msg($this->address($data).$this->buyer().$this->message($products),$file_name,$boundary), $headers);
                        mail($email, $subject, $this->msg($this->message($products),$file_name,$boundary), $headers);
                        unset($_SESSION['panier']);
                        $this->redirect('products/panier');

                }else{
                        var_dump($this->errors);
                        $this->Session->setFlash('Ce paiement n\'a  été éffectuer','error');
                        $this->redirect('products/panier');
                        exit();
                }

}
    
}