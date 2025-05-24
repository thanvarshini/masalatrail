<?php
// DB connection variables (edit as per your setup)
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'masala_trail'; // change this if needed

// Connect to DB
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get email and address from form
$email = $_POST['email'];
$address = $_POST['address'];

// Check if spices are selected
if (isset($_POST['spices']) && is_array($_POST['spices'])) {
    $spices = $_POST['spices'];
    $totalOrderPrice = 0;

    foreach ($spices as $spice) {
        // Get quantity for each spice
        $quantityField = 'quantity_' . str_replace(' ', '_', $spice);
        $quantity = isset($_POST[$quantityField]) ? (int)$_POST[$quantityField] : 0;

        // Define spice prices (same as HTML)
        $prices = [
            'Cardamom' => 350,
            'Black Pepper' => 80,
            'Clove' => 120,
            'Cumin' => 35,
            'Fennel' => 85,
            'Cinnamon' => 40,
            'Bay Leaves' => 199,
            'Fenugreek' => 249,
            'Carom' => 299,
            'Mustard' => 10,
            'Star Anise' => 199
        ];

        $price_per_unit = $prices[$spice];
        $spice_total = $price_per_unit * $quantity;
        $totalOrderPrice += $spice_total;

        // Insert into DB
        $stmt = $conn->prepare("INSERT INTO orders (email, spice_name, quantity, price_per_unit, total_price, address) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiss", $email, $spice, $quantity, $price_per_unit, $spice_total, $address);
        $stmt->execute();
    }

    echo "<script>alert('Order placed successfully! Total cost: ₹$totalOrderPrice.'); window.location.href = 'thankyou.html';</script>";
} else {
    echo "<script>alert('No spices selected! Please select at least one spice.'); window.history.back();</script>";
}

$conn->close();
?>
