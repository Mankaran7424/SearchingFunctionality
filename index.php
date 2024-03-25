<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Order</title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <h5 class="text-center my-2 fw-bold ">SEARCH ORDER</h5>

    <div class="container shadow-lg rounded-pill py-2 firstContainer">
        <form method="GET">
            <fieldset class="rounded-pill">
                <legend class="float-none w-auto ">Search Order</legend>
                <div class="d-flex justify-content-center align-items-center">
                    <h6 class="mx-2">By</h6>
                    <div class="form-check form-check-inline mx-2 ">
                        <input class="form-check-input" type="radio" name="searchCriteria" id="radioOptions1" value="orderId">
                        <label class="form-check-label  radiobtn" for="radioOptions1">OrderId</label>
                    </div>
                    <div class="form-check form-check-inline mx-2 ">
                        <input class="form-check-input" type="radio" name="searchCriteria" id="radioOptions2" value="mobile">
                        <label class="form-check-label  radiobtn" for="radioOptions2">Mobile</label>
                    </div>
                    <div class="form-check form-check-inline mx-2">
                        <input class="form-check-input" type="radio" name="radioOptions" id="radioOptions3" value="option3">
                        <label class="form-check-label  radiobtn" for="radioOptions3">Name</label>
                    </div>
                    <div class="form-check form-check-inline mx-3">
                        <input class="form-check-input" type="radio" name="radioOptions" id="radioOptions4" value="option4">
                        <label class="form-check-label  radiobtn" for="radioOptions4">Email</label>
                    </div>
                    <input type="text" class="form-control searchbox" placeholder="Search here..." name="searchTerm">
                    <button class="btn btn-success mx-3 searchbtn" type="submit">SEARCH ORDER</button>
                </div>
            </fieldset>
        </form>
    </div>

    <div class="container border shadow-lg my-3 px-2 rounded">
        <div class="row">
            <?php
            include 'conn.php';

            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                $searchCriteria = $_GET['searchCriteria'] ?? '';
                $searchTerm = $_GET['searchTerm'] ?? '';


                if (!empty($searchCriteria) && !empty($searchTerm)) {
                    $sql = '';
                    switch ($searchCriteria) {
                        case 'orderId':
                            // $sql = "SELECT * FROM orders WHERE order_id = '$searchTerm'";
                            $sql = "SELECT * FROM orders INNER JOIN customers ON orders.customer_id = customers.customer_id WHERE orders.order_id = '$searchTerm'";

                            break;
                        case 'mobile':
                            $sql = "SELECT * FROM customers WHERE customer_contact = '$searchTerm'";
                            break;
                            // Add more cases for other criteria if needed
                        default:
                            break;
                    }

                    if (!empty($sql)) {
                        $result = mysqli_query($conn, $sql);

                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Output the order details
                                echo '<div class="col-lg-2  p-4">';
                                echo '<h5 class="my-0">Order Date</h5>';
                                echo '<h6 class="mx-4 my-0">' . $row["order_date"] . '</h6>';
                                echo '<h6 class="mx-4 my-0">' . $row["order_time"] . '</h6>';
                                echo '</div>';

                                echo '<div class="col-2  p-4">';
                                echo '<h6 class="m-auto">' . $row["order_id"] . '</h6>';
                                echo '<button type="submit" class="btn btn-success prepaid">Prepaid</button>';
                                echo '</div>';

                                echo '<div class="col-lg-3  p-4 m-auto">';
                                echo '<h6 class="buyerHeading">Buyer Details:</h6>';
                                echo '<h6 class="my-0">' . $row["customer_id"] . '</h6>';
                                echo '<h6 class="my-0">' . ($row["customer_name"] ?? 'Not available') . '</h6>';
                                echo '<h6 class="my-0">' . ($row["customer_address"] ?? 'Not available') . ', ' . ($row["customer_city"] ?? 'Not available') . ', ' . ($row["customer_state"] ?? 'Not available') . '</h6>';
                                echo '<h6 class="my-0">Email: ' . ($row["customer_email"] ?? 'Not available') . '</h6>';
                                echo '<h6 class="my-0">Phone: ' . ($row["customer_contact"] ?? 'Not available') . ' Pincode: ' . ($row["customer_pincode"] ?? 'Not available') . '</h6>';
                                echo '</div>';

                                echo '<div class="col-lg-2 p-4 text-center">';
                                echo '  <h6 class="text-danger my-0">Payment</h6>';
                                echo '  <h6 class="text-center">Total: ' . $row["price"] . '</h6>';
                                echo '</div>';

                                echo '<div class="col-lg-1  p-4">';
                                echo '  <button type="submit" class="btn btn-secondary trackbtn">TRACK</button>';
                                echo '</div>';

                                echo '<div class="col-lg-2 p-4">';
                                echo '  <a href="#">Generate Invoice</a>';
                                echo '</div>';

                                echo '</div>';


                                echo '<div class="card mx-4 my-4 border-none shadow-lg" style="max-width: 640px;">';
                                echo '<div class="row g-0">';
                                echo '<div class="col-md-4 p-2">';
                                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['product_img']) . '" class="img-fluid rounded-start" alt="Product Image" width="150px">';
                                echo '</div>';


                                echo '<div class="col-md-8">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">';
                                echo '<a href="#">' . $row["product_name"] . '</a>';
                                echo '</h5>';

                                echo '<div class="card-text row">';
                                echo '<div class="col">';

                                echo '<h6>Model: ';
                                echo $row["model"];
                                echo '</h6>';

                                echo '<h6>Price: Rs: ';
                                echo $row["price"];
                                echo '</h6>';

                                echo '<h6>Data: ';
                                echo $row["order_date"] . ' ' . $row["order_time"];
                                echo '</h6>';
                                echo '<h6>Discount: ';
                                echo $row["discount"];
                                echo '</h6>';
                                echo '</div>';

                                echo '<div class="col">';
                                echo '<h6>Qty: ';
                                echo $row["quantity"];
                                echo '</h6>';
                                echo '<h6>Delivery Charge:';
                                echo $row["delivery_charges"];
                                echo '</h6>';
                                echo '<h6>Status: ';
                                echo $row["order_status"];
                                echo '</h6>';
                                echo '</div>';

                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                    }

                    mysqli_free_result($result);
                    mysqli_close($conn);
                } else {
                    echo '<div class="col-lg-12">';
                    echo '<p class="text-center mt-3">No results found</p>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</body>

</html>