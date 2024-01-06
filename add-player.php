<?php
include("config.php");
session_start();


if (isset($_SESSION['email'])) {
    header("Location:{$hostname}/index.php");
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require './vendor/autoload.php';


if (isset($_POST['submit'])) {
    // function sendmail($email,$name){
    //     $mail = new PHPMailer(true);

    //     try {
    //         $mail->SMTPDebug = 0;
    //         $mail->isSMTP();
    //         $mail->Host = 'smtp.gmail.com;';
    //         $mail->SMTPAuth = true;
    //         $mail->Username = 'kishan2764@gmail.com';
    //         $mail->Password = 'hfjetwquqxtyawuv';
    //         $mail->SMTPSecure = 'tls';
    //         $mail->Port = 587;

    //         $mail->setFrom('kishan2764@gmail.com', 'SPL-2024');
    //         $mail->addAddress($email, $name);
    //         // $mail->addAddress('receiver2@gfg.com', 'Name');

    //         $mail->isHTML(true);
    //         $mail->Subject = 'SPL-2024 Registration';
    //         $mail->Body = "<b style='color:black;font-size: 15px;'>Hi, " . ucwords($name) . "</b><b style='color:blue;font-size: 15px;'><br />Your Registration form is summited successfully. Kindly pay your registration fee. Ignore if pay already.</b>";
    //         $mail->AltBody = 'Body in plain text for non-HTML mail clients';
    //         $mail->send();
    //         // $output = '<div style="font-size:14px;color:red;">OTP has been sent to your email...</div>';
    //     } catch (Exception $e) {
    //         echo '<div>Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    //     }
    // }
    // function sendadmin($phone,$name,$email){
    //     $mail = new PHPMailer(true);

    //     try {
    //         $mail->SMTPDebug = 0;
    //         $mail->isSMTP();
    //         $mail->Host = 'smtp.gmail.com;';
    //         $mail->SMTPAuth = true;
    //         $mail->Username = 'kishan2764@gmail.com';
    //         $mail->Password = 'hfjetwquqxtyawuv';
    //         $mail->SMTPSecure = 'tls';
    //         $mail->Port = 587;

    //         $mail->setFrom('kishan2764@gmail.com', 'SPL-2024');
    //         $mail->addAddress("kishan6436@gmail.com");
    //         // $mail->addAddress('receiver2@gfg.com', 'Name');

    //         $mail->isHTML(true);
    //         $mail->Subject = 'SPL-2024 Registration';
    //         $mail->Body = "<b style='color:black;font-size: 15px;'>A player , " . ucwords($name) . ", just Register.</b><b style='color:blue;font-size: 15px;'><br />Mobile no:- ".$phone. "<br/>Email:-".$email."</b>";
    //         $mail->AltBody = 'Body in plain text for non-HTML mail clients';
    //         $mail->send();
    //         // $output = '<div style="font-size:14px;color:red;">OTP has been sent to your email...</div>';
    //     } catch (Exception $e) {
    //         echo '<div>Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    //     }
    // }
    $name = strip_tags($_POST['name']);
    $email = strip_tags($_POST['email']);
    $phone = strip_tags($_POST['number']);
    $address = strip_tags($_POST['address']);
    $role = strip_tags($_POST['role']);
    $style = strip_tags($_POST['style']);
    $basePrice = strip_tags($_POST['basePrice']);
    if (!empty($_POST['preteam'])) {
        $pre_team = strip_tags($_POST['preteam']);
    } else {
        $pre_team = 0;
    }
    $next_team = strip_tags($_POST['nextteam']);
    $photo = null;
    $fadhar = null;
    $badhar = null;
    $sql = "SELECT email FROM players WHERE email = '{$email}'";
    $result = mysqli_query($conn, $sql) or die("Query failed.");
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Email Allready Exist.');</script>";
    } else {
        //     if(isset($_FILES['photo'])){
        //         $random = rand(1, 999);
        //         $file_name = $_FILES['photo']['name'];
        //         $file_size = $_FILES['photo']['size'];
        //         $file_tmp = $_FILES['photo']['tmp_name'];
        //         $file_type = $_FILES['photo']['type'];
        //         // $target =;

        //         if(move_uploaded_file($file_tmp,"upload/".$file_name)){
        //             echo "upload";
        //         }else{
        //         echo "no upload";
        //         }
        //     }

        // }

        if (isset($_FILES['photo'])) {
            $random = rand(1, 999);
            $error = array();
            $file_name = $_FILES['photo']['name'];
            $file_size = $_FILES['photo']['size'];
            $file_tmp = $_FILES['photo']['tmp_name'];
            $file_type = $_FILES['photo']['type'];
            $exp = explode('.', $file_name);
            $file_ext = end($exp);
            $extension = array("jpeg", "jpg", "png");

            if (in_array($file_ext, $extension) === false) {
                $error[] = "This extension file are not allowed, Please choose a JPG or PNG file.";
            }
            if ($file_size > 125829120) {
                $error[] = "File size must be 12mb or lower.";
            }
            $target = time() . "-" . $random . ".jpg";

            if (empty($error) == true) {
                move_uploaded_file($file_tmp, "upload/" . $target);
                if (move_uploaded_file($file_tmp, "upload/" . $target)) {
                    $photo = $target;
                    if (isset($_FILES['fadhar'])) {
                        $random1 = rand(1, 999);
                        $error1 = array();
                        $file_name1 = $_FILES['fadhar']['name'];
                        $file_size1 = $_FILES['fadhar']['size'];
                        $file_tmp1 = $_FILES['fadhar']['tmp_name'];
                        $file_type1 = $_FILES['fadhar']['type'];
                        $exp1 = explode('.', $file_name1);
                        $file_ext1 = end($exp1);
                        $extension1 = array("jpeg", "jpg", "png");

                        if (in_array($file_ext1, $extension1) === false) {
                            $error1[] = "This extension file are not allowed, Please choose a JPG or PNG file.";
                        }
                        if ($file_size > 125829120) {
                            $error1[] = "File size must be 12mb or lower.";
                        }
                        $target1 = time() . "-" . $random1 . ".jpg";

                        if (empty($error1) == true) {
                            move_uploaded_file($file_tmp1, "upload/" . $target1);
                            if (move_uploaded_file($file_tmp1, "upload/" . $target1)) {
                                $fadhar = $target1;
                                if (isset($_FILES['badhar'])) {
                                    $random2 = rand(1, 999);
                                    $error2 = array();
                                    $file_name2 = $_FILES['badhar']['name'];
                                    $file_size2 = $_FILES['badhar']['size'];
                                    $file_tmp2 = $_FILES['badhar']['tmp_name'];
                                    $file_type2 = $_FILES['badhar']['type'];
                                    $exp2 = explode('.', $file_name2);
                                    $file_ext2 = end($exp2);
                                    $extension2 = array("jpeg", "jpg", "png");

                                    if (in_array($file_ext2, $extension2) === false) {
                                        $error2[] = "This extension file are not allowed, Please choose a JPG or PNG file.";
                                    }
                                    if ($file_size2 > 125829120) {
                                        $error2[] = "File size must be 12mb or lower.";
                                    }
                                    $target2 = time() . "-" . $random2 . ".jpg";

                                    if (empty($error2) == true) {
                                        move_uploaded_file($file_tmp2, "upload/" . $target2);
                                        if (move_uploaded_file($file_tmp2, "upload/" . $target2)) {
                                            $badhar = $target2;

                                            $sql1 = "INSERT INTO players (name,address,email,phone,photo,f_adhar,b_adhar,role,style,previous_team,next_team,base_price)
                                            VALUES ('{$name}','{$address}','{$email}','{$phone}','{$photo}','{$fadhar}','{$badhar}','{$role}','{$style}','{$pre_team}','{$next_team}','{$basePrice}')";
                                            if (mysqli_query($conn, $sql1)) {
                                                $sql2 = "SELECT p_id,email,status FROM players WHERE email = '{$email}'";
                                                $result1 = mysqli_query($conn, $sql2) or die("Query failed.");
                                                if (mysqli_num_rows($result1) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result1)) {
                                                        $_SESSION["email"] = $row['email'];
                                                        $_SESSION["user_id"] = $row['p_id'];
                                                        $_SESSION["name"] = $row['name'];
                                                        $_SESSION["phone"] = $row['phone'];
                                                    }
                                                    // sendmail($email, $name);
                                                    // sendadmin($phone, $name, $email);
                                                    echo "<script>alert('Regitration successful.');</script>";
                                                    header("Location:{$hostname}/index.php");
                                                }
                                            } else {
                                                echo "query failed";
                                            }
                                        } else {
                                            echo "not upload.";

                                        }

                                    } else {
                                        print_r($error);
                                        die();
                                    }
                                } else {
                                    echo "<script>alert('Error:Adhar not Upload.')</script>";
                                }

                            } else {
                                print_r($error1);
                                die();
                            }
                        } else {
                            echo "<script>alert('Error:Adhar not Upload.')</script>";
                        }
                    } else {
                        echo "not upload.";
                    }
                } else {
                    print_r($error);
                    die();
                }
            } else {
                echo "<script>alert('Error:Profile not Upload.')</script>";
            }




        }

    }
}
?>