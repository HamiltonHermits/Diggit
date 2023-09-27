<?php
include('../Backend_Files/database_connect.php');
// Define your SQL query based on the sorting option
$sort_option = isset($_GET['sort-comments']) ? $_GET['sort-comments'] : 'desc';

switch ($sort_option) {
    case 'asc':
        $sql = "SELECT * FROM review,usertbl WHERE usertbl.user_id=review.user_id ORDER BY avg_prop_review ASC";
        break;
    case 'oldest':
        $sql = "SELECT * FROM review,usertbl WHERE usertbl.user_id=review.user_id ORDER BY avg_prop_review ASC";
        break;
    case 'newest':
        $sql = "SELECT * FROM review,usertbl WHERE usertbl.user_id=review.user_id ORDER BY avg_prop_review DESC";
        break;
    case 'desc':
    default:
        $sql = "SELECT * FROM review,usertbl WHERE usertbl.user_id=review.user_id ORDER BY avg_prop_review DESC";
        break;
}

// Execute the SQL query and fetch comments
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

// Display comments
while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="comment">';
    echo '<h3>' . '<strong>' . $row['username'] . ':</p>' . '</strong>'. '</h3>';
    echo '<p>' . $row['written_review'] . '</p>';
    echo '<p>Rating: ' . $row['avg_prop_review'] . '</p>';
    echo '<p>Date: ' . $row['date_reviewed'] . '</p>';
    echo '</div>';
}

// Close the database connection
mysqli_close($conn);
?>