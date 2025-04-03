<?php
require_once 'db_config.php';

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Laundry Bill</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <style>
body {
    background-image: url('../images/2.png');
    background-size: cover;
    background-position: center;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    font-family: Arial, sans-serif;
}

.container {
    padding: 40px;
    border-radius: 10px;
}

.card {
    margin-top: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card-header h2 {
    color: #333;
    margin-bottom: 10px;
}

.card-body {
    color: #555;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    font-weight: bold;
}

.btn-primary {
    display: inline-block;
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.table th,
.table td {
    text-align: center;
}

.button-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.table-responsive {
    overflow-x: auto;
}
.back-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: black;
        }
        @media (max-width: 768px) {
            .back-btn {
                position: absolute;
                top: 10px;
                right: 10px;
                font-size: 10px;
            }
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2 class="text-center mb-0">Select Month</h2>
        </div>
        <div class="card-body">
            <form method="get" class="mb-3">
                <div class="form-row justify-content-center">
                    <div class="form-group col-md-4">
                        <label for="year">Year:</label>
                        <select class="form-control" id="year" name="year">
                            <?php for($i = date('Y'); $i >= 2010; $i--): ?>
                                <option value="<?php echo $i; ?>" <?php echo ($i == $currentYear) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="month">Month:</label>
                        <select class="form-control" id="month" name="month">
                            <?php for($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>" <?php echo ($i == $currentMonth) ? 'selected' : ''; ?>><?php echo date('F', mktime(0, 0, 0, $i, 1)); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <button type="submit" class="btn btn-primary mt-4">Filter</button>
                    </div>
                </div>
            </form>
    <div class="card">
        <div class="card-header">
            <h2 class="text-center mb-0">Monthly Laundry Bill - <?php echo date('F Y', strtotime("$currentYear-$currentMonth-01")); ?></h2>
            <p style="text-align:center;">Generated Date and Time: <?php echo date("Y-m-d H:i:s"); ?></p>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Count</th>
                                <th>Total Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Top Wear</td>
                                <td><?php echo $monthly_data['total_top_wear']; ?></td>
                                <td>₹ <?php echo $top_wear_cost; ?></td>
                            </tr>
                            <tr>
                                <td>Bottom Wear</td>
                                <td><?php echo $monthly_data['total_bottom_wear']; ?></td>
                                <td>₹ <?php echo $bottom_wear_cost; ?></td>
                            </tr>
                            <tr>
                                <td>Dry Cleaning</td>
                                <td><?php echo $monthly_data['total_dry_cleaning']; ?></td>
                                <td>₹ <?php echo $dry_cleaning_cost; ?></td>
                            </tr>
                            <tr>
                                <td>Other Costs</td>
                                <td>-</td>
                                <td>₹ <?php echo $monthly_data['total_other_costs']; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Total Amount</strong></td>
                                <td><strong>₹ <?php echo $total_amount; ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="button-container">
                        <a href="overall_bill_download.php" class="btn btn-primary btn-download">Download Invoice</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<a href="admin_dashboard.php" class="btn btn-secondary back-btn"><i class="fas fa-arrow-left"></i> Back</a>

</body>
</html>
