<?php 
$pageTitle = "Resources";
$bodyClasses = "";
$mainClasses = "";

$heroHeader = "Learn with our educational resources";

$jsImports = [];

include_once "templates/header.php";
include_once "templates/hero.php";

function print_resources($included_category, $classes){
    $resources = [
        ["Forest", "./images/pdf.webp", "./resources/habitat_1.pdf", "Habitats"],
        ["Lake", "./images/pdf.webp", "./resources/habitat_2.pdf", "Habitats"],
        ["Plains", "./images/pdf.webp", "./resources/habitat_3.pdf", "Habitats"],
        ["Mountain", "./images/pdf.webp", "./resources/habitat_4.pdf", "Habitats"],
    
        ["Elephants", "./images/pdf.webp", "./resources/animal_1.pdf", "Animals"],
        ["Lions", "./images/pdf.webp", "./resources/animal_2.pdf", "Animals"],
        ["Llamas", "./images/pdf.webp", "./resources/animal_3.pdf", "Animals"],
        ["Penguins", "./images/pdf.webp", "./resources/animal_4.pdf", "Animals"]
    ];

    foreach ($resources as $resource) {
        $title = $resource[0];
        $img_src = $resource[1];
        $img_alt = $title;
        $path = $resource[2];
        $category = $resource[3];

        if ($category === $included_category){
            include "./templates/resource.php";
        }
    } 
}
?>

<section>
    <h2>Habitats</h2>
    <div class="row justify-content-center mt-2">
        <?php print_resources("Habitats", "bg-yellow") ?>
    </div>
</section>

<section>
    <h2>Animals</h2>
    <div class="row justify-content-center mt-2">
        <?php 
            print_resources("Animals", "bg-green")
        ?>
    </div>
   
</section>

<?php include_once "templates/footer.php"; ?>