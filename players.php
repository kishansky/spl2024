<?php
include("header.php");
include("config.php");
if (!isset($_SESSION['admin'])) {
    header("Location:{$hostname}/index.php");
}
?>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-4">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Address
                </th>
                <th scope="col" class="px-6 py-3">
                    Mob. no.
                </th>
                <th scope="col" class="px-6 py-3">
                    Payment
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT p_id,address,email,phone,status,name FROM players";
            $result1 = mysqli_query($conn, $sql2) or die("Query failed.");
            if (mysqli_num_rows($result1) > 0) {
                while ($row = mysqli_fetch_assoc($result1)) {


                    ?>
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <?php echo ucwords($row['name']); ?>
                        </th>
                        <td class="px-6 py-4">
                            <?php echo $row['email']; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php echo ucwords($row['address']); ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php echo $row['phone']; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php if ($row['status'] == 1) {

                                echo "<a href='change-status.php?id=" . $row['p_id'] . "'><p style='color:green !important;'>Paid<p></a>";
                            } else {
                                echo "
                        <a href='change-status.php?id=" . $row['p_id'] . "'>
                        <button class='hover:underline' style='color:red !important;'>Pending<button>
                        </a>
                        ";
                            }
                            ; ?>
                        </td>
                    </tr>
                    <?php
                }

            }
            ?>
        </tbody>
    </table>
</div>
<?php
include("footer.php");
?>