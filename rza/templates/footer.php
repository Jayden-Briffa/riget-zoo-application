</main>

<footer class="d-flex bg-darkbrown w-100 p-2 justify-content-between">
    <p>&copy;Riget Zoo Adventures 2025</p>
    <a href="tos.php">Terms and conditions</a>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="js/accessibility.js"></script>
<!-- <script src="js/accessibility.js"></script> -->
<?php foreach ($jsImports as $jsFile){
    echo "<script src='js/" . $jsFile . "'></script>";
}?> 

</body>

</html>