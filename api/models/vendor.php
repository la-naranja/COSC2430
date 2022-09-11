<?php

class Vendor
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }


    public function findAll(){
        global $VENDOR_TYPE;
        $vendorList = array();
        foreach ($this->db as $key => $val) {
            if ($val[1] !== $VENDOR_TYPE) {
                continue;
            }
            $vendor = json_decode($val[2], true);

            unset($vendor["Password"]);

            $vendorList[] = $vendor;
        }

        return $vendorList;
    }

    public function findByUsername($username){
        global $VENDOR_TYPE;

        foreach ($this->db as $key => $val) {
            if ($val[1] !== $VENDOR_TYPE) {
                continue;
            }

            $vendor = json_decode($val[2], true);

            if ($vendor["Username"] == $username) {
                return $vendor;
            }
        }
    }

    public function findByBusinessAddress($businessAddress){
        global $VENDOR_TYPE;

        foreach ($this->db as $key => $val) {
            if ($val[1] !== $VENDOR_TYPE) {
                continue;
            }

            $vendor = json_decode($val[2], true);

            if ($vendor["BusinessAddress"] == $businessAddress) {
                return $vendor;
            }
        }
    }

    public function findByBusinessname($businessName){
        global $VENDOR_TYPE;

        foreach ($this->db as $key => $val) {
            if ($val[1] !== $VENDOR_TYPE) {
                continue;
            }

            $vendor = json_decode($val[2], true);

            if ($vendor["BusinessName"] == $businessName) {
                return $vendor;
            }
        }
    }

    public function findByVendorID($vendorID){
        global $VENDOR_TYPE;

        foreach ($this->db as $key => $val) {
            if ($val[1] !== $VENDOR_TYPE) {
                continue;
            }

            $vendor = json_decode($val[2], true);

            if ($vendor["VendorID"] == $vendorID) {
                return $vendor;
            }
        }
    }

    public function create($username,$password,$name,$profilePhoto,$address)
    {
        global $ACCOUNT_DATA_PATH, $VENDOR_TYPE;

        $currentDateTime = gmdate("Y-m-d\TH:i:s\Z");

        $vendorID = count($this->db) + 1;

        $newVendor = array(
            "VendorID" => $vendorID,
            "Username" => $username,
            "Password" => $password,
            "BusinessName" => $name,
            "BusinessAddress" => $address,
            "UpdatedAt" => $currentDateTime,
            "CreatedAt" => $currentDateTime,
            "ProfilePhoto" => $profilePhoto,
        );

        $this->db[] = array($vendorID, $VENDOR_TYPE, json_encode($newVendor));

        $rs = addDataToCsvFile($ACCOUNT_DATA_PATH, $this->db);
        if ($rs !== "") {
            echo 'Exception: ' . $rs;
            return;
        }

        return true;
    }

    public function update($username, $profilePhotoPath){
        global $ACCOUNT_DATA_PATH, $VENDOR_TYPE;

        foreach ($this->db as $key => $val) {
            if ($val[1] !== $VENDOR_TYPE) {
                continue;
            }

            $vendor = json_decode($val[2], true);

            if ($vendor["Username"] == $username) {
                $vendor["ProfilePhoto"] = $profilePhotoPath;
                $this->db[$key] = array($val[0],$VENDOR_TYPE, json_encode($vendor));
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
