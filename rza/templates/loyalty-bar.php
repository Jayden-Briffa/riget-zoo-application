<?php
    include "./includes/dbh.inc.php";
    include "./includes/login_model.inc.php";

    $user_id = $_SESSION['user_id'];
    $goal = 150;
    $user_spend = get_user_running_spend($pdo, $user_id);
    
    if ($user_spend > $goal){
        ?>
        <div class="bg-yellow p-2 rounded">
            <h2 class="text-dark-brown">You've got a free ticket!</h2>
        </div>
        
        <?php
    } else {
        $remaining = $goal - $user_spend;
        $spend_percentage = $user_spend / $goal * 100;

        ?>
            <label for="loyalty-bar" class="text-center">You are £<?= $remaining ?> away from a free trip to the zoo!</label>
            <div class="bg-yellow w-100 h-100 border border-2 border-black" id="loyalty-bar">
                <div class="bg-green" style="width: <?= $spend_percentage ?>%;">
                    <br>
                </div>
            </div>
        <?php
    }
?>