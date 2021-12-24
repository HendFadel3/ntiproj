<?php
require './Admin/helpers/dbConnection.php';
require './Admin/helpers/functions.php';
//session_start();

//require './Admin/checkLogin.php';



$id = $_GET['id'];

# DB OP
$sql = "select article.* , category.cat_nm as CatTitle  from article inner join category  on article.catt_id = category.id where article.id=$id ";
$op = mysqli_query($con, $sql);
$data=mysqli_fetch_assoc($op);



?>
<table class="table table-bordered" alig="center" id="dataTable" width="100%" cellspacing="35">
                            <thead>
                                <tr>
                                <th>Id</th>
                                    <th>Art Name</th>
                                    <th>Art Publisher</th>
                                    <th>Art Description</th>
                                    <th>Edition Year</th>
                                    <th>No.Pages</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Image</th>
                                    <th>PDF</th>

                                    <!-- <th>Control</th> -->

                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <!-- <th>Id</th>
                                    <th>Art Name</th>
                                    <th>Art Publisher</th>
                                    <th>Art Description</th>
                                    <th>Edition Year</th>
                                    <th>No.Pages</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Image</th>
                                    <th>Control</th> -->

                                </tr>
                            </tfoot>
                            <tbody>
                                <?php 
                                            
                                            ?><tr>
                                <td><?php echo $data['id']; ?></td>
                                    <td><?php echo $data['name']; ?></td>
                                    <td><?php echo $data['publisher']; ?></td>
                                    <td><?php echo $data['description']; ?></td>
                                    <td><?php echo $data['edition']; ?></td>
                                    <td><?php echo $data['page']; ?></td>
                                    <td><?php echo $data['price']; ?></td>
                                    <td><?php echo $data['CatTitle']; ?></td>
                                    <td><img src="./Admin/Articles/uploads/<?php echo $data['img']; ?>" width="120" height="120"> </td>
                                      <!-- <td> <a href='download.php?id=<?php //print $data['pdf']; ?>'
                                            class='btn btn-danger m-r-1em'>Download</a></td> </a></td>   -->
                                            
                                            <td><a href="uploads/<?php echo $data['pdf'] ?>" target="_blank">Download</a></td>       

                                            
                                            <?php
										

                                        // if(isset($_SESSION['status']))
										// 		 {
										// 			echo ' <td><a href="download.php?nm='.$data['name'].'">
										// 				<img src="images/download.png" width="60" height="60">
										// 			</a></td>';
										// 		}
										// 		else
										// 		{
										// 			echo '<td><img src="images/download.png" width="60" height="60"><br><a href="register.php"> <h4>Please Login..</h4></a></td>';
										// 		}
										// 		echo '</tr>'
                                                ?> 
                                
                                                     
                                
</tr>
                            </tbody>
                            </table>
