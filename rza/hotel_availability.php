<?php 
$pageTitle = "Hotel availability";
$bodyClasses = "";
$mainClasses = "";

$heroHeader = "Hotel availability";

$jsImports = [];

include_once "templates/header.php";
include_once "templates/hero.php";

include_once "includes/hotel_view.inc.php";

$booking_errors = check_hotel_booking_errors() ?? null;
$booking_data = $_SESSION['hotel_booking_data'] ?? null;
$availability = $_SESSION['availability'] ?? null;

// If there is no booking data, send the user back
if (!$booking_data){
    header('Location: account.php?redirected=true');
}

?>

<section>
    <h2>Showing availability from <br> <?= $booking_data['start_date'] ?> to <?= $booking_data['end_date'] ?></h2>

    <div class="d-flex flex-column flex-md-row justify-content-around w-100 gap-3 mt-5">

        <!-- Output data -->
        <section class="d-flex flex-column p-4 bg-brown rounded flex-grow-1 flex-md-grow-0 w-100">

            <?php

            if ($availability){ ?>
                <section class="row text-center fs-3" id="table-header">
                    <p class="col-6">Date</p>
                    <p class="col-6">Available</p>
                </section>


                <section class="d-flex flex-column gap-1">
                    <?php
                        // Iterate through $availability
                        foreach ($availability as $date_availability){ 

                            // Store attributes of array as variables and output them
                            $night_date = $date_availability['night_date'];
                            $available = $date_availability['available'];
                            
                            include "./templates/room_available.php";
                        }
                    } else { ?>
                        <p>No data could be found</p>
                    <?php } ?>
                </section>
        </section>

        <section>        
        <!-- Input dates form -->
            <form method="post" action="includes/hotel_availability.inc.php" class="bg-yellow rounded p-3 align-self-center flex-grow-1 flex-md-grow-0 w-100 order-md-first border-brown border-3">

                <div class="mb-3">
                    <label for="start-date" class="form-label fs-5">Show dates from...</label>
                    <input type="date" name="start-date" value="<?= $booking_data['start_date'] ?? '' ?>" class="form-control" id="start-date">
                </div>

                <div class="mb-3">
                    <label for="end-date" class="form-label fs-5">To...</label>
                    <input type="date" name="end-date" value="<?= $booking_data['end_date'] ?? '' ?>" class="form-control" id="end-date">
                </div>

                <button type="submit" class="btn">Submit</button>
                <div class="form-error text-dark-red"><?= $booking_errors ?></div>
            </form>
        </section>

    </div>
</section>

<?php include_once "templates/footer.php"; ?>