<?php session_start();
$link = mysqli_connect("localhost", "root", "bookstore") or die("Can't Connect...");


$id = $_GET['id'];

$q = "select * from book where b_id=$id";

$res = mysqli_query($link, $q,) or die("Can't Execute Query..");
$row = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <link rel="stylesheet" href="lightbox.css" type="text/css" media="screen" />
    <script src="js/prototype.js" type="text/javascript"></script>
    <script src="js/scriptaculous.js?load=effects" type="text/javascript"></script>
    <script src="js/lightbox.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/java.js"></script>
    <?php
    include("../includes/head.inc.php");
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
                <h1 class="title"><?php echo $row['bookname']; ?></h1>
                <div class="entry">
                    <?php

                    echo '	<table border="0" width="100%">
												 <tr>
													<td><hr color="purple"></td>
												</tr>
												 <tr align="center" bgcolor="#EEE9F3">
													 <td>Item Details</td>
												</tr>
												<tr>
													<td><hr color="purple"></td>
												</tr>
											 </table>
											
											<table border="0"  width="100%" bgcolor="#ffffff">
												<tr> 
													
													<td width="15%" rowspan="3">
														<img src="' . $row['coverimage'] . '" width="100">
													
													</td>
												</tr>
											
												<tr> 
													<td width="50%" height="100%">
														<table border="0"  width="100%" height="100%">
															<tr valign="top">
																<td align="right" width="10%">NAME</td>
																<td width="6%">: </td>
																<td align="left">' . $row['bookname'] . '</td>
															</tr>
																					
															<tr>
																<td align="right">Publisher </td>
																<td>: </td>
																<td align="left">' . $row['author'] . '</td>
																
															</tr>											
															
															<tr>
																<td align="right"> PRICE</td>
																<td>: </td>
																<td align="left">' . $row['price'] . '</td>
															</tr>
														</table>
										
													</td>
												</tr>
											</table>
										
												<tr valign="bottom" >
												
														<a href="' . $row['b_img'] . '" rel="lightbox"><img src="images/zoom.gif" ></a>
													
												</tr>
											
											<table border="0" width="100%">
												 <tr>
													<td><hr color="purple"></td>
												</tr>
												 <tr align="center" bgcolor="#EEE9F3">
													 <td>DESCRIPTION</td>
												</tr>
												<tr>
													<td><hr color="purple"></td>
												</tr>
																		
											 </table>
											 
											 ' . $row['blog'] . '
																				

											 
											 <tr><td colspan=2><hr color="purple"></td></tr>
											
											<table border="0" width="100%">
												
												 <tr align="center" bgcolor="#EEE9F3">';

                  
                    echo '</tr>
											</table>';
                    ?>
                </div>

            </div>

        </div>
        

    </div>
    <!-- end page -->
    <!-- start footer -->
    <div id="footer">
        <?php
        include("../includes/footer.inc.php");
        ?>
    </div>
    <!-- end footer -->
</body>

</html>