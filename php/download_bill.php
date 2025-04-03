<?php
// Include database configuration and session
include 'db_config.php';
require_once 'session.php';

// Check if orderId is provided in the URL
if(isset($_GET['orderId'])) {
    $orderId = $_GET['orderId'];

    // Fetch order details from the database
    $query = "SELECT * FROM laundry_orders WHERE order_id = $orderId";
    $result = mysqli_query($conn, $query);

    if($result && mysqli_num_rows($result) > 0) {
        $order = mysqli_fetch_assoc($result);
    } else {
        echo "Order not found.";
        exit;
    }

    // Extract order details
    $order_date = $order['order_date'];
    $out_date = $order['out_date'];
    $full_name = $order['full_name'];
    $mobile_no = $order['mobile_no'];
    $room_no = $order['room_no'];
    $top_wear = $order['top_wear'];
    $bottom_wear = $order['bottom_wear'];
    $dry_cleaning = $order['dry_cleaning'];
    $service_type = $order['service_type'];
    $other_amount = $order['other_money'];

    // Calculate costs based on service type
    if ($service_type === "Only Wash") {
        $top_wear_cost = $top_wear * 8;
        $bottom_wear_cost = $bottom_wear * 8;
    } elseif ($service_type === "Only Iron") {
        $top_wear_cost = $top_wear * 7;
        $bottom_wear_cost = $bottom_wear * 10;
    } elseif ($service_type === "Wash and Iron") {
        $top_wear_cost = $top_wear * (8 + 7);
        $bottom_wear_cost = $bottom_wear * (8 + 10);
    } elseif ($service_type === "Color Press") {
        $top_wear_cost = $top_wear * (8 + 7);
        $bottom_wear_cost = $bottom_wear * 8;
    }

    // Calculate dry cleaning cost
    $dry_cleaning_cost = $dry_cleaning * 100;

    // Calculate total amount
    $total_amount = $top_wear_cost + $bottom_wear_cost + $dry_cleaning_cost;

    // Include TCPDF library
    require_once ("../tcpdf/tcpdf.php");

    // Create new PDF instance
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Laundry Invoice');
    $pdf->SetSubject('Invoice for Order ID: ' . $orderId);
    $pdf->SetKeywords('Invoice, Laundry, Order');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('dejavusans', '', 12);

    // HTML content for invoice
    $html = '
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <style>
            .invoice-title h2, .invoice-title h3 {
                display: inline-block;
            }
            .table > tbody > tr > .no-line {
                border-top: none;
            }
            .table > thead > tr > .no-line {
                border-bottom: 2px;
            }
            .table > tbody > tr > .thick-line {
                border-top: 2px solid;
            }
            
.container {
    padding: 40px;
    border-radius: 10px;
  }
  
  .card-header h2 {
    color: #333;
  }
  
  .card-body {
    color: #555;
  }
  
  .table th,
  .table td {
    text-align: center;
  }
  
  .form-group {
    margin-bottom: 1rem;
  }
        </style>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
        <h2>Laundry Bill - Order No: '.$orderId.'</h2>
        <p>Generated Date and Time: '.date("Y-m-d H:i:s").'</p>
    </div>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>Student Details:</strong><br>
                        Name: ' . $full_name . '<br>
                        Mobile: ' . $mobile_no . '<br>
                        Room No: ' . $room_no . '
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>Order Date:</strong> ' . $order_date . '<br>
                        <strong>Out Date:</strong> ' . $out_date . '<br>
                        <strong>Payment Method:</strong> Cash on receive
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                        <h3 class="panel-title"><strong>Order Summary</strong></h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-condensed" border="1" >
                                    <thead>
                                        <tr>
                                            <td><strong>Item</strong></td>
                                            <td class="text-center"><strong>Price</strong></td>
                                            <td class="text-center"><strong>Quantity</strong></td>
                                            <td class="text-right"><strong>Totals</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Top Wear</td>
                                            <td class="text-center">₹ ' . (($service_type === "Only Wash" || $service_type === "Only Iron") ? "8" : "15") . '</td>
                                            <td class="text-center">' . $top_wear . '</td>
                                            <td class="text-right">₹ ' . $top_wear_cost . '</td>
                                        </tr>
                                        <tr>
                                            <td>Bottom Wear</td>
                                            <td class="text-center">₹ ' . (($service_type === "Only Wash") ? "8" : (($service_type === "Only Iron") ? "10" : "18")) . '</td>
                                            <td class="text-center">' . $bottom_wear . '</td>
                                            <td class="text-right">₹ ' . $bottom_wear_cost . '</td>
                                        </tr>
                                        <tr>
                                            <td>Dry Cleaning</td>
                                            <td class="text-center">₹ 100</td>
                                            <td class="text-center">' . $dry_cleaning . '</td>
                                            <td class="text-right">₹ ' . $dry_cleaning_cost . '</td>
                                        </tr>
                                        <tr>
                                            <td class="thick-line"></td>
                                            <td class="thick-line"></td>
                                            <td class="thick-line text-center"><strong>Others</strong></td>
                                            <td class="thick-line text-right">₹ ' . $other_amount . '</td>
                                        </tr>
                                        <tr>
                                            <td class="thick-line"></td>
                                            <td class="thick-line"></td>
                                            <td class="thick-line text-center"><strong>Subtotal</strong></td>
                                            <td class="thick-line text-right">₹ ' . $total_amount . '</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

    // Write HTML content to PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Close and output PDF
    $pdf->Output('invoice_' . $orderId . '.pdf', 'D');
} else {
    echo "Order ID not provided.";
    exit;
}
?>