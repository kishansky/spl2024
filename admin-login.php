<?php
include("header.php");
include("config.php");

if (isset($_POST['login'])) {

    $username = strip_tags($_POST['username']);
    $password = strip_tags(md5($_POST['password']));

    $sql = "SELECT a_id,username,password FROM admin WHERE username = '{$username}' AND password ='{$password}'";
    $result = mysqli_query($conn, $sql) or die("Query Failed");
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // session_start();
            $_SESSION["admin"] = $row['username'];
            header("Location:{$hostname}/index.php");
        }
    } else {
        echo '<div class="alert alert-danger">Username and Password are not match.</div>';
    }
}


?>

<div class="m-5 max-w-md mx-auto">

    <form class="max-w-sm mx-2" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data"
        autocomplete="off">
        <div class="relative z-0 w-full mb-5 group">
            <input type="text" name="username" id="floating_name"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" " required />
            <label for="floating_name"
                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Username</label>
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <input type="password" name="password" id="floating_email"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" " required />
            <label for="floating_email"
                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                Password</label>
        </div>
        <button name="login" type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">login</button>
    </form>
</div>


<?php
include("footer.php");
?>