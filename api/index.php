<?php

require "./utils/constants.php";
include_once "./utils/helpers.php";
include_once "./utils/http.php";
include_once "./utils/validators.php";
include_once "./utils/files.php";

include_once "./models/order_status.php";
include_once "./models/distribution_hub.php";
include_once "./models/product.php";
include_once "./models/customer.php";
include_once "./models/vendor.php";
include_once "./models/shipper.php";
include_once "./models/order.php";

include_once "./controller/order_status_controller.php";
include_once "./controller/distribution_hub_controller.php";
include_once "./controller/product_controller.php";
include_once "./controller/customer_controller.php";
include_once "./controller/vendor_controller.php";
include_once "./controller/shipper_controller.php";
include_once "./controller/order_controller.php";
include_once "./controller/authentication_controller.php";
include_once "./controller/profile_photo_controller.php";

include_once "./db/db_connector.php";

$accounts = (new DatabaseConnector())->readAccountData();
$products = (new DatabaseConnector())->readProductData();
$orders = (new DatabaseConnector())->readOrderData();

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
    header("HTTP/1.1 200 OK");
    die();
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER["REQUEST_METHOD"];

if (strpos($uri, "/assets")) {
    return;
}

if (strpos($uri, '/db')) {
    echo "unauthorized";
    notFoundResponse();
    return;
}

// all of our endpoints start with /api
// everything else results in a 404 Not Found
if (strpos($uri, '/api') === false) {
    header($NOT_FOUND_STATUS_CODE);
    exit();
}

if (strpos($uri, "/orderStatus")) {
    $orderStatuscontroller = new OrderStatusController($orders, $requestMethod);
    $orderStatuscontroller->processRequest();
} else if (strpos($uri, "/distributionHub")) {
    $distributionHubcontroller = new DistributionHubController($requestMethod);
    $distributionHubcontroller->processRequest();
} else if (strpos($uri, "/product")) {
    $productcontroller = new ProductController($products, $requestMethod);
    $productcontroller->processRequest();
} else if (strpos($uri, "/customer")) {
    $customercontroller = new CustomerController($accounts, $requestMethod);
    $customercontroller->processRequest();
} else if (strpos($uri, "/vendor")) {
    $vendorcontroller = new VendorController($accounts, $requestMethod);
    $vendorcontroller->processRequest();
} else if (strpos($uri, "/shipper")) {
    $shippercontroller = new ShipperController($accounts, $requestMethod);
    $shippercontroller->processRequest();
} else if (strpos($uri, "/order")) {
    $ordercontroller = new OrderController($orders, $accounts, $products, $requestMethod);
    $ordercontroller->processRequest();
} else if (strpos($uri, "/login")) {
    $authcontroller = new AuthenticationController($accounts, $requestMethod);
    $authcontroller->processRequest();
} else if (strpos($uri, "/profile-photo")) {
    $profilePhotocontroller = new ProfilePhotoController($accounts, $requestMethod);
    $profilePhotocontroller->processRequest();
} else {
    notFoundResponse();
}
