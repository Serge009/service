<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 26.06.14
 * Time: 12:43
 */

class Service{

    public static $data = array(
        "session" => "3e4ab9ab605a8fd8e12c03ff783e7640",//"41e492078d79082c43dbb8c6c1a57b5c",
        "uuid" => "666",
        "email" => "loh@example.com",
        "password" => "test",
        "license" => "5555555555",
        "versions" => array(
            "services" => 0,
            "products" => 0,
            "customers" => 0
        )
    );

    public static $url;

    public static function start(){
        //self::synch();
        //self::customersList();
        self::login();
        //self::setDefault();
        //self::users();
        //self::setDefault();
        //self::usersList();
        //self::setDefault();
        //self::ordersList();
        // self::logout();
    }

    private static  function synch(){
        $name = "Synchronization";
        self::$url = "synchronize";
        self::test($name);

    }

    private static  function logout(){
        $name = "Logout";
        self::$url = "logout";
        self::test($name);

        self::$data["session"] = "d07a5600b20b27a6dc4f27e1af535779";
        self::test($name);

        self::$data["license"] = "25";
        self::test($name);

        self::$data["email"] = "zxczxc";
        self::$data['uuid'] = 28;
        self::test($name);
    }

    private static  function customersList(){
        $name = "Customers List";
        self::$url = "customers";
        self::test($name);

        self::$data["session"] = "d07a5600b20b27a6dc4f27e1af535779";
        self::test($name);

        self::$data["uuid"] = "";
        self::test($name);

        self::$data["session"] = "41e492078d79082c43dbb8c6c1a57b5c";
        //self::$data['uuid'] = 28;
        self::test($name);
    }

    private static  function ordersList(){

        $name = "Orders List";
        self::$url = "orders/getList";
        self::test($name);

        self::$data["session"] = "";
        self::test($name);

        self::$data["uuid"] = "";
        self::test($name);

        self::$data["session"] = "41e492078d79082c43dbb8c6c1a57b5c";
        //self::$data['uuid'] = 28;
        self::test($name);
    }

    private static  function usersList(){
        $name = "Users List";
        self::$url = "users/getList";
        self::test($name);

        self::$data["session"] = "";
        self::test($name);

        self::$data["uuid"] = "";
        self::test($name);

        self::$data["session"] = "41e492078d79082c43dbb8c6c1a57b5c";
        //self::$data['uuid'] = 28;
        self::test($name);
    }

    private static  function users(){
        $name = "Users";
        self::$url = "users";
        self::test($name);

        self::$data["session"] = "";
        self::test($name);

        self::$data["uuid"] = "";
        self::test($name);

        self::$data["email"] = "zxczxc";
        self::$data['uuid'] = 28;
        self::test($name);
    }

    private static  function login(){
        $name = "Login";
        self::$url = "login";

        self::$data["email"] = "loh@example.com";
        self::$data["license"] = "5555555555";
        self::$data["password"] = "test";
        self::$data["session"] = "";
        self::$data["uuid"]= "ecace720494b8abe7963639a120bc53d";

        self::test($name);

        /*
        self::$data["session"] = "";
        self::test($name);

        self::$data["uuid"] = "777";
        self::test($name);

        self::$data["uuid"] = "888";
        self::test($name);

        self::$data["uuid"] = "999";
        self::test($name);

        self::$data["license"] = "25";
        self::test($name);

        self::$data["email"] = "zxczxc";
        self::$data['uuid'] = 28;
        self::test($name);
        */
    }

    private static function setDefault(){
        self::$data = array(
            "session" => "d07a5600b20b27a6dc4f27e1af535779",
            "uuid" => "666",
            "email" => "test@test.com",
            "password" => "test",
            "license" => "5555555555");
    }

    public static function test($name){

        if( $curl = curl_init() ) {

            $test = array(
                "session" => "2d60235ce70038db803883ca7198c451",
                "orders" => array()
            );
            //$test = '{"session":"d07a5600b20b27a6dc4f27e1af535779", "orders":[]}';

            curl_setopt($curl, CURLOPT_URL, 'http://localhost:8008/service/' . self::$url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, 'data=' . json_encode(self::$data));
            $start = microtime(true);
            $out = curl_exec($curl);
            curl_close($curl);
            $end = microtime(true);

            //header("Content-type: text/html; charset=utf-8");
            echo "<!DOCTYPE html><html><head></head><body>";
            echo "<h3>Test " . $name . ":</h3>";
            echo "<h4>Time: ". ($end -  $start) ."</h4>";
            echo "<h5>Url: http://localhost:8008/service/" . self::$url ."</h5>";
            echo "<h4>Input:</h4>";
            echo json_encode(self::$data) . "<br />";
            var_dump(self::$data);
            echo "<h4>Output:</h4>";
            echo $out;
            echo "<hr />";
            echo "</body></html>";
        }
    }
}

class createOrder{
    private static $orders = array(
        "session" => "390ed8cd76ccbac2dd02f40210208900",//"3e4ab9ab605a8fd8e12c03ff783e7640",//"41e492078d79082c43dbb8c6c1a57b5c",
        "orders" => array(
            array(
                "customer" => 1,
                "slip_number" => "554464",
                "special_code" => "5645",
                "date" => "23.08.2014",
                "subtotal" => 500,
                "total" => 700,
                "department" => 1,
                "division" => 1,
                "warehouse" => 1,
                "plant" => 1,
                "advance_payment" => 5,
                "currency" => 1,
                "order_items" => array(
                    array(
                        "type" => 1,
                        "item" => 1,
                        "unit_detail" => 1,
                        "price" => 10,
                        "quantity" => 1
                    ),

                    array(
                        "type" => 2,
                        "item" => 1,
                        "unit_detail" => 2,
                        "price" => 15,
                        "quantity" => 10
                    ),

                    array(
                        "type" => 1,
                        "item" => 2,
                        "unit_detail" => 1,
                        "price" => 17,
                        "quantity" => 11
                    )

                )
            )
        )
    );

    private static $dispatches = array(
        "session" => "390ed8cd76ccbac2dd02f40210208900",//"3e4ab9ab605a8fd8e12c03ff783e7640",//"41e492078d79082c43dbb8c6c1a57b5c",
        "dispatches" => array(
            array(
                "customer" => 1,
                "slip_number" => "554464",
                "special_code" => "5645",
                "date" => "23.08.2014",
                "subtotal" => 500,
                "total" => 700,
                "department" => 1,
                "division" => 1,
                "warehouse" => 1,
                "plant" => 1,
                "advance_payment" => 5,
                "currency" => 1,
                "dispatch_items" => array(
                    array(
                        "type" => 1,
                        "item" => 1,
                        "unit_detail" => 1,
                        "price" => 10,
                        "quantity" => 1
                    ),

                    array(
                        "type" => 2,
                        "item" => 1,
                        "unit_detail" => 2,
                        "price" => 15,
                        "quantity" => 10
                    ),

                    array(
                        "type" => 1,
                        "item" => 2,
                        "unit_detail" => 1,
                        "price" => 17,
                        "quantity" => 11
                    )

                )
            )
        )
    );

    private static $invoices = array(
        "session" => "390ed8cd76ccbac2dd02f40210208900",//"3e4ab9ab605a8fd8e12c03ff783e7640",//"41e492078d79082c43dbb8c6c1a57b5c",
        "invoices" => array(
            array(
                "customer" => 1,
                "slip_number" => "554464",
                "special_code" => "5645",
                "date" => "23.08.2014",
                "subtotal" => 500,
                "total" => 700,
                "department" => 1,
                "division" => 1,
                "warehouse" => 1,
                "plant" => 1,
                "advance_payment" => 5,
                "currency" => 1,
                "invoice_items" => array(
                    array(
                        "type" => 1,
                        "item" => 1,
                        "unit_detail" => 1,
                        "price" => 10,
                        "quantity" => 1
                    ),

                    array(
                        "type" => 2,
                        "item" => 1,
                        "unit_detail" => 2,
                        "price" => 15,
                        "quantity" => 10
                    ),

                    array(
                        "type" => 1,
                        "item" => 2,
                        "unit_detail" => 1,
                        "price" => 17,
                        "quantity" => 11
                    )

                )
            )
        )
    );

    private static $bondPayments = array(
        "session" => "390ed8cd76ccbac2dd02f40210208900", //"3e4ab9ab605a8fd8e12c03ff783e7640",//"41e492078d79082c43dbb8c6c1a57b5c",
        "payments" => array(
            array(
                "slip_number" => "554464",
                "date" => "23.08.2014",
                "special_code" => "5645",
                "currency" => 1,
                "amount" => "10.2",
                "description" => "some description",
                "issuer_name" => "issuer name",
                "guarantor_name" => "guarantor name",
                "serial_number" => "serial number",
                "due_date" => "20.10.2014",
                "customer" => 1
            )
        )
    );

    private static $cashPayments = array(
        "session" => "390ed8cd76ccbac2dd02f40210208900", //"3e4ab9ab605a8fd8e12c03ff783e7640",//"41e492078d79082c43dbb8c6c1a57b5c",
        "payments" => array(
            array(
                "slip_number" => "554464",
                "date" => "23.08.2014",
                "special_code" => "5645",
                "currency" => 1,
                "amount" => "10.2",
                "description" => "some description",
                "serial_number" => "serial number",
                "customer" => 1
            )
        )
    );

    private static $chequePayments = array(
        "session" => "390ed8cd76ccbac2dd02f40210208900", //"3e4ab9ab605a8fd8e12c03ff783e7640",//"41e492078d79082c43dbb8c6c1a57b5c",
        "payments" => array(
            array(
                "slip_number" => "554464",
                "date" => "23.08.2014",
                "special_code" => "5645",
                "currency" => 1,
                "amount" => "10.2",
                "description" => "some description",
                "serial_number" => "serial number",
                "customer" => 1,
                "issuer_name" => "issuer name",
                "due_date" => "20.10.2014"
            )
        )
    );

    private static $cardPayments = array(
        "session" => "390ed8cd76ccbac2dd02f40210208900", //"3e4ab9ab605a8fd8e12c03ff783e7640",//"41e492078d79082c43dbb8c6c1a57b5c",
        "payments" => array(
            array(
                "slip_number" => "554464",
                "date" => "23.08.2014",
                "special_code" => "5645",
                "currency" => 1,
                "amount" => "10.2",
                "description" => "some description",
                "customer" => 1,
                "holder_name" => "holder name",
                "number" => "2222555222",
                "expiry_date" => "20.10.2014",
                "cvv_code" => "666"
            )
        )
    );

    public static  function test(){
        /*$name = "Create Order";
        Service::$url = "mobile/orders/create";
        Service::$data = self::$orders;
        //Service::test($name);*/

        ////////////////////////////
        /////////////////////////////

        /*$name = "Create Dispatch";
        Service::$url = "mobile/dispatches/create";
        Service::$data = self::$dispatches;
        //Service::test($name);*/

        //////////////////////////////
        /////////////////////////////

        /*$name = "Create Invoice";
        Service::$url = "mobile/invoices/create";
        Service::$data = self::$invoices;
        Service::test($name);*/

        ///////////////////////////
        ///////////////////////////

        $name = "Create Bond Payment";
        Service::$url = "mobile/bond/create";
        Service::$data = self::$bondPayments;
        Service::test($name);

        /////////////////////////////
        /////////////////////////////

        $name = "Create Cash Payment";
        Service::$url = "mobile/cash/create";
        Service::$data = self::$cashPayments;
        Service::test($name);

        /////////////////////////////
        /////////////////////////////

        $name = "Create Cheque Payment";
        Service::$url = "mobile/cheque/create";
        Service::$data = self::$chequePayments;
        Service::test($name);

        /////////////////////////////
        /////////////////////////////

        $name = "Create Credit Card Payment";
        Service::$url = "mobile/card/create";
        Service::$data = self::$cardPayments;
        Service::test($name);

    }
}

createOrder::test();