<?php
session_start();
include("config.php");

if (!isset($_SESSION['admin'])) {
    header("Location:{$hostname}/index.php");
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT status FROM players WHERE p_id=$id";
    $result = mysqli_query($conn, $sql) or die("Query Failed.");
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['status'] == 0) {
            $sql1 = "UPDATE players SET status=1 WHERE p_id = $id";
            if (mysqli_query($conn, $sql1)) {
                header("Location:{$hostname}/players.php");
            } else {
                echo "<div class='alert alert danger'>Profile not Change.</div>";
            }
        } else {
            $sql1 = "UPDATE players SET status=0 WHERE p_id = $id";
            if (mysqli_query($conn, $sql1)) {
                header("Location:{$hostname}/players.php");
            } else {
                echo "<div class='alert alert danger'>Profile not Change.</div>";
            }

        }
    }

}
?>