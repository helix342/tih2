<?php
include("db.php");

//Add new User
if (isset($_POST['save_newuser'])) {
    try {


        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $dept = mysqli_real_escape_string($conn, $_POST['dept']);


        $query = "INSERT INTO user(name, dept) VALUES ('$name', '$dept')";

        if (mysqli_query($conn, $query)) {
            $res = [
                'status' => 200,
                'message' => 'Details Updated Successfully'
            ];
            echo json_encode($res);
        } else {
            throw new Exception('Query Failed: ' . mysqli_error($conn));
        }
    } catch (Exception $e) {
        $res = [
            'status' => 500,
            'message' => 'Error: ' . $e->getMessage()
        ];
        echo json_encode($res);
    }
}

//delete User
if (isset($_POST['delete_user'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['user_id']);
  
    $query = "DELETE FROM user WHERE id='$student_id'";
    $query_run = mysqli_query($conn, $query);
  
    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'Details Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Details Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
  }



?>