<form method="post" class="row p-2 bg-yellow rounded shadow-dark">
    <!-- Information -->
    <p class="zoo_adult_tickets col"><?= $adult_tickets ?></p>
    <p class="zoo_child_tickets col"><?= $child_tickets ?></p>
    <p class="zoo_total_cost col"><?= $total_cost ?></p>
    <input type="date" name="visit-date" value="<?= $visit_date ?>" class="zoo_visit_date col form-control bg-translucent fs-5 align-self-center">
    
    <!-- Options -->
    <div class="d-flex gap-1 justify-content-center col-12 col-md">

        <!-- Update -->
        <div class="d-flex flex-grow-1">
            <input type="hidden" name="zoo-booking-id" value="<?= $zoo_booking_id ?>">
            <button type="submit" formaction="includes/zoo_update.inc.php" data-bs-toggle="collapse" data-bs-target="#entry-<?= $zoo_booking_id ?>" aria-expanded="false" aria-controls="entry-<?= $zoo_booking_id ?>" class="btn top-2 flex-grow-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                    <path d="M11 2H9v3h2z"/>
                    <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
               </svg>
            </button>
        </div>

        <!-- Delete -->
        <div class="d-flex flex-grow-1">
            <input type="hidden" name="zoo-booking-id" value="<?= $zoo_booking_id ?>">
            <button type="submit" formaction="includes/zoo_delete.inc.php" class="btn flex-grow-1 no-grow top-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                </svg>
            </button>
        </div>
    </div>
</form>