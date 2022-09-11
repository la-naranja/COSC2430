<?php

class Customer
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        global $CUSTOMER_TYPE;
        $customerList = array();
        foreach ($this->db as $key => $val) {
            if ($val[1] !== $CUSTOMER_TYPE) {
                continue;
            }
            $customer = json_decode($val[2], true);

            unset($customer["Password"]);

            $customerList[] = $customer;
        }

        return $customerList;

    }

    public function findByUsername($username)
    {
        global $CUSTOMER_TYPE;

        foreach ($this->db as $key => $val) {
            if ($val[1] !== $CUSTOMER_TYPE) {
                continue;
            }

            $customer = json_decode($val[2], true);

            if ($customer["Username"] == $username) {
                return $customer;
            }
        }
    }

    public function findByCustomerID($customerID)
    {global $CUSTOMER_TYPE;

        foreach ($this->db as $key => $val) {
            if ($val[1] !== $CUSTOMER_TYPE) {
                continue;
            }

            $customer = json_decode($val[2], true);

            if ($customer["CustomerID"] == $customerID) {
                unset($customer["Password"]);
                return $customer;
            }
        }
    }

    public function create($username, $password, $name, $profilePhoto, $address)
    {
        global $ACCOUNT_DATA_PATH, $CUSTOMER_TYPE;

        $currentDateTime = gmdate("Y-m-d\TH:i:s\Z");

        $customerID = count($this->db) + 1;

        $newCustomer = array(
            "CustomerID" => $customerID,
            "Username" => $username,
            "Password" => $password,
            "Name" => $name,
            "UpdatedAt" => $currentDateTime,
            "CreatedAt" => $currentDateTime,
            "Address" => $address,
            "ProfilePhoto" => $profilePhoto,
        );

        $this->db[] = array($customerID, $CUSTOMER_TYPE, json_encode($newCustomer));

        $rs = addDataToCsvFile($ACCOUNT_DATA_PATH, $this->db);
        if ($rs !== "") {
            echo 'Exception: ' . $rs;
            return;
        }

        return true;
    }

    public function update($username, $profilePhotoPath)
    {
        global $ACCOUNT_DATA_PATH, $CUSTOMER_TYPE;

        foreach ($this->db as $key => $val) {
            if ($val[1] !== $CUSTOMER_TYPE) {
                continue;
            }

            $customer = json_decode($val[2], true);

            if ($customer["Username"] == $username) {
                $customer["ProfilePhoto"] = $profilePhotoPath;
                $this->db[$key] = array($val[0],$CUSTOMER_TYPE, json_encode($customer));
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
