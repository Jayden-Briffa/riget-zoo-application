<?php 
$pageTitle = "Hotel";
$bodyClasses = "";
$mainClasses = "";

$heroHeader = "Stay with us at the hotel!";

$jsImports = [];

include_once "templates/header.php";
include_once "templates/hero.php";

if (!isset($_SESSION["user_id"])){
    header("Location: account.php?redirected=true");
}

include_once "includes/hotel_view.inc.php";

$booking_errors = check_hotel_booking_errors() ?? null;
$booking_data = $_SESSION['hotel_booking_data'] ?? null;

display_all_hotel_alerts();
?>


<section class="pb-0">
    <?php include "templates/loyalty-bar.php" ?>
</section>

<section>

    <h2>Hotel booking</h2>
    <div class="d-flex justify-content-center mb-4">
        <img src="./images/hotel.png" alt="Bear">
    </div>
    
    <form action="./includes/hotel_insert.inc.php" method="post">

        <!-- Stay date -->
        <div class="mb-3">
            <label for="stay-date" class="form-label">Date of first night</label>
            <input type="date" name="stay-date" value="<?= $booking_data['stay_date'] ?? '' ?>" class="form-control" id="stay-date">
        </div>

        <!-- Number of nights -->
        <div class="mb-3">
            <label for="num-nights" class="form-label">How many nights will you stay for? <span class="fs-6">(£20/ night)</span></label>
            <input type="number" min="0" step="1" name="num-nights" value="<?= $booking_data['num_nights'] ?? '' ?>" class="form-control" id="num-nights">
        </div>

        <!-- Submit -->
        <div class="row justify-content-between">
            <div class="col-12 col-md-4">
                <button type="submit" class="btn mb-3 w-100">Reserve</button>
            </div>

            <div class="col-12 col-md-6 d-flex">
                <button type="submit" class="btn mb-3 w-100" formaction="includes/hotel_availability.inc.php">Check availability</button>
            </div>
        </div>

        <!-- Errors -->
        <div class="form-error mb-5" id="booking-errors"><?= $booking_errors ?></div>
    </form>

    <p>For your bookings, go to <a href="account.php">my account</a></p>
</section>

<?php include_once "templates/footer.php"; ?>