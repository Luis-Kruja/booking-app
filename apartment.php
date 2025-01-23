<?php
// Sample data for apartments (normally, this would come from a database)
$apartments = [
    1 => [
        "name" => "Sea View Deluxe",
        "description" => "Spacious 2-bedroom apartment with a stunning sea view. Fully furnished and perfect for families.",
        "images" => ["assets/apartment1/photo1.jpg","assets/apartment1/photo2.jpg","assets/apartment1/photo3.jpg","assets/apartment1/photo4.jpg","assets/apartment1/photo5.jpg"],
        "price" => "$150 per night"
    ],
    2 => [
        "name" => "Cozy Beachfront Studio",
        "description" => "Modern studio apartment steps away from the beach. Ideal for couples or solo travelers.",
        "images" => ["assets/apartment2/photo3.jpg", "assets/apartment2/photo2.jpg", "assets/apartment2/photo1.jpeg", "assets/apartment2/photo4.jpg", "assets/apartment2/photo5.jpg"],
        "price" => "$100 per night"
    ],
    3 => [
        "name" => "One-room-apartment",
        "description" => "Perfect view and commodity for a lovely couple.",
        "images" => ["assets/apartment3/photo1.jpg", "assets/apartment3/photo2.jpg", "assets/apartment3/photo3.jpg", "assets/apartment3/photo4.jpg"],
        "price" => "$120 per night"
    ],
    4 => [
        "name" => "Lovebirds-apartment",
        "description" => "An apartment with everything that you need to make your stay comfortable and enjoyable.",
        "images" => ["assets/apartment4/photo1.jpg", "assets/apartment4/photo2.jpg", "assets/apartment4/photo3.jpg", "assets/apartment4/photo4.jpg"],
        "price" => "$220 per night"
    ],
        5 => [
            "name" => "Luxury Penthouse",
            "description" => "Top-floor penthouse with panoramic sea views and premium amenities. Perfect for a lavish stay.",
            "images" => ["assets/apartment5/photo1.jpg", "assets/apartment5/photo2.jpg", "assets/apartment5/photo3.jpg", "assets/apartment5/photo4.jpg"],
            "price" => "$200 per night"
    ]
];

// Get the selected apartment ID from the query string
$apartmentId = $_GET['id'] ?? 1; // Default to 1 if no ID is provided
$apartment = $apartments[$apartmentId];



?>

<?php
session_start();

if (!isset($_SESSION['email']) && !isset($_SESSION['step'])) {
    header('Location: login.php');
}

if (isset($_SESSION['email']) && isset($_SESSION['step'])) {
    header('Location: verifyEmail.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $apartment['name']; ?> - Shengjini Apartments</title>
    <link rel="stylesheet" href="style.css?">
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
        <div class="carousel">
            <div class="carousel__inner">
                <?php foreach ($apartment['images'] as $image): ?>
                    <img src="<?php echo $image; ?>" alt="Image of <?php echo $apartment['name']; ?>" class="carousel__image">
                <?php endforeach; ?>
            </div>
            <button class="carousel__button carousel__button--prev">&lt;</button>
            <button class="carousel__button carousel__button--next">&gt;</button>
        </div>
    </div>

    <!-- Booking Section -->
    <div class="apartment__booking">
        <h2>Book Your Stay</h2>
        <form action="book.php" method="POST" class="booking__form">
            <input type="hidden" name="apartment_id" value="<?php echo $apartmentId; ?>">
            <input type="text" id="name" name="name" placeholder="name" required >
            <label for="name">Name:</label>
            <input type="email" id="email" name="email" placeholder="email" required>
            <label for="email">Email:</label>
            <input type="date" id="check_in" name="check_in" placeholder="check in" required>
            <input type="date" id="check_out" name="check_out" placeholder="check out" required>
            <button type="submit" class="apartment__button">Book Now</button>
        </form>
    </div>

    <!-- Review Section -->
    <div class="apartment__reviews">
        <h2>Reviews</h2>
        <p>No reviews yet. Be the first to leave a review!</p>
        <form action="review.php" method="POST" class="review__form">
            <input type="hidden" name="apartment_id" value="<?php echo $apartmentId; ?>">
            <textarea id="review" name="review" rows="4" required></textarea>
            <button type="submit" class="apartment__button">Submit Review</button>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
<script src="app.js"></script>
</body>
</html>
