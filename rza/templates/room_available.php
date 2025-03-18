<?php
    $bg_color = $available === "YES" ? "bg-green" : "bg-yellow";
?>

<section class="d-flex flex-row row gap-0 text-center hover-grow my-1 shadow-dark align-items-center <?= $bg_color ?>">
    <p class="col-6"><?= $night_date ?></p>
    <p class="col-6"><?= $available ?></p>
</section>