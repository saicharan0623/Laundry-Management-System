<?php
require_once 'db_config.php';
require_once 'session.php';

// Query to select orders with status 'Requested'
$sql = "SELECT * FROM laundry_orders WHERE status = 'Requested' AND out_date IS NULL";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History/Bills</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            background-image: url("../images/2.png");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: black;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid white;
            padding: 8px;
            text-align: center;
        }
        .edit-btn, .generate-bill-btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            color: white;
            width: 100%;
        }
        .edit-btn {
            background-color: #007bff;
        }
        .generate-bill-btn {
            background-color: #28a745;
        }
        .btn-container {
            display: flex;
            justify-content: center;
        }
        .btn-container button:hover {
        background-color: black;
        }
        .btn-container button {
            margin-right: 5px;
            margin-bottom: 5px;
        }
        .container {
            display: flex;
            justify-content: center;
            height: 100vh;
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
        .thead-dark-custom{
            background-color: rgb(186,12,47);
            color: white;
        }
        .status {
        padding: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
        background-color: white;
        color: black;
        width: 100%;
        max-width: 200px; /* Adjust as needed */
    }
    .update-btn {
        background-color: #007bff;
        padding: 5px 10px;
        border: none;
        cursor: pointer;
        color: white;
        width: 100%;
        max-width: 200px; /* Adjust as needed */
    }
    /* Style the dropdown container */
select {
  padding: 8px;
  border-radius: 4px;
  border: 1px solid #ccc;
  background-color: #fff;
  font-family: inherit;
  font-size: 14px;
  height: 35px;
}

/* Style the options inside the dropdown */
option {
  background-color: #fff;
  color: #333;
  padding: 8px;
}

/* Style the selected option */
option:checked {
  background-color: #007bff;
  color: #fff;
}

/* Style the dropdown when it's open */
select:focus {
  outline: none;
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}
    </style>
</head>
<body>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 class="mt-5 mb-4">New Orders</h1>
                <div class="row justify-content-center mb-4">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchInput" placeholder="Enter Order Number or Name">
                            <div class="input-group-append">
                                <button class="btn btn-primary" onclick="searchOrders()">Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" id="hostelSelect" onchange="searchOrders()">
                            <option value="">All Hostels</option>
                            <option value="boys">Boys Hostel</option>
                            <option value="girls">Girls Hostel</option>
                        </select>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead class="thead-dark-custom">
                        <tr>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Out Date</th>
                            <th>Full Name</th>
                            <th>Gender</th>
                            <th>Room No</th>
                            <th>Top Wear</th>
                            <th>Bottom Wear</th>
                            <th>Other Clothes</th>
                            <th>Dry Cleaning</th>
                            <th>Service Type</th>
                            <th>Status</th>
                            <th>Total Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if (isset($result) && mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>".$row['order_id']."</td>";
                                echo "<td>".$row['order_date']."</td>";
                                echo "<td>".$row['out_date']."</td>";
                                echo "<td>".$row['full_name']."</td>";
                                echo "<td>".$row['gender']."</td>";
                                echo "<td>".$row['room_no']."</td>";
                                echo "<td>".$row['top_wear']."</td>";
                                echo "<td>".$row['bottom_wear']."</td>";
                                echo "<td>".$row['other_cloths']."</td>";
                                echo "<td>".$row['dry_cleaning']."</td>";
                                echo "<td>".$row['service_type']."</td>";
                                echo "<td>".$row['status']."</td>";
                                echo "<td>".$row['total_amount']."</td>";
                                echo "<td class='btn-container'>";
                                echo "<select id='status".$row['order_id']."'>";
                                echo "<option value='Accepted'selected>Accept</option>"; 
                                echo "<option value='In Process'>In Process</option>";
                                echo "<option value='Finished'>Finished</option>";
                                echo "</select>";
                                echo "<button class='update-btn' onclick='updateOrder(".$row['order_id'].")'>Update</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='16'>No orders found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
    function searchOrders() {
        var searchInput = document.getElementById("searchInput").value.trim().toLowerCase();
        var table = document.getElementById("ordersTable");
        var rows = table.getElementsByTagName("tr");
        var selectedHostel = document.getElementById("hostelSelect").value;
        var ordersFound = false;

        for (var i = 1; i < rows.length; i++) {
            var orderIdCell = rows[i].getElementsByTagName("td")[0];
            var orderId = orderIdCell.textContent.trim().toLowerCase();

            var fullNameCell = rows[i].getElementsByTagName("td")[3]; 
            var fullName = fullNameCell.textContent.trim().toLowerCase();

            var genderCell = rows[i].getElementsByTagName("td")[4]; 
            var gender = genderCell.textContent.trim().toLowerCase();

            var roomNoCell = rows[i].getElementsByTagName("td")[5]; 
            var roomNo = roomNoCell.textContent.trim().toLowerCase();

            if ((orderId.includes(searchInput) || fullName.includes(searchInput) || searchInput === "") &&
                (selectedHostel === "" || (selectedHostel === "boys" && gender === "male") || (selectedHostel === "girls" && gender === "female"))) {
                rows[i].style.display = "";
                ordersFound = true;
            } else {
                rows[i].style.display = "none";
            }
        }

        if (!ordersFound) {
            var noOrdersRow = document.createElement("tr");
            var noOrdersCell = document.createElement("td");
            noOrdersCell.setAttribute("colspan", "16");
            noOrdersCell.textContent = "No orders found";
            noOrdersRow.appendChild(noOrdersCell);
            table.appendChild(noOrdersRow);
        }
    }
</script>

    <script>
function updateOrder(orderId) {
    var status = document.getElementById('status'+orderId).value;
    
    console.log("Status:", status);
    
    if (status.trim() === "") {
        alert("Please select a valid status.");
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_order_status.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
            window.location.reload();
        }
    };
    xhr.send('orderId=' + orderId + '&status=' + status);
}

</script>
<a href="admin_dashboard.php" class="btn btn-secondary back-btn"><i class="fas fa-arrow-left"></i> Back</a>
</body>
</html>
