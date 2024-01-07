<?php
include("header.php");
include("config.php");
ob_start();
$pid = $_GET['id'];
$sql = "SELECT * FROM players WHERE p_id = '{$pid}'";
$result = mysqli_query($conn, $sql) or die("Query Failed.");
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="max-w-sm mx-auto bg-white dark:bg-gray-900 rounded-lg overflow-hidden shadow-lg my-4">
            <div class="border-b px-4 pb-6">
                <div class="text-center my-4">
                    <img class="h-32 w-32 rounded-full border-4 border-white dark:border-gray-800 mx-auto my-4"
                        src="./profile/<?php echo $row['photo']; ?>" alt="">
                    <div class="py-2 ">

                        <h3 class="font-bold text-xl text-gray-800 dark:text-white mb-1">Name:-
                            <?php echo ucwords($row['name']); ?>
                        </h3>
                        <h3 class="font-bold text-base text-gray-800 dark:text-white mb-1">Email:- <?php echo $row['email']; ?>
                        </h3>
                        <h3 class="font-bold text-base text-gray-800 dark:text-white mb-1">Address:-
                            <?php echo ucwords($row['address']); ?></h3>
                        <h3 class="font-bold text-base text-gray-800 dark:text-white mb-1">Mob:- <?php echo $row['phone']; ?>
                        </h3>
                        <h3 class="font-bold text-base text-gray-800 dark:text-white mb-1">Base Price:-
                            <?php echo $row['base_price'] . " Cr"; ?></h3>

                        <hr class="my-4" />

                        <?php
                        if ($row['status'] == 0) {
                            ?>
                             <div class="inline-flex text-gray-700 dark:text-gray-300 items-center">
                                    <h3 style="color:red !important;" class="font-bold text-base text-gray-800 dark:text-white mb-1">Payment is not complete.</h3>
                                </div>
                                <hr class="my-4" />
                                <?php
                        }
                        ?>
                        <div class="inline-flex text-gray-700 dark:text-gray-300 items-center">
                            <form class="max-w-md mx-auto" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST"
                                enctype="multipart/form-data" autocomplete="off">
                                <div class="relative z-0 w-full mb-5 group">
                                    <label for="formFile"
                                        class="font-bold mb-2 inline-block text-neutral-700 dark:text-neutral-200">Change
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
                        <div class="inline-flex text-gray-700 dark:text-gray-300 items-center">
                            <form class="max-w-md mx-auto" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST"
                                enctype="multipart/form-data" autocomplete="off">
                                <div class="relative z-0 w-full mb-5 group">
                                    <div class="flex items-center mb-3">
                                        <label class="font-semibold" for="style">Choose Locality:-</label>
                                    </div>
                                    <div class="flex items-center mb-3">
                                        <input id="style" type="radio" name="local" value="0"
                                            class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600"
                                            <?php if ($row['islocal'] == 0) {
                                                echo "checked";
                                            } ?> required>
                                        <label for="style"
                                            class="block ms-2 text-sm font-medium text-[#2f4686] dark:text-gray-300">
                                            Local
                                        </label>
                                    </div>
                                    <div class="flex items-center mb-3">
                                        <input id="style" type="radio" name="local" value="1"
                                            class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600"
                                            <?php if ($row['islocal'] == 1) {
                                                echo "checked";
                                            } ?>>
                                        <label for="style"
                                            class="block ms-2 text-sm font-medium text-[#2f4686] dark:text-gray-300">
                                            Overseas
                                        </label>
                                    </div>
                                </div>
                                <div class="relative z-0 w-full mb-5">
                                    <label for="bprice"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Choose your base
                                        price???</label>
                                    <select name="basePrice" id="bprice"
                                        class="bg-gray-50 border border-gray-300 text-[#2f4686] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required>
                                        <option value="0.2" <?php if ($row['base_price'] == 0.2) {
                                            echo "selected";
                                        } ?>>20 Lakhs
                                        </option>
                                        <option value="0.5" <?php if ($row['base_price'] == 0.5) {
                                            echo "selected";
                                        } ?>>50 Lakhs
                                        </option>
                                        <option value="1" <?php if ($row['base_price'] == 1) {
                                            echo "selected";
                                        } ?>>1 Crore
                                        </option>
                                        <option value="1.5" <?php if ($row['base_price'] == 1.5) {
                                            echo "selected";
                                        } ?>>1.5 Crores
                                        </option>
                                        <option value="2" <?php if ($row['base_price'] == 2) {
                                            echo "selected";
                                        } ?>>2 Crores
                                        </option>
                                    </select>
                                </div>
                                <div class="relative z-0 w-full mb-5">
                                    <button type="submit" name="update"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
}
if (isset($_POST['submit'])) {
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
                $sql = "UPDATE players SET photo='{$photo}' WHERE p_id = '{$pid}'";
                if (mysqli_query($conn, $sql)) {
                    header("Location:{$hostname}/player-details.php?id={$pid}");
                } else {
                    echo "<div class='alert alert danger'>Photo not Change.</div>";
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
if (isset($_POST['update'])) {
    $local = strip_tags($_POST['local']);
    $basePrice = strip_tags($_POST['basePrice']);

    $sql1 = "UPDATE players SET islocal='{$local}',base_price='{$basePrice}' WHERE p_id = '{$pid}'";
    if (mysqli_query($conn, $sql1)) {
        header("Location:{$hostname}/player-details.php?id={$pid}");
    } else {
        echo "<div class='alert alert danger'>Details not Change.</div>";
    }

}

?>


<?php
include("footer.php");
?>