<?php


class DistributionHubController {

    private $requestMethod;
    private $distributionHubModel;

    public function __construct($requestMethod)
    {
        $this->requestMethod = $requestMethod;

        $this->distributionHubModel = new DistributionHub();
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getDistributionHubs();
                break;
            default:
                $response = notFoundResponse();
                break;
        }

        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getDistributionHubs()
    {
        global $SUCCESS_STATUS_CODE;

        $result = $this->distributionHubModel->findAll();
        $response['status_code_header'] = $SUCCESS_STATUS_CODE;
        $response['body'] = json_encode($result);
        return $response;
    }
}