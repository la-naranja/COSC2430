<?php

class Product
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }


    public function findAll(){
        $productList = array();
        foreach ($this->db as $key => $val) {
            $product = json_decode($val[1], true);

            $productList[] = $product;
        }

        return $productList;
    }

    public function findByName($productName){
        foreach ($this->db as $key => $val) {
            $product = json_decode($val[1], true);

            if ($product["Name"] == $productName) {
                return $product;
            }
        }
    }

    public function findByProductID($productID){
        foreach ($this->db as $key => $val) {
            $product = json_decode($val[1], true);

            if ($product["ProductID"] == $productID) {
                return $product;
            }
        }
    }

    public function create($name,$imagePath,$price,$description)
    {
        global $PRODUCT_DATA_PATH;

        $currentDateTime = gmdate("Y-m-d\TH:i:s\Z");

        $productID = count($this->db) + 1;

        $newproduct = array(
            "ProductID" => $productID,
            "Name" => $name,
            "Price" => $price,
            "ImagePath" => $imagePath,
            "Description" => $description,
            "UpdatedAt" => $currentDateTime,
            "CreatedAt" => $currentDateTime
        );

        $this->db[] = array($productID, json_encode($newproduct));

        $rs = addDataToCsvFile($PRODUCT_DATA_PATH, $this->db);
        if ($rs !== "") {
            echo 'Exception: ' . $rs;
            return;
        }

        return true;
    }
}
