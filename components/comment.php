<?php
function comment($user_id, $date, $comment) {
    echo "
        <div>
            <div>
                <h2>" . htmlspecialchars($user_id) . "</h2>
                <p>" . htmlspecialchars($date) . "</p>
            </div>
            <div>
                <p>" . htmlspecialchars($comment) . "</p>
            </div>
        </div>"; 
}
?>

