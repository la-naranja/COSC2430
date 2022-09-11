function index() {
    try {
        var customer = localStorage.getItem("customer");
        var shipper = localStorage.getItem("shipper");
        var vendor = localStorage.getItem("vendor");
        if (customer) {
            var _customer = JSON.parse(customer);
            if (_customer.ProfilePhoto) {
                document.getElementById("imgProfile").src = _customer.ProfilePhoto;
            }
        }
        if (vendor) {
            var _vendor = JSON.parse(vendor);
            if (_vendor.ProfilePhoto) {
                document.getElementById("imgProfile").src = _vendor.ProfilePhoto;
            }
        }
        if (shipper) {
            var _shipper = JSON.parse(shipper);
            if (_shipper.ProfilePhoto) {
                document.getElementById("imgProfile").src = _shipper.ProfilePhoto;
            }
        }
    } catch (error) {
    }
}

index();