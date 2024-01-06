<?php
include("header.php");
include("config.php");
ob_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';


  if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
    $name;
    $phone;
    $sql = "SELECT * FROM players WHERE email = '{$email}'";
    $result = mysqli_query($conn, $sql) or die("Query Failed.");
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $phone = $row['phone'];
        ?>
      <div class="max-w-sm mx-auto bg-white dark:bg-gray-900 rounded-lg overflow-hidden shadow-lg my-4">
        <div class="border-b px-4 pb-6">
          <div class="text-center my-4">
            <img class="h-32 w-32 rounded-full border-4 border-white dark:border-gray-800 mx-auto my-4"
              src="./profile/<?php echo $row['photo']; ?>" alt="">
            <div class="py-2 ">

              <h3 class="font-bold text-xl text-gray-800 dark:text-white mb-1">Name:- <?php echo ucwords($row['name']); ?>
              </h3>
              <h3 class="font-bold text-base text-gray-800 dark:text-white mb-1">Email:- <?php echo $row['email']; ?></h3>
              <h3 class="font-bold text-base text-gray-800 dark:text-white mb-1">Address:-
                <?php echo ucwords($row['address']); ?></h3>
              <h3 class="font-bold text-base text-gray-800 dark:text-white mb-1">Mob:- <?php echo $row['phone']; ?></h3>
              <h3 class="font-bold text-base text-gray-800 dark:text-white mb-1">Base Price:-
                <?php echo $row['base_price'] . " Cr"; ?></h3>
              <hr class="my-4" />
              <?php
              if ($row['status'] != 0) {
                ?>
                <div class="inline-flex text-gray-700 dark:text-gray-300 items-center">
                  <form class="max-w-md mx-auto" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST"
                    enctype="multipart/form-data" autocomplete="off">
                    <div class="relative z-0 w-full mb-5 group">
                      <label for="formFile" class="font-bold mb-2 inline-block text-neutral-700 dark:text-neutral-200">Change
                        Profile
                        Photo</label>
                      <input name="profile"
                        class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                        type="file" id="formFile" required />
                      <button type="submit" name="submit"
                        class="mt-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Change</button>
                    </div>
                  </form>
                </div>
                <?php
              } else {
                ?>
                <div class="inline-flex text-gray-700 dark:text-gray-300 items-center">
                  <h3 class="font-bold text-base text-gray-800 dark:text-white mb-1">Your payment is not complete.</h3>
                </div>
                <?php
              }
              ?>
            </div>
          </div>
        </div>

      </div>

      <?php
      }
    }
    if (isset($_POST['submit'])) {
      $photo = null;
      if (isset($_FILES['profile'])) {
        $random = rand(1, 999);
        $file_name = $_FILES['profile']['name'];
        $file_size = $_FILES['profile']['size'];
        $file_tmp = $_FILES['profile']['tmp_name'];
        $file_type = $_FILES['profile']['type'];
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
          if (move_uploaded_file($file_tmp, "profile/" . $target)) {
            $photo = $target;
            $sql = "UPDATE players SET photo='{$photo}' WHERE email = '{$email}'";
            if (mysqli_query($conn, $sql)) {
              header("Location:{$hostname}/profile.php");
            } else {
              echo "<div class='alert alert danger'>Profile not Change.</div>";
            }
          } else {
            echo "profile picture not upload";
          }
        } else {
          print_r($error);
          die();
        }
      }
    }
  } else {

    ?>
  <div class="m-5">
    <div class="font-serif text-5xl font-bold text-[#293778]">Please Fill registration form.</div>
    <a href="./player-form.php" class="font-sans text-5xl font-semibold text-[#4583CC]">Click Here</a>

  </div>

  <?php
  }
  if (!isset($_SESSION['send'])) {
    function sendmail($email, $name)
    {
      $mail = new PHPMailer(true);

      try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com;';
        $mail->SMTPAuth = true;
        $mail->Username = '<email>';
        $mail->Password = '<password>';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('<email>', 'SPL-2024');
        $mail->addAddress($email, $name);
        // $mail->addAddress('receiver2@gfg.com', 'Name');

        $mail->isHTML(true);
        $mail->Subject = 'SPL-2024 Registration';
        $mail->Body = "<b style='color:black;font-size: 15px;'>Hi, " . ucwords($name) . "</b><b style='color:blue;font-size: 15px;'><br />Your Registration form is summited successfully. Kindly pay your registration fee. Ignore if pay already.</b>";
        $mail->AltBody = 'Body in plain text for non-HTML mail clients';
        $mail->send();
      } catch (Exception $e) {
        echo '<div>Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
      }
    }
    function sendadmin($phone, $name, $email)
    {
      $mail = new PHPMailer(true);

      try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com;';
        $mail->SMTPAuth = true;
        $mail->Username = '<email>';
        $mail->Password = '<password>';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('<email>', 'SPL-2024');
        $mail->addAddress("<email>");
        // $mail->addAddress('receiver2@gfg.com', 'Name');

        $mail->isHTML(true);
        $mail->Subject = 'SPL-2024 Registration';
        $mail->Body = "<b style='color:black;font-size: 15px;'>A player , " . ucwords($name) . ", just Register.</b><b style='color:blue;font-size: 15px;'><br />Mobile no:- " . $phone . "<br/>Email:-" . $email . "</b>";
        $mail->AltBody = 'Body in plain text for non-HTML mail clients';
        $mail->send();
      } catch (Exception $e) {
        echo '<div>Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
      }

    }
    sendmail($email, $name);
    sendadmin($phone, $name, $email);
    $_SESSION['send'] = "ho gaya";
  }


include("footer.php");

?>
