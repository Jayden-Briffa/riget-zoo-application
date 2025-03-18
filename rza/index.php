<?php 
$pageTitle = "Home";
$bodyClasses = "";
$mainClasses = "";

$heroHeader = "Welcome to Riget Zoo Adventures!";

$jsImports = [];

include_once "templates/header.php";
include_once "templates/hero.php";
?>

<section>
    <h2>Lost? Check the map!</h2>
    <img src="./images/map.webp" alt="Zoo map" class="rounded align-self-center w-50">
</section>

<section>
    <h2>What's going on at Riget?</h2>

    <div class="d-flex flex-column flex-lg-row w-100 justify-content-around align-items-center gap-2">
    
        <?php 
            $animals = [
                ["./images/promotional-penguins.webp", "Penguins", "Come see the penguins"],
                ["./images/promotional-elephants.webp", "Elephants", "Come see the elephants"],
                ["./images/promotional-llamas.webp", "Llamas", "Come see the llamas"]
            ];

            foreach ($animals as $animal) {
                $src = $animal[0];
                $title = $animal[1];
                $contentText = $animal[2];

                include "./templates/promotional-card.php";
            }
        ?>
    </div>
 
</section>

<section>
    <h2>New cafe facility!</h2>
    <img src="./images/new-cafe.webp" alt="New cafe!" class="rounded-5">
</section>

<section>
    <h2>Ready to learn?</h2>

    <div class="d-flex flex-row gap-2 justify-content-around">
        <p>We have plenty of resources ready for you and any young people to learn from!</p>
        <a href="resources.php"><button type="button" class="btn text-nowrap">To resources &#8594;</button></a>
    </div>
</section>

<?php include_once "templates/footer.php"; ?>