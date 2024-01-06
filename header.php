<?php
session_start();
$page = basename($_SERVER['PHP_SELF']);
switch ($page) {
    case 'index.php':
        $page_title = "SPL-Home";
        break;

    case 'player-form.php':
        $page_title = "SPL-Form";
        break;

    case 'profile.php':
        $page_title = "SPL-Profile";
        break;

    case 'admin-login.php':
        $page_title = "SPL-Login";
        break;

    case 'contact.php':
        $page_title = "SPL-Contact";
        break;
    case 'players.php':
        $page_title = "SPL-Players List";
        break;
    default:
        $page_title = "SPL-2024";
        break;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="icon" type="image/png" href="./image/logo.png">

    <link rel="stylesheet" href="./css/output.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Genos&display=swap" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css2?family=Genos:wght@400;500&display=swap" rel="stylesheet">
</head>

<body>
    <div>
        <!-- <div class="bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% h-20">
            <img class="" src="./spl-bg-1.png" alt="">
        </div> -->

        <nav class="bg-gray-50 dark:bg-gray-700">
            <div class="max-w-screen-xl px-4 py-3 mx-auto">
                <div class="flex items-center">
                    <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                        <li>
                            <a href="index.php"
                                class="<?= $page == 'index.php' ? 'text-[#2567ad]' : 'text-gray-900' ?> dark:text-white hover:underline hover:text-gray-600 hover:delay-200">Home</a>
                        </li>
                        <?php

                        if (isset($_SESSION["admin"])) {

                            ?>
                            <li>
                                <a href="players.php"
                                    class="<?= $page == 'player.php' ? 'text-[#2567ad]' : 'text-gray-900' ?> dark:text-white hover:underline hover:text-gray-600 hover:delay-200">Players</a>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li>
                                <a href="profile.php"
                                    class="<?= $page == 'profile.php' ? 'text-[#2567ad]' : 'text-gray-900' ?> dark:text-white hover:underline hover:text-gray-600 hover:delay-200">Profile</a>
                            </li>
                            <?php
                        }
                        ?>
                        <li>
                            <a href="contact.php"
                                class="<?= $page == 'contact.php' ? 'text-[#2567ad]' : 'text-gray-900' ?> dark:text-white hover:underline hover:text-gray-600 hover:delay-200">Contact</a>
                        </li>
                        <?php
                        if (isset($_SESSION["admin"])) {

                            ?>
                            <li>
                                <a href="logout.php"
                                    class="text-gray-900 dark:text-white hover:underline hover:text-gray-600 hover:delay-200">Logout</a>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li>
                                <a href="admin-login.php"
                                    class="<?= $page == 'admin-login.php' ? 'text-[#2567ad]' : 'text-gray-900' ?> dark:text-white hover:underline hover:text-gray-600 hover:delay-200">Admin</a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <div
            class=" flex items-center h-28 bg-gradient-to-r from-[#2f4686] from-10% via-[#ccc] via-50% to-[#2f4686] to-90% hover:from-[#2f4686] hover:via-[#458dda] hover:to-[#2f4686] text-[#183686] hover:text-[#eee] hover:delay-10">
            <div class="flex items-center mx-auto">
                <img type="image" src="./image/spl-logo.png" class="h-20 w-auto mr-1" style="hover:{color:white;}"
                    alt="">
                <div>

                    <div style="font-family: 'Genos', sans-serif;" class="text-center text-7xl pt-1">SPL-2024

                    </div>
                    <div class="font-mono text-xl font-bold text-center ">Season-4</div>
                </div>
            </div>


        </div>