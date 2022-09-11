<?php

class OrderStatus
{

    private $db = null;

    public function __construct()
    {
        $this->db = array();
        $this->db[] = array("OrderStatusID" => 1, "Label" => "active");
        $this->db[] = array("OrderStatusID" => 2, "Label" => "delivered");
        $this->db[] = array("OrderStatusID" => 3, "Label" => "canceled");
    }

    public function findAll()
    {
        $orderStatusList = array();
        foreach ($this->db as $key => $val) {
            $orderStatusList[] = $val;
        }

        return $orderStatusList;
    }

    public function findByOrderStatusID($orderStatusID){

        $orderStatus = array();
    
        foreach ($this->db as $key => $val) {
            if ($val["OrderStatusID"] == $orderStatusID){
                $orderStatus = $val;
                return $orderStatus;
            }
        }
    }
}
