<?php
$pageTitle = "Account";
$bodyClasses = "";
$mainClasses = "";

$heroHeader = "My Account";

$jsImports = [];

include_once "templates/header.php";
include_once "templates/hero.php";

include_once "includes/dbh.inc.php";
include_once "includes/zoo_view.inc.php";
include_once "includes/hotel_view.inc.php";

$signup_errors = check_signup_errors();
$signup_data = $_SESSION["signup_data"] ?? null;

$login_errors = check_login_errors();
$login_data = $_SESSION["login_data"] ?? null;

$zoo_errors = check_zoo_booking_errors();
$zoo_data = $_SESSION["zoo_booking_data"] ?? null;

$hotel_errors = check_hotel_booking_errors();
$hotel_data = $_SESSION["hotel_booking_data"] ?? null;
?>

<?php 

// Show all alerts from user signup
display_all_signup_alerts();

// Show all alerts from zoo bookings
display_all_zoo_alerts();

// Show all alerts from hotel bookings
display_all_hotel_alerts();


?>

<!-- Shows if the user has logged in -->
<?php if (isset($_SESSION["user_id"])) { ?>
<section>
    <div class="d-flex flex-column align-content-center main-section">
        <h2>Account</h2>
        <a href="includes/logout.inc.php" class="align-self-center"><button type="button" class="btn">Logout</button></a>
    </div>

    <section class="align-content-center main-section">
        <h2>Accessibility options</h2>

        <div class="d-flex flex-column align-content-center">
            <h3>Theme</h3>
            <button type="button" onclick="toggleTheme()" class="btn align-self-center w-lg-50 w-md-50 w-sm-100" id="theme-btn">To dark mode</button>
        </div>

        <div class="d-flex flex-column align-content-center">
            <h3>Font size</h3>

            <div class="d-flex flex-column flex-md-row gap-2">
                <button type="button" onclick="setFontSize('small')" class="btn m-1" id="theme-btn">Small</button>
                <button type="button" onclick="setFontSize('medium')" class="btn m-1" id="theme-btn">Medium</button>
                <button type="button" onclick="setFontSize('large')" class="btn m-1" id="theme-btn">Large</button>
            </div>

            <div class="text-center mt-3" id="curr-font-size"></div>
            
        </div>
    </section>

    <section class="pb-3 mb-5 w-100 bg-brown rounded-5" id="user-zoo-bookings">
        <h2 class="text-light">My zoo bookings</h2>

        <?php 
        $user_id = $_SESSION['user_id'];
        show_zoo_bookings($pdo, $user_id) 
        ?>

        <div class="form-error"><?= $zoo_errors ?></div>

    </section>

    <section class="pb-3 mb-5 w-100 bg-brown rounded-5" id="user-hotel-bookings">
        <h2 class="text-light">My hotel bookings</h2>

        <?php 
        show_hotel_bookings($pdo, $user_id) 
        ?>

    </section>
</section>

<?php } else { ?>

<!-- Shows if the user has not logged in -->
<section id="login-or-signup">
    <section id="account-login">
        <h1>Login to your account</h1>

        <form action="includes/login.inc.php" method="post" class="d-flex flex-column justify-content-start mt-4 p-3 rounded-5">

            <!-- Email -->
            <div class="mb-3">
                <label for="login-email" class="form-label">Email address *</label>
                <input type="email" name="email" value="<?= $login_data['email'] ?? '' ?>" class="form-control" id="login-email">
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="login-password" class="form-label">Password *</label>
                <input type="password" name="password" class="form-control" id="login-password">
            </div>

            <button type="submit" class="btn">Submit</button>

            <div class="form-error mt-2" id="login-errors"><?= $login_errors ?></div>
        
        </form>

    </section>

    <hr class="mb-auto mt-5">

    <!-- ACCOUNT SIGNUP -->
    <section class="mt-5" id="account-signup">
        <p>Don't already have an account?</p>
        <h1>Sign up for an account</h1>

        <form action="includes/signup.inc.php" method="post" class="d-flex flex-column justify-content-start mt-4 p-3 rounded-5">
            <div class="row align-items-start gap-0">

                <!-- First name -->
                <div class="mb-3 col-md">
                    <label for="signup-fname" class="form-label">First name *</label>
                    <input type="text" name="fname" value="<?= $signup_data['fname'] ?? '' ?>" class="form-control" id="signup-fname">
                </div>

                <!-- Surname -->
                <div class="mb-3 col-md">
                    <label for="signup-surname" class="form-label">Surname *</label>
                    <input type="text" name="surname" value="<?= $signup_data['surname'] ?? '' ?>" class="form-control" id="signup-surname">
              </div>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="signup-email" class="form-label">Email address *</label>
                <input type="email" name="email" value="<?= $signup_data['email'] ?? '' ?>" class="form-control" id="signup-email">
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="signup-password" class="form-label">Password *</label>
                <input type="password" name="password" class="form-control" id="signup-password" aria-describedby="passwordRequirementHelp">
            </div>

            <!-- Confirm password -->
            <div class="mb-0">
                <label for="signup-confirmPassword" class="form-label">Confirm password *</label>
                <input type="password" name="confirmPassword" class="form-control" id="signup-confirmPassword">
            </div>

            <div id="passwordRequirementHelp" class="form-text mb-3">
                Your password must be at least 8 characters long
            </div>

            <!-- Consent to usage of information -->
            <div class="mb-3 form-check">
                <input type="checkbox" name="consentGiven" class="form-check-input" id="signup-consent">
                <label class="form-check-label" for="signup-consent">I consent to Riget Zoo Adventures storing my data and to the <a href="tos.php">Terms and</a></label>
            </div>

            <button type="submit" class="btn">Submit</button>

            <div class="form-error mt-2" id="signup-errors"><?= $signup_errors ?></div>
        </form>

    </section>
</section>

<?php } ?>
<?php include_once "templates/footer.php"; ?>