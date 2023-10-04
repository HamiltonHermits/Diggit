<?php
include('../Backend_Files/database_connect.php');

// Define your SQL query based on the sorting option
$propId = $_GET["id"];
$sort_option = isset($_GET['sort']) ? $_GET['sort'] : 'desc';

switch ($sort_option) {
    case 'asc':
        $sql = "SELECT *
        FROM hamiltonhermits.review
        JOIN hamiltonhermits.usertbl ON usertbl.user_id = review.user_id
        JOIN hamiltonhermits.property ON property.prop_id = review.prop_id
        WHERE property.prop_id=$propId
        ORDER BY overall_property_rating ASC";
        break;
    case 'oldest':
        $sql = "SELECT *
        FROM hamiltonhermits.review
        JOIN hamiltonhermits.usertbl ON usertbl.user_id = review.user_id
        JOIN hamiltonhermits.property ON property.prop_id = review.prop_id
        WHERE property.prop_id=$propId
        ORDER BY date_reviewed ASC";
        break;
    case 'newest':
        $sql = "SELECT *
        FROM hamiltonhermits.review
        JOIN hamiltonhermits.usertbl ON usertbl.user_id = review.user_id
        JOIN hamiltonhermits.property ON property.prop_id = review.prop_id
        WHERE property.prop_id=$propId ORDER BY date_reviewed DESC";
        break;
    case 'desc':
    default:
         $sql = "SELECT *
         FROM hamiltonhermits.review
         JOIN hamiltonhermits.usertbl ON usertbl.user_id = review.user_id
         JOIN hamiltonhermits.property ON property.prop_id = review.prop_id
         WHERE property.prop_id=$propId
         ORDER BY overall_property_rating DESC";
           break;
}

// Execute the SQL query
$result = mysqli_query($conn, $sql);
if ($result === false) {
    die("Database query failed: " . mysqli_error($conn));
}

// Display comments
while ($row = mysqli_fetch_assoc($result)) {
    $review_id = $row['review_id']; 

    echo '<div class ="comment-container">';
    echo '<div class = "star-rating-comment">★ Rating: ' . $row['overall_property_rating'] . '</div>';
    echo '<div class = "username-date-comment">' . $row['username'] . ' - ' . $row['date_reviewed'] . '</div>';
    echo '<div class = "description-comment">' . $row['written_review'] . '</div>';

    echo "<!-- delete form for button --> ";
    echo "<form id=\"deleteCommentForm\" action=\"delete.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"page_id\" value=\"{$propId}\">";
    echo "<input type=\"hidden\" name=\"review_id\" value=\"{$review_id}\">"; 
    echo "<input class=\"filledButton\" type=\"submit\" name=\"deleteComment\" value=\"Delete Comment\"/>";
    echo "</form>";

    echo "  <!-- Runs delete comment code -->";
}

// Close the database connection
mysqli_close($conn);
?>