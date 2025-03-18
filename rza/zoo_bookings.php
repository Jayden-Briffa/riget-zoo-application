<?php 
$pageTitle = "Book a visit";
$bodyClasses = "";
$mainClasses = "";

$heroHeader = "Visit us for a day of family fun!";

$jsImports = [];

include_once "templates/header.php";
include_once "templates/hero.php";

if (!isset($_SESSION["user_id"])){
    header("Location: account.php?redirected=true");
}

include_once "includes/zoo_view.inc.php";

$booking_errors = check_zoo_booking_errors() ?? null;
$booking_data = $_SESSION['zoo_booking_data'] ?? null;

display_all_zoo_alerts();
?>

<section class="pb-0">
    <?php include "templates/loyalty-bar.php" ?>
</section>

<section>
    <h2>Zoo booking</h2>
    <div class="d-flex justify-content-center">
        <img src="./images/bear.png" alt="Bear">
    </div>
    
    <form action="./includes/zoo_insert.inc.php" method="post">

        <!-- Visit date -->
        <div class="mb-3">
            <label for="visit-date" class="form-label">Date of visit</label>
            <input type="date" name="visit-date" value="<?= $booking_data['visit_date'] ?? '' ?>" class="form-control" id="visit-date">
        </div>

        <!-- Adult tickets -->
        <div class="mb-3">
            <label for="adult-tickets" class="form-label">Adult tickets <span class="fs-6">(£15pp)</span></label>
            <input type="number" min="0" step="1" name="adult-tickets" value="<?= $booking_data['adult_tickets'] ?? '' ?>"  class="form-control" id="adult-tickets">
        </div>

        <!-- Child tickets -->
        <div class="mb-3">
            <label for="child-tickets" class="form-label">Child tickets <span class="fs-6">(£10pp)</span></label>
            <input type="number" min="0" step="1" name="child-tickets" value="<?= $booking_data['child_tickets'] ?? '' ?>"   class="form-control" id="child-tickets">
        </div>

        <div class="col-auto">
            <button type="submit" class="btn mb-3">Reserve</button>
        </div>
        
        <div class="form-error mb-5" id="booking-errors"><?= $booking_errors ?></div>
    </form>

    <p>For your bookings, go to <a href="account.php">my account</a></p>
</section>

<?php include_once "templates/footer.php"; ?>