<?php
/**
 * Created by PhpStorm.
 * User: SERGE
 * Date: 16.08.14
 * Time: 19:39
 */

namespace Matrix\ServiceBundle\Utils;


abstract class Errors {
    const INCORRECT_REQUEST = 1;

    const INCORRECT_LOIN_INFO = 5;

    const INCORRECT_LICENSE_COUNT = 31;

    const INCORRECT_LICENSE = 30;

    const OOPS = 666;


    /**
     * @param $error
     * @return array
     */
    public static function getMsg($error){

        $res = array(
            "code" => 0,
            "msg" => ""
        );

        switch($error){
            case self::INCORRECT_REQUEST:
                $res['code'] = self::INCORRECT_REQUEST;
                $res['msg'] = "Incorrect request!";
                break;
            case self::INCORRECT_LOIN_INFO:
                $res['code'] = self::INCORRECT_LOIN_INFO;
                $res['msg'] = "Incorrect login or password!";
                break;
            case self::INCORRECT_LICENSE_COUNT:
                $res['code'] = self::INCORRECT_LICENSE_COUNT;
                $res['msg'] = "Incorrect license count!";
                break;
            case self::INCORRECT_LICENSE:
                $res['code'] = self::INCORRECT_LICENSE;
                $res['msg'] = "Incorrect license!";
                break;
            case self::OOPS:
                $res['code'] = self::OOPS;
                $res['msg'] = "Ha-ha!";
                break;
            default:
                break;
        }

        return $res;

    }
} 