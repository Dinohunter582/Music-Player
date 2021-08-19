<?php 
include("includes/includedFiles.php")?>
<!-- shows albums -->
<h1 class="pageHeadingBig">Song Suggestions</h1>

<div class="gridViewContainer">

	<?php
	//places the first 10 albums on the page
		$albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND() LIMIT 10");

		while($row = mysqli_fetch_array($albumQuery)) {
			
			
		echo "	<div class='gridViewItem'>
		<span role='link' tabindex='0' onclick='openPage(\"album.php?id=". $row['id'] ."\")'>
					<img src='". $row['artworkPath'] . "'>

					<div class='gridViewInfo'>" 
						. $row['title'] . 
					"</div>
					</span>
				</div>";

		}
	?>

</div>