<?php

class DistributionHub
{

    private $db = null;

    public function __construct()
    {
        $this->db = array();
        $this->db[] = array("DistributionHubID" => 1, "Name"=> "LAX Express", "Address" => "67 Lê Lợi, Phường Bến Nghé, Quận 1, Tp. Hồ Chí Minh, Việt Nam");
        $this->db[]= array("DistributionHubID" => 2, "Name"=> "LALA MOVE", "Address" => "146 Lý Thường Kiệt phường 12 quận Tân Bình tp Hồ Chí Minh Việt Nam");
    }

    public function findAll()
    {
        $distributionHubList = array();
        foreach ($this->db as $key => $val) {
            $distributionHubList[] = $val;
        }

        return $distributionHubList;
    }

    public function findByDistributionHubID($distributionHubID){

        $distributionHub = array();
    
        foreach ($this->db as $key => $val) {
            if ($val["DistributionHubID"] == $distributionHubID){
                $distributionHub = $val;
                return $distributionHub;
            }
        }
    }
}
