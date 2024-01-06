<?php
include("header.php");
include("config.php");
ob_start();
if (isset($_POST['search'])) {
   $email= strip_tags($_POST['email']);
   $phone= strip_tags($_POST['phone']);
   $sql ="SELECT p_id,email,name,phone FROM players WHERE email = '{$email}' AND phone ='{$phone}'";
   $result = mysqli_query($conn, $sql) or die("Query Failed.");
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $_SESSION["email"] = $row['email'];
            $_SESSION["user_id"] = $row['p_id'];
            $_SESSION["name"] = $row['name'];
            $_SESSION["phone"] = $row['phone'];
            $_SESSION['send'] = "ho gaya";
            header("Location:{$hostname}/profile.php");
        }
    } else {
        echo '<div class="alert alert-danger">Username and Password are not match.</div>';
    }

}
?>
<form class="max-w-sm mx-2" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data"
    autocomplete="off">
    <div class="relative z-0 w-full mb-5 group">
        <input type="email" name="email" id="email"
            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            placeholder=" " required />
        <label for="email"
            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
            Enter you email</label>
    </div>
    <div class="relative z-0 w-full mb-5 group">
        <input type="text" name="phone" id="phone"
            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            placeholder=" " required />
        <label for="phone"
            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
            Enter your number</label>
    </div>
    <button name="search" type="submit"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">login</button>
</form>
<?php
include("footer.php");
?>