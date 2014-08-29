<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 26.06.14
 * Time: 12:43
 */

class Service{

    public static $data = array(
        "session" => "2d60235ce70038db803883ca7198c451",//"41e492078d79082c43dbb8c6c1a57b5c",
        "uuid" => "666",
        "email" => "loh@example.com",
        "password" => "test",
        "license" => "5555555555",
        "versions" => array(
            "currency" => 0,
            "customers" => 0,
            "department" => 0,
            "division" => 0,
            "plant" => 0,
            "product_prices" => 0,
            "products" => 0,
            "service_prices" => 0,
            "services" => 0,
            "unit" => 0,
            "unit_detail" => 0,
            "warehouse" => 0,
            "order_item" => 0,
            "orders" => 0
        )
    );

    public static $url;

    private static  function synchCustomers(){
        $name = "Customers Synch";
        self::$url = 'customers/synch';
        self::test($name);

    }

    public static function start(){
        //self::synchCustomers();
        self::synch();
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

        self::$data["session"] = "d07a5600b20b27a6dc4f27e1af535779";
        self::test($name);

        self::$data["session"] = "202b275d522665d8585817e9a6f18537";
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

        self::$data["email"] = "mobile@mobile";
        self::$data["password"] = "mobile";
        self::$data["license"] = "6666666666";
        self::$data["uuid"]= "ecace720494b8abe7963639a120bc53d";

        self::test($name);




        self::$data["email"] = "loh@example.com";
        self::$data["license"] = "5555555555";

        self::test($name);
        /*
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
            curl_setopt($curl, CURLOPT_URL, 'http://localhost:8080/service/index.php/mobile/' . self::$url);
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
            echo "<h5>Url: http://localhost:8080/service/mobile/" . self::$url ."</h5>";
            echo "<h4>Input:</h4>";
            echo json_encode(self::$data) . "<br />";
            var_dump(self::$data);
            echo "<h4>Output:</h4>";
            echo $out;
            echo "<hr />";
            //echo "</body></html>";
        }
    }
}

Service::start();