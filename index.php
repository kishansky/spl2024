<?php
include("header.php");
?>
<div class="text-center m-5 p-5">
    <?php
    if (isset($_SESSION['send'])) {
        ?>
    <div class="font-serif text-5xl font-bold text-[#293778]">You Registartion is completed.. </div>
    <div class="font-sans text-6xl font-semibold text-[#4583CC]"><a href="./player-form.php">Go to your Profile..</a></div>
    <?php
    } else {
        ?>
    <div class="font-serif text-5xl font-bold text-[#293778]">Player's Registartion</div>
    <div class="font-sans text-6xl font-semibold text-[#4583CC] mb-5"><a href="./player-form.php">Comming Soon..</a></div>
    <div class="font-serif text-5xl font-bold text-[#293778]">Already registred.</div>
    <div class="font-sans text-6xl font-semibold text-[#4583CC] mb-5"><a href="./player-form.php">Comming Soon..</a></div>
    <?php
    }
    ?>
<div>
<?php
include("footer.php");
?>