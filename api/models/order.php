<?php

class Order
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll($distributionHubID)
    {
        $orderList = array();
        foreach ($this->db as $key => $val) {
            $order = json_decode($val[1], true);
            
            if ($order["DistributionHubID"] !=$distributionHubID || $order["Status"] != 1){
                continue;
            }

            $orderList[] = $order;
        }

        return $orderList;
    }

    public function findByOrderID($orderID)
    {
        foreach ($this->db as $key => $val) {
            $order = json_decode($val[1], true);

            if ($order["OrderID"] == $orderID) {
                return $order;
            }
        }
    }

    public function create($customerID, $distributionHub, $orderStatus, $total, $orderItems)
    {

        global $ORDER_DATA_PATH;

        $currentDateTime = gmdate("Y-m-d\TH:i:s\Z");

        $orderID = count($this->db) + 1;

        $neworder = array(
            "OrderID" => $orderID,
            "CustomerID" => $customerID,
            "Status" => $orderStatus["OrderStatusID"],
            "StatusLabel" => $orderStatus["Label"],
            "DistributionHubID" => $distributionHub["DistributionHubID"],
            "DistributionHubName" =>  $distributionHub["Name"],
            "DistributionHubAddress" => $distributionHub["Address"],
            "Total" => $total,
            "OrderDetails" =>  $orderItems,
            "UpdatedAt" => $currentDateTime,
            "CreatedAt" => $currentDateTime
        );

        $this->db[] = array($orderID, json_encode($neworder));

        $rs = addDataToCsvFile($ORDER_DATA_PATH, $this->db);
        if ($rs !== "") {
            echo 'Exception: ' . $rs;
            return;
        }

        return true;
    }

    public function updateOrderStatus($orderID,$orderStatus)
    {
        global $ORDER_DATA_PATH;

        foreach ($this->db as $key => $val) {

            $order = json_decode($val[1], true);

            if ($order["OrderID"] == $orderID) {
                $order["Status"] = $orderStatus["OrderStatusID"];
                $order["StatusLabel"] = $orderStatus["Label"];

                $this->db[$key] = array($val[0], json_encode($order));
                break;
            }
        }

        $rs = addDataToCsvFile($ORDER_DATA_PATH, $this->db);
        if ($rs !== "") {
            echo 'Exception: ' . $rs;
            return;
        }

        return true;
    }
}
