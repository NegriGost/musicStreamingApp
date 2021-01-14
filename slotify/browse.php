<?php include("includes/forAjaxRouting/includedFiles.php"); ?>
<!-- dinamic content -->
 	<h1 class="pageHeadingBig">You Might Also Like</h1>

 	<div class="gridViewContainer">
 		<?php 
 		
 			$albumQuery=mysqli_query($con,"SELECT * FROM albums ORDER BY RAND() LIMIT 10"); 

 			while ($row=mysqli_fetch_array($albumQuery)) {
 				// echo $row['title'] ."<br/>";

 				echo "

		 					<div class='gridViewItem'>

		 						<a role='link' tabindex='0' href='javascript:void(0)' onclick='openPage(\"album.php?id=".$row['id']." \")'>
			 						<img src='".$row['artworkPath']."' alt='artworkPath'/>

			 						<div class='gridViewInfo'>
			 
			 							".$row['title']."

			 						</div>
								</a>
		 					</div>

 				";
 			}
 		?>
 	</div>