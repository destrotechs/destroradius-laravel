<?php
namespace Morris\Mpesa;
class Mpesa
{
    /*
        This package is designed to be incoroporated in laravel based
        application for easier mobile money payment. Mpesa is a mobile
        money platform implemented and widely used in kenyan market. it involves
        sending and receiving money via safaricom service provider.
        also used to pay for goods  and services in kenyan context. allowed in
        the whole country


    */

    private $token_url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
    private $consumer_key = "XnhGnVVVB3bYgGrbpdV0EP3GHnjgH73b";
    private $secret_key = "9BTWePtrcgrVn8Oz";
    private $transactiontype='CustomerPayBillOnline';
    private $partyA="600995";//phone number
    private $partyB="174379";//business shortcode
    private $callbackurl="https://hewanet.co.ke/churchcallback/";
    private $accountreference="CompanyName";
    private $transactiondesc="describe your transaction";
    private $remark='your remark';
    private $process_request_url='https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    private $shortcode = "174379";//business shortcode
    private $lipa_na_mpesa_key = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
    private $accesstoken = "";
    private $query_stkpush_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
    private $timestamp= "";



    public function __construct(){
        self::getTimestamp();
        self::getPassword();
    }

    public function generateToken(){
		$curl=curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->token_url);
		$credentials = base64_encode($this->consumer_key.':'.$this->secret_key);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization:Basic '.$credentials));
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($curl, CURL_SSL_VERIFYPEER, false);
		$curl_response=curl_exec($curl);
        // dd($curl_response);
		return $this->accesstoken=json_decode($curl_response, true) ['access_token'];
        // $ch = curl_init('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
        // curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . base64_encode($this->consumer_key.':'.$this->secret_key)]);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_HEADER, false);
        // $response = curl_exec($ch);
        // // dd($response);
        // dd(json_decode($response));
    }
    public function getTimestamp(){
        $this->timestamp=date("yymdhis");
        return $this->timestamp;
    }
    public function getPassword(){
        $this->password=base64_encode($this->shortcode.$this->lipa_na_mpesa_key.$this->timestamp);

        return $this->password;
    }
    public function processRequest($phone,$amount){
        $curl=curl_init($this->process_request_url);
		// curl_setopt($curl, CURLOPT_URL, );
  		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->accesstoken));

        //the field values that mpesa api expects in order to process request
        //and send pay request to the customer via soap

        $postData=array(
			'BusinessShortCode'=>$this->shortcode,
			'Password'=>$this->password,
			'Timestamp'=>$this->timestamp,
			'TransactionType'=>$this->transactiontype,
			'Amount'=>'1',
			'PartyA'=>$phone,
			'PartyB'=>$this->partyB,
			'PhoneNumber'=>$phone,
			'CallBackURL'=>$this->callbackurl,
			'AccountReference'=>$this->accountreference,
			'TransactionDesc'=>$this->transactiondesc
		);
        //mpesa api endpoint expects json data, hence we convert array above to json
        $data=json_encode($postData);

        //send data to mpesa servers to hit the api
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HEADER, false);
		$curl_response=curl_exec($curl);

        /*
            mpesa returns status code '0' if the request was accepted, another
            value for specific error.
            you can check the documentation for the error codes

            www.developer.safaricom.co.ke/Documentation
        */
        // dd($curl_response);
        $request_status_code = json_decode($curl_response, true) ['ResponseCode']; //we are decoding because mpesa returns a json response

        //check if request succeeded and query the checkoutid to use to query status of transaction

        if($request_status_code == 0){
            $checkoutrequestid=json_decode($curl_response, true)['CheckoutRequestID'];

            return $checkoutrequestid;

        }else{

            return "failed!";

        }

    }

    //The function checks the status of the transaction using the checkoutrequestid returned by the processrequest

    public function querySTKPush($checkoutrequestid){

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->query_stkpush_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->accesstoken));


        $curl_post_data = array(
            'BusinessShortCode' => $this->shortcode,
            'Password' => $this->password,
            'Timestamp' => $this->timestamp,
            'CheckoutRequestID' => $checkoutrequestid,
        );
        //ofcourse we send json data
        $data = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HEADER, false);

        $curl_response = curl_exec($curl);

        // return $curl_response;
        //transaction result with status code 0 for success,anything else means transaction failed
        $transaction_resultCode=json_decode($curl_response, true)['ResultCode'];

        if($transaction_resultCode == 0){
            return "success";
        }else{
            return "failed!";
        }

    }
    public function getTransactionDetails(){
        $callbackinfo=json_decode(trim(file_get_contents("http://hewanet.co.ke/churchcallback/callback.txt")),true);
        $resData=$callbackinfo['Body']['stkCallback']['CallbackMetadata']['Item'];
        $details = array();

        if($resData!=NULL 	&& $resData!=""){
            foreach ($resData as $key => $metadata) {
                if($metadata['Name']=="Amount"){
                    $payed_amount=$metadata['Value'];
                    array_push($details,$payed_amount);
                }else if($metadata['Name']=="MpesaReceiptNumber"){
                    $payment_id=$metadata['Value'];
                    array_push($details,$payment_id);
                }else if($metadata['Name']=="TransactionDate"){
                    $payment_date=$metadata['Value'];
                    array_push($details,$payment_date);
                }else if($metadata['Name']=="PhoneNumber"){
                    $payment_phone=$metadata['Value'];
                    array_push($details,$payment_phone);
                }
            }//end foreach
        }
        //the details array contains values of ['amount','mpesaid','date','phonenumber']
        return $details;
    }

}


?>
