<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '/var/www/html/app/libraries/payments/PaymentLib.php';
class PaymentTest extends TestCase {

    public function setUp() {
        parent::setUp();

        Session::start();

        // Enable filters
        Route::enableFilters();
    }

    /**
     * getting all payment methods which are actively available
     */
    public function testAllPaymentMethods() {


        $all_paymnet_methods = Payment::getAllPaymentMethods("A", 'en');

        if (count($all_paymnet_methods) > 0) {
            $this->assertTrue(true);
        }
    }

    public function testPaypro() {



        $sandbox = TRUE;

// Set PayPal API version and credentials.
        $api_version = '109.0';
        $api_endpoint = $sandbox ? 'https://api-3t.sandbox.paypal.com/nvp' : 'https://api-3t.paypal.com/nvp';
        $PayPalApiUsername = $sandbox ? 'azeem_api1.greenmediapartners.com' : 'LIVE_USERNAME_GOES_HERE';
        $PayPalApiPassword = $sandbox ? 'K8SA8BHJQ9QCUVMH' : 'LIVE_PASSWORD_GOES_HERE';
        $PayPalApiSignature = $sandbox ? 'AFPSwPtbnm0eo94uetHcCp68KjEBAs3WjNkPyyObkrQ4wXx0Ysh5ExJL' : 'LIVE_SIGNATURE_GOES_HERE';


        // Store request params in an array
        $request_params = array
            (
            'USER' => $PayPalApiUsername,
            'PWD' => $PayPalApiPassword,
            'SIGNATURE' => $PayPalApiSignature,
            'VERSION' => $api_version,
            'PAYMENTACTION' => 'Sale',
            'IPADDRESS' => "127.0.0.0",
            'CREDITCARDTYPE' => 'Visa',
            'ACCT' => '4032038598998155',
            'EXPDATE' => '112019',
            'CVV2' => '323',
            'FIRSTNAME' => 'Tester',
            'LASTNAME' => 'Testerson',
            'STREET' => '707 W. Bay Drive',
            'CITY' => 'Largo',
            'STATE' => 'FL',
            'COUNTRYCODE' => 'US',
            'ZIP' => '33770',
            'AMT' => '100.00',
            'CURRENCYCODE' => 'USD',
            'DESC' => 'Testing Payments Pro'
        );

        // Loop through $request_params array to generate the NVP string.
        $nvp_string = '';
        foreach ($request_params as $var => $val) {
            $nvp_string .= '&' . $var . '=' . urlencode($val);
        }
        $padata = $nvp_string;
        $PaymentLib = new PaymentLib();
        $response = $PaymentLib->postToPaypal('DoDirectPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, ".sandbox");

        if ("SUCCESS" == strtoupper($response["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($response["ACK"])) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }


    function test2checkout() {

        $cart_order_id = 95;
        $order_id = 95;
        $payment_method=34;
        $order_info = OrderLib::getOrderinfo($order_id)->get()->toArray();
        $order_info = $order_info[0];
        $order_info['cart_order_id'] = $cart_order_id;
         //get the paymnet method more option 
        $payment = Payment::find($payment_method);
        $data = unserialize($payment->processor_params);
        $processor_data = PaymentLib::getProcessorData($data, "2checkout.php");
        $is_test = ($processor_data['processor_params']['mode'] == 'test') ? 'Y' : 'N';
        $order_info['is_test'] = $is_test;
        $pdata = TwoCheckoutLib::generateOrderdata($order_info, $payment_method, $processor_data['processor_params']['account']);

        if (Count($pdata) > 0) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }
    
    
    

}
