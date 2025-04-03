<?php
require_once 'db_config.php';
require_once "../tcpdf/tcpdf.php";

$currentMonth = isset($_GET['month']) ? $_GET['month'] : date('m');
$currentYear = isset($_GET['year']) ? $_GET['year'] : date('Y');

$firstDayOfMonth = date('Y-m-01', strtotime("$currentYear-$currentMonth-01"));
$lastDayOfMonth = date('Y-m-t', strtotime("$currentYear-$currentMonth-01"));

$query_monthly_data = "SELECT 
                            SUM(top_wear) AS total_top_wear,
                            SUM(bottom_wear) AS total_bottom_wear,
                            SUM(dry_cleaning) AS total_dry_cleaning,
                            SUM(other_money) AS total_other_costs
                        FROM laundry_orders
                        WHERE order_date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'";

$result_monthly_data = mysqli_query($conn, $query_monthly_data);

$query = "SELECT * FROM laundry_orders";
$result = mysqli_query($conn, $query);

if($result && mysqli_num_rows($result) > 0) {
    $order = mysqli_fetch_assoc($result);}

if ($result_monthly_data && mysqli_num_rows($result_monthly_data) > 0) {
    $monthly_data = mysqli_fetch_assoc($result_monthly_data);

    $top_wear_cost = 0;
    $bottom_wear_cost = 0;
    $dry_cleaning_cost = $monthly_data['total_dry_cleaning'] * 100;
    $other_amount = $monthly_data['total_other_costs'];

    $total_amount = 0;

    foreach ($result_monthly_data as $row) {
        $top_wear = $row['total_top_wear'];
        $bottom_wear = $row['total_bottom_wear'];
        $service_type = $order['service_type'];

        if ($service_type === "Only Wash") {
            $top_wear_cost += $top_wear * 8;
            $bottom_wear_cost += $bottom_wear * 8;
        } elseif ($service_type === "Only Iron") {
            $top_wear_cost += $top_wear * 7;
            $bottom_wear_cost += $bottom_wear * 10;
        } elseif ($service_type === "Wash and Iron") {
            $top_wear_cost += $top_wear * (8 + 7);
            $bottom_wear_cost += $bottom_wear * (8 + 10);
        } elseif ($service_type === "Color Press") {
            $top_wear_cost += $top_wear * (8 + 7);
            $bottom_wear_cost += $bottom_wear * 8;
        }
    }

    $total_amount = $top_wear_cost + $bottom_wear_cost + $dry_cleaning_cost + $other_amount;
} else {
    $monthly_data = array(
        'total_top_wear' => 0,
        'total_bottom_wear' => 0,
        'total_dry_cleaning' => 0,
        'total_other_costs' => 0,
        'total_amount' => 0
    );
}

// Create new PDF instance
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Monthly Laundry Invoice');
$pdf->SetSubject('Invoice for ' . date('F Y', strtotime("$currentYear-$currentMonth-01")));
$pdf->SetKeywords('Invoice, Laundry, Monthly');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// HTML content for invoice
// HTML content for invoice
$html = '
    <div style="max-width: 800px; margin: 0 auto; font-family: Arial, sans-serif;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #333; margin-bottom: 5px;">Monthly Laundry Invoice</h1>
            <p style="font-size: 16px; color: #666;">' . date('F Y', strtotime("$currentYear-$currentMonth-01")) . '</p>
        </div>
        <div style="background-color: #f5f5f5; padding: 20px; border-radius: 5px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                <div>
                    <h3 style="color: #333; margin-bottom: 5px;">Invoice Details</h3>
                    <p style="color: #666; margin: 0;">Generated Date and Time: ' . date("Y-m-d H:i:s") . '</p>
                </div>
                <div>
                    <h3 style="color: #333; margin-bottom: 5px;">Company Details</h3>
                    <p style="color: #666; margin: 0;">NMIMS Laundry</p>
                    <p style="color: #666; margin: 0;">Jadcherla</p>
                    <p style="color: #666; margin: 0;">6304856382</p>
                </div>
            </div>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #333; color: #fff;">
                        <th style="padding: 10px; text-align: left;">Item</th>
                        <th style="padding: 10px; text-align: right;">Count</th>
                        <th style="padding: 10px; text-align: right;">Total Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 10px;">Top Wear</td>
                        <td style="padding: 10px; text-align: right;">' . $monthly_data['total_top_wear'] . '</td>
                        <td style="padding: 10px; text-align: right;"> ' . $top_wear_cost . '</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 10px;">Bottom Wear</td>
                        <td style="padding: 10px; text-align: right;">' . $monthly_data['total_bottom_wear'] . '</td>
                        <td style="padding: 10px; text-align: right;"> ' . $bottom_wear_cost . '</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 10px;">Dry Cleaning</td>
                        <td style="padding: 10px; text-align: right;">' . $monthly_data['total_dry_cleaning'] . '</td>
                        <td style="padding: 10px; text-align: right;">' . $dry_cleaning_cost . '</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 10px;">Other Costs</td>
                        <td style="padding: 10px; text-align: right;">-</td>
                        <td style="padding: 10px; text-align: right;">' . $monthly_data['total_other_costs'] . '</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: bold;" colspan="2">Total Amount</td>
                        <td style="padding: 10px; text-align: right; font-weight: bold;">' . $total_amount . '</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>';

$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF
$pdf->Output('monthly_laundry_invoice_' . $currentYear . '_' . $currentMonth . '.pdf', 'D');
