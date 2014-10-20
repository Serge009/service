<?php
/**
 * Created by PhpStorm.
 * User: РѕР»РµРі
 * Date: 07.10.14
 * Time: 12:16
 */

class Model {
    public $db = null;
    public function __construct() {
        $this->OpenDatabaseConnection();
    }
    public function OpenDatabaseConnection() {
        try {
            $this->db = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
            $this->db->exec("set names utf8");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {

            echo $e->getMessage();
            // РР»Рё Р·Р°РїРёСЃСЊ РѕС€РёР±РѕРє РІ С„Р°Р№Р»
            //file_put_contents("PDOerrors.txt", $e->getMessage(), FILE_APPEND);
        }

    }
    public function insertBank($organizationId, $nameBank) {
        try {
            $sql = "INSERT INTO bank (id, name) VALUES (:organizationId, :nameBank)";
            $query = $this->db->prepare($sql);
            $query->execute(array(
                ":organizationId" => $organizationId,
                ":nameBank"       => $nameBank
            ));
            return $this->db->lastInsertId();
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function insertCurrency($symbol, $name) {
        try {
            $sql = "INSERT INTO currency (code, name) VALUES (:symbol, :name)";
            $query = $this->db->prepare($sql);
            $query->execute(array(
                ":symbol" => $symbol,
                ":name"   => $name
            ));
            return $this->db->lastInsertId();
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function selectCurrency() {
        try {
            $sql = "SELECT id, code, name FROM currency";
            $query = $this->db->query($sql);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            return $query->fetchAll();
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
    }
}