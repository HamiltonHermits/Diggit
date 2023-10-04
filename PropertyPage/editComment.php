<?php
include('../Backend_Files/database_connect.php');

if (isset($_POST['editComment'])) {
    
    $commentId = isset($_POST['comment_id']) ? intval($_POST['comment_id']) : 0;
    $editedComment = isset($_POST['edited_comment']) ? trim($_POST['edited_comment']) : '';
    $pageId = isset($_POST['page_id']) ? intval($_POST['page_id']) : 0;

    if ($commentId > 0 && !empty($editedComment)) {

        $updateQuery = "UPDATE review SET written_review = ? WHERE review_id = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmt, "si", $editedComment, $commentId);

        if (mysqli_stmt_execute($stmt)) {


            header("Location: ../PropertyPage/property.php?id=$pageId");
            exit;
        } else {

            echo "Error updating comment: " . mysqli_error($conn);
        }
    } else {

        echo "Invalid input data.";
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>