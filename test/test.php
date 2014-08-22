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

            curl_setopt($curl, CURLOPT_URL, 'http://localhost:8080/service/' . self::$url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, 'data=' . json_encode($test));
            $start = microtime(true);
            $out = curl_exec($curl);
            curl_close($curl);
            $end = microtime(true);

            //header("Content-type: text/html; charset=utf-8");
            echo "<!DOCTYPE html><html><head></head><body>";
            echo "<h3>Test " . $name . ":</h3>";
            echo "<h4>Time: ". ($end -  $start) ."</h4>";
            echo "<h5>Url: http://localhost:8080/service/" . self::$url ."</h5>";
            echo "<h4>Input:</h4>";
            echo json_encode($test) . "<br />";
            var_dump($test);
            echo "<h4>Output:</h4>";
            echo $out;
            echo "<hr />";
            echo "</body></html>";
        }
    }
}

class createOrder{
    private static $data = array(
        "session" => "3e4ab9ab605a8fd8e12c03ff783e7640",//"41e492078d79082c43dbb8c6c1a57b5c",
        "orders" => array(
            array(
                "customer" => 1,
                "slipNumber" => "554464",
                "specialCode" => "5645",
                "date" => "23.08.2014",
                "subtotal" => 500,
                "total" => 700,
                "orderItems" => array(
                    array(
                        "type" => 1,
                        "item" => 1
                    ),

                    array(
                        "type" => 2,
                        "item" => 1
                    ),

                    array(
                        "type" => 1,
                        "item" => 2
                    )

                )
            )
        )
    );

    public static  function test(){
        $name = "Create Order";
        Service::$url = "app_dev.php/orders/create";
        Service::$data = self::$data;

        Service::test($name);

    }
}

createOrder::test();