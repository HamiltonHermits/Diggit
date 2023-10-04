<?php
include('../Backend_Files/database_connect.php');

if (isset($_POST['deleteComment'])) {
    // Validate and sanitize the page_id and comment_id
    $pageId = isset($_POST['page_id']) ? intval($_POST['page_id']) : 0;
    $reviewId = isset($_POST['review_id']) ? intval($_POST['review_id']) : 0;

    if ($pageId > 0 && $reviewId > 0) {
        // Create and execute a SQL query to delete the comment
        $deleteQuery = "DELETE FROM hamiltonhermits.review WHERE review_id = ?";
        $stmt = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($stmt, "i", $reviewId);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../PropertyPage/property.php?id=$pageId");
            exit;
        } else {
            // Handle the deletion error
            echo "Error deleting comment: " . mysqli_error($conn);
        }
    }
} else {
    // Handle invalid or unauthorized requests
    echo "Invalid request.";
}
?>

