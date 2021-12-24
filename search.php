<?php
require './Admin/helpers/dbConnection.php';
require './Admin/helpers/functions.php';



# DB OP
$search=$_GET['s'];
	$query="select *from article where name like '%$search%'";
	
	$res=mysqli_query($con,$query) ;



require './Admin/layouts/header.php';
require './Admin/layouts/nav.php';
require './Admin/layouts/sidNav.php';
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Admin</h1>
            <ol class="breadcrumb mb-4">
                <?php   
                
                          ?>
                <li class="breadcrumb-item active">Dashboard/Edit Articles</li>
                <?php ?>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    DataTable Example
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table border="3" width="100%" >
											<?php
												$count=0;
												while($row=mysqli_fetch_assoc($res))
												{
													if($count==0)
													{
														echo '<tr>';
													}
													
													echo '<td valign="top" width="20%" align="center">
														<a href="detail.php?id='.$row['id'].'">
														<img src="'.$row['img'].'" width="80" height="100">
														<br>'.$row['name'].'</a>
													</td>';
													$count++;							
													
													if($count==4)
													{
														echo '</tr>';
														$count=0;
													}
												}
											?>
											
										</table>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <?php
    
    require './Admin/layouts/footer.php';
    ?>
