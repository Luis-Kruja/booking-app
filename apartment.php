<?php
// Sample data for apartments (normally, this would come from a database)
$apartments = [
    1 => [
        "name" => "Sea View Deluxe",
        "description" => "Spacious 2-bedroom apartment with a stunning sea view. Fully furnished and perfect for families.",
        "images" => ["assets/apartment1.jpg", "assets/apartment1_2.jpg", "assets/apartment1_3.jpg"],
        "price" => "$150 per night"
    ],
    2 => [
        "name" => "Cozy Beachfront Studio",
        "description" => "Modern studio apartment steps away from the beach. Ideal for couples or solo travelers.",
        "images" => ["assets/apartment2.jpg", "assets/apartment2_2.jpg", "assets/apartment2_3.jpg"],
        "price" => "$100 per night"
    ],
    3 => [
        "name" => "Luxury Penthouse",
        "description" => "Top-floor penthouse with panoramic sea views and premium amenities. Perfect for a lavish stay.",
        "images" => ["assets/apartment3.jpg", "assets/apartment3_2.jpg", "assets/apartment3_3.jpg"],
        "price" => "$300 per night"
    ]
];

// Get the selected apartment ID from the query string
$apartmentId = $_GET['id'] ?? 1; // Default to 1 if no ID is provided
$apartment = $apartments[$apartmentId];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $apartment['name']; ?> - Shengjini Apartments</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<!-- Navbar -->
<?php include 'includes/navbar.php'; ?>

<!-- Apartment Details -->
<section class="apartment__details">
    <div class="apartment__header">
        <h1><?php echo $apartment['name']; ?></h1>
        <p><?php echo $apartment['description']; ?></p>
        <h2>Price: <?php echo $apartment['price']; ?></h2>
    </div>

    <!-- Apartment Images -->
    <div class="apartment__images">
        <?php foreach ($apartment['images'] as $image): ?>
            <img src="<?php echo $image; ?>" alt="Image of <?php echo $apartment['name']; ?>" class="apartment__image">
        <?php endforeach; ?>
    </div>

    <!-- Booking Section -->
    <div class="apartment__booking">
        <h2>Book Your Stay</h2>
        <form action="book.php" method="POST" class="booking__form">
            <input type="hidden" name="apartment_id" value="<?php echo $apartmentId; ?>">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="dates">Dates:</label>
            <input type="date" id="dates" name="dates" required>
            <button type="submit" class="apartment__button">Book Now</button>
        </form>
    </div>

    <!-- Review Section -->
    <div class="apartment__reviews">
        <h2>Reviews</h2>
        <p>No reviews yet. Be the first to leave a review!</p>
        <form action="review.php" method="POST" class="review__form">
            <input type="hidden" name="apartment_id" value="<?php echo $apartmentId; ?>">
            <label for="review">Your Review:</label>
            <textarea id="review" name="review" rows="4" required></textarea>
            <button type="submit" class="apartment__button">Submit Review</button>
        </form>
    </div>
</section>

</body>
</html>
