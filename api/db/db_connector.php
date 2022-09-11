<?php

class DatabaseConnector  {

    private $accountConnection = null;
    private $shopConnection = null;

    public function __construct()
    {
    }

    public function getAccountDbConnection()
    {

        try {
            $this->accountConnection = new \PDO("sqlite:" ."../db/accounts.db");
            return $this->accountConnection;
        } catch (\PDOException $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        }
    }

    public function getShopDbConnection()
    {
        try {
            $this->shopConnection = new \PDO("sqlite:" ."../db/shop.db");
            return $this->shopConnection;
        } catch (\PDOException $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        }
    }

    public function readAccountData(){
        global $ACCOUNT_DATA_PATH;
        return readCsvFile($ACCOUNT_DATA_PATH);
    }

    public function readProductData(){
        global $PRODUCT_DATA_PATH ;
        return readCsvFile($PRODUCT_DATA_PATH);
    }

    public function readOrderData(){
        global $ORDER_DATA_PATH  ;
        return readCsvFile($ORDER_DATA_PATH);
    }
}