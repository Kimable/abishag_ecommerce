<?php
$title = "Track Your Order";
require './functions/GetAllProducts.php';

require './partials/head.php';
require './util/env.php'
?>

<div class="container" style="margin: 2rem 0;">
  <div style="margin: 0 auto; width:400px">
    <h1 style="margin-bottom: 1rem;">Track Your Order</h1>
    <!-- Track order div -->
    <p>Enter the Mpesa Code you received after paying or The Order Number</p>
    <div style="margin: 2rem 0;" id="ordertracker-widget"></div>
  </div>
</div>


<script src="https://www.ordertracker.com/sdk.js"></script>
<script>
  Ordertracker({
    "id": '<?= getenv("API_ID") ?>',
    /*
        If you want to load the tracking status directly instead of showing a tracking form
        Uncomment the next line & replace YOUR_TRACKING_NUMBER by a valid tracking number
    */
    //"trackingNumber": "YOUR_TRACKING_NUMBER"
  }).render('#ordertracker-widget')
</script>

<?php require './partials/footer.php'; ?>