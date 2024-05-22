<?php session_start();

$link = mysqli_connect("localhost", "root", "bookstore") or die("Can't Connect...");

// mysqli_select_db($link,"shop") or die("Can't Connect to Database...");

$search = $_GET['s'];
$query = "select *from book where name like '%$search%'";

$res = mysqli_query($link, $query) or die("Can't Execute Query...");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php
    include("includes/head.inc.php");
    ?>
</head>

<body>
   
    <div id="header">
        <div id="menu">
            <?php
            include("../includes/menu.inc.php");
            ?>
        </div>
    </div>

    <div id="page">
        <div id="content">
            <div class="post">
                <h1 class="title">Search Result</h1>
                <div class="entry">

                    <table border="3" width="100%">
                        <?php
                        $count = 0;
                        while ($row = mysqli_fetch_assoc($res)) {
                            if ($count == 0) {
                                echo '<tr>';
                            }

                            echo '<td valign="top" width="20%" align="center">
														<a href="detail.php?id=' . $row['id'] . '">
														<img src="' . $row['coverimg'] . '" width="80" height="100">
														<br>' . $row['bookname'] . '</a>
													</td>';
                            $count++;

                            if ($count == 4) {
                                echo '</tr>';
                                $count = 0;
                            }
                        }
                        ?>

                    </table>
                </div>

            </div>

        </div>
       
    </div>
   
    <div id="footer">
        <?php
        include("../includes/footer.inc.php");
        ?>
    </div>
    
</body>

</html>