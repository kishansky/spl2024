<?php
include("header.php");
include("config.php");

if (isset($_SESSION['email'])) {
    header("Location:{$hostname}/index.php");
}
?>
<div class="m-5">
    <?php
    if (isset($_POST['submit'])) {
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
                                if (move_uploaded_file($file_tmp1, "adhar/" . $target1)) {
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
                                            if (move_uploaded_file($file_tmp2, "adhar/" . $target2)) {
                                                $badhar = $target2;
                                                $sql1 = "INSERT INTO players (name,address,email,phone,photo,f_adhar,b_adhar,role,style,previous_team,next_team,base_price)
                                                        VALUES ('{$name}','{$address}','{$email}','{$phone}','{$photo}','{$fadhar}','{$badhar}','{$role}','{$style}','{$pre_team}','{$next_team}','{$basePrice}')";
                                                if (mysqli_query($conn, $sql1)) {
                                                    $sql2 = "SELECT p_id,email,name,phone FROM players WHERE email = '{$email}'";
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
                                                        //    echo "<script>alert('Regitration successful.');</script>";
                                                        header("Location:{$hostname}/profile.php");
                                                    }
                                                } else {
                                                    echo "query failed";
                                                }
                                            } else {
                                                echo "Back Aadhar not upload";
                                                die();
                                            }
                                        } else {
                                            print_r($error2);
                                            die();
                                        }

                                    } else {
                                        echo "Aadhar not selected";
                                        die();
                                    }
                                } else {
                                    echo "Aadhar not upload";
                                    die();
                                }
                            } else {
                                print_r($error1);
                                die();
                            }
                        } else {
                            echo "Aadhar not selected";
                            die();
                        }
                    } else {
                        echo "Profile image not upload";
                        die();
                    }
                } else {
                    print_r($error);
                    die();
                }
            } else {
                echo "Profile image not selected";
            }
        }
    }

    ?>
    <form class="max-w-md mx-auto" action="<?php 
    $_SERVER['PHP_SELF']; 
    ?>" method="POST" enctype="multipart/form-data"
        autocomplete="off">
        <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="name" id="floating_name"
                class="block py-2.5 px-0 w-full text-sm text-[#2f4686] bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" " required />
            <label for="floating_name"
                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Player's
                name</label>
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <input type="email" name="email" id="floating_email"
                class="block py-2.5 px-0 w-full text-sm text-[#2f4686] bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" " required />
            <label for="floating_email"
                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                address</label>
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="number" maxlength="10" id="floating_number"
                class="block py-2.5 px-0 w-full text-sm text-[#2f4686] bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" " required />
            <label for="floating_number"
                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Mob.
                Number
            </label>
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="address" id="floating_address"
                class="block py-2.5 px-0 w-full text-sm text-[#2f4686] bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" " required />
            <label for="floating_address"
                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Address
            </label>
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <label for="formFile" class="mb-2 inline-block text-neutral-700 dark:text-neutral-200">Choose a Profile
                Photo</label>
            <input name="profile"
                class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                type="file" id="formFile" required />
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <label for="formFile" class="mb-2 inline-block text-neutral-700 dark:text-neutral-200">Choose Adhar-card's
                front Photo</label>
            <input name="fadhar"
                class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                type="file" id="formFile1" required />
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <label for="formFile" class="mb-2 inline-block text-neutral-700 dark:text-neutral-200">Adhar-card's back
                Photo</label>
            <input name="badhar"
                class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                type="file" id="formFile2" required />
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <div class="flex items-center mb-3">
                <label class="font-semibold" for="role">Choose your Role:-</label>
            </div>
            <div class="flex items-center mb-3">
                <input id="role" type="radio" name="role" value="1"
                    class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600"
                    required>
                <label for="role" class="block ms-2 text-sm font-medium text-[#2f4686] dark:text-gray-300">
                    Bastman
                </label>
            </div>
            <div class="flex items-center mb-3">
                <input id="role" type="radio" name="role" value="2"
                    class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                <label for="role" class="block ms-2 text-sm font-medium text-[#2f4686] dark:text-gray-300">
                    Batting All-rounder
                </label>
            </div>
            <div class="flex items-center mb-3">
                <input id="role" type="radio" name="role" value="3"
                    class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                <label for="role" class="block ms-2 text-sm font-medium text-[#2f4686] dark:text-gray-300">
                    Bowling All-rounder
                </label>
            </div>
            <div class="flex items-center mb-3">
                <input id="role" type="radio" name="role" value="4"
                    class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                <label for="role" class="block ms-2 text-sm font-medium text-[#2f4686] dark:text-gray-300">
                    Bowler
                </label>
            </div>
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <div class="flex items-center mb-3">
                <label class="font-semibold" for="style">Choose your Style:-</label>
            </div>
            <div class="flex items-center mb-3">
                <input id="style" type="radio" name="style" value="1"
                    class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600"
                    required>
                <label for="style" class="block ms-2 text-sm font-medium text-[#2f4686] dark:text-gray-300">
                    Right-hand
                </label>
            </div>
            <div class="flex items-center mb-3">
                <input id="style" type="radio" name="style" value="2"
                    class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                <label for="style" class="block ms-2 text-sm font-medium text-[#2f4686] dark:text-gray-300">
                    Left-hand
                </label>
            </div>
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <input id="showteam" type="checkbox" name="ispre" onclick="showTeam()" value="false"
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="showteam" class="ms-2 text-sm font-medium text-[#2f4686] dark:text-gray-300">Are you play
                previous SPL??</label>
        </div>
        <div class="relative z-0 w-full mb-5">
            <label for="team" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select your Previous
                Team</label>
            <select name="preteam" id="team"
                class="bg-gray-50 border border-gray-300 text-[#2f4686] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                disabled required>
                <option value="1">(SSK)Sakra Super Kings</option>
                <option value="2">(SPP)Sakra Pink Panthers</option>
                <option value="3">(SB)Sakra Bulls</option>
                <option value="4">(SD)Sakra Dolphins</option>
                <option value="5">(SKR)Sakra Knight Riders</option>
            </select>
        </div>
        <div class="relative z-0 w-full mb-5">
            <label for="favteam" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Which team do you
                want paly this Season???</label>
            <select name="nextteam" id="favteam"
                class="bg-gray-50 border border-gray-300 text-[#2f4686] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required>
                <option value="1">(SSK)Sakra Super Kings</option>
                <option value="2">(SPP)Sakra Pink Panthers</option>
                <option value="3">(SB)Sakra Bulls</option>
                <option value="4">(SD)Sakra Dolphins</option>
                <option value="5">(SKR)Sakra Knight Riders</option>
            </select>
        </div>
        <div class="relative z-0 w-full mb-5">
            <label for="bprice" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choose your base
                price???</label>
            <select name="basePrice" id="bprice"
                class="bg-gray-50 border border-gray-300 text-[#2f4686] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required>
                <option value="0.2">20 Lakhs</option>
                <option value="0.5">50 Lakhs</option>
                <option value="1">1 Crore</option>
                <option value="1.5">1.5 Crores</option>
                <option value="2">2 Crores</option>
            </select>
        </div>
        <div class="relative z-0 w-full mb-5">
            <label for="bprice" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Make sure your given imformation are correct.
                </label>
            
        </div>
        <div class="relative z-0 w-full mb-5">
            <div id="wait">

            </div>
        </div>
        <button type="submit" name="submit" 
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    <!-- </form> -->
    <!-- <form class="max-w-md mx-auto" method="post" action="./PaytmKit/pgRedirect.php">
            <input type="hidden" id="ORDER_ID" tabindex="1" maxlength="20" size="20" name="ORDER_ID" autocomplete="off" value="
            <?php
            // echo "ORDS" . rand(10000, 99999999);
            ?>">
            <input type="hidden" id="CUST_ID" tabindex="2" maxlength="12" size="12" name="CUST_ID" autocomplete="off" value="CUST001">
            <input type="hidden" id="INDUSTRY_TYPE_ID" tabindex="4" maxlength="12" size="12" name="INDUSTRY_TYPE_ID" autocomplete="off" value="Retail">
            <input  type="hidden"id="CHANNEL_ID" tabindex="4" maxlength="12" size="12" name="CHANNEL_ID" autocomplete="off" value="WEB">
            
            <input title="TXN_AMOUNT" tabindex="10" type="hidden" name="TXN_AMOUNT" value="1">
            <br>
            <br>
            <input class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" value="CheckOut" type="submit"	onclick=""> 
        </form> -->
</div>

<script>
    let checkbox = document.getElementById('showteam');
    let text = document.getElementById("team");
    function showTeam() {
        if (checkbox.checked == true) {
            text.disabled = false;
        } else {
            text.disabled = true;
        }

    }

    // function check(){
    //     let name=document.getElementById('floating_name').value;
    //     let email=document.getElementById('floating_email').value;
    //     let number=document.getElementById('floating_number').value;
    //     let address=document.getElementById('floating_address').value;
    //     let photo=document.getElementById('formFile').value;
    //     let photo1=document.getElementById('formFile1').value;
    //     let photo2=document.getElementById('formFile2').value;
    //     if(!name ="" || !email= "" || !number= "" || !address= "" || !photo= "" || !photo1= "" || !photo2= ""){
    //         let wait = document.getElementById('wait');
    //         wait.innerHTML="please wait";
    //     }

    // }

</script>
<?php
include("footer.php");
?>