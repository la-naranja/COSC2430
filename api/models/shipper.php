<?php

class Shipper
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }


    public function findAll(){
        global $SHIPPER_TYPE;
        $shipperList = array();
        foreach ($this->db as $key => $val) {
            if ($val[1] !== $SHIPPER_TYPE) {
                continue;
            }
            $shipper = json_decode($val[2], true);

            unset($shipper["Password"]);

            $shipperList[] = $shipper;
        }

        return $shipperList;
    }

    public function findByUsername($username){
        global $SHIPPER_TYPE;

        foreach ($this->db as $key => $val) {
            if ($val[1] !== $SHIPPER_TYPE) {
                continue;
            }

            $shipper = json_decode($val[2], true);

            if ($shipper["Username"] == $username) {
                return $shipper;
            }
        }
    }

    public function findByShipperID($shipperID){
        global $SHIPPER_TYPE;

        foreach ($this->db as $key => $val) {
            if ($val[1] !== $SHIPPER_TYPE) {
                continue;
            }

            $shipper = json_decode($val[2], true);

            if ($shipper["ShipperID"] == $shipperID) {
                return $shipper;
            }
        }
    }

    public function create($username,$password,$distributionHubID, $profilePhoto)
    {

        global $ACCOUNT_DATA_PATH, $SHIPPER_TYPE;

        $currentDateTime = gmdate("Y-m-d\TH:i:s\Z");

        $shipperID = count($this->db) + 1;

        $newShipper = array(
            "ShipperID" => $shipperID,
            "Username" => $username,
            "Password" => $password,
            "DistributionHubID" => $distributionHubID,
            "UpdatedAt" => $currentDateTime,
            "CreatedAt" => $currentDateTime,
            "ProfilePhoto" => $profilePhoto,
        );

        $this->db[] = array($shipperID, $SHIPPER_TYPE, json_encode($newShipper));

        $rs = addDataToCsvFile($ACCOUNT_DATA_PATH, $this->db);
        if ($rs !== "") {
            echo 'Exception: ' . $rs;
            return;
        }

        return true;
    }

    public function update($username, $profilePhotoPath){
        global $ACCOUNT_DATA_PATH, $SHIPPER_TYPE;

        foreach ($this->db as $key => $val) {
            if ($val[1] !== $SHIPPER_TYPE) {
                continue;
            }

            $shipper = json_decode($val[2], true);

            if ($shipper["Username"] == $username) {
                $shipper["ProfilePhoto"] = $profilePhotoPath;
                $this->db[$key] = array($val[0],$SHIPPER_TYPE, json_encode($shipper));
                break;
            }
        }

        $rs = addDataToCsvFile($ACCOUNT_DATA_PATH, $this->db);
        if ($rs !== "") {
            echo 'Exception: ' . $rs;
            return;
        }

        return true;
    }
}
