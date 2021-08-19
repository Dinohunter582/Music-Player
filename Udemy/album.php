<!--header tag goes here -->
<?php include("includes/includedFiles.php"); 

//finds the specified id for the album being selected if none returns to the home page
if(isset($_GET['id'])) {
	$albumId = $_GET['id'];
}
else {
	header("Location: index.php");
}
//gets album name and artist name
$album = new Album($con, $albumId);
$artist = $album->getArtist();
?>

<!--displays are album artwork and name and the artist name as well -->
<div class="entityInfo">

	<div class="leftSection">
		<img src="<?php echo $album->getArtworkPath(); ?>">
	</div>

	<div class="rightSection">
		<h2><?php echo $album->getTitle(); ?></h2>
		<p>By <?php echo $artist->getName(); ?></p>
		<p><?php echo $album->getNumberOfSongs(); ?> songs</p>

	</div>

</div>
<!--displays a list of songs in the album -->
<div class="tracklistContainer">
	<ul class="trackList">
		
		<?php
		$songIdArray = $album->getSongIds();

		$i = 1;
		foreach($songIdArray as $songId) {

			// gets song information and artist
			$albumSong = new Song($con, $songId);
			$albumArtist = $albumSong->getArtist();
			
			// display are track information
			echo "<li class='tracklistRow'>
					<div class='trackCount'>
						<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"". $albumSong->getId() ."\", tempPlaylist, true)'>
						<span class='trackNumber'>$i</span>
					</div>


					<div class='trackInfo'>
						<span class='trackname'>" . $albumSong->getTitle() . "</span>
						<span class='artistName'>". $albumArtist->getName() ."</span>
					</div>

					<div class='trackOptions'>
						<input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
						<img class='optionsButton' src='assets/images/icons/more.png' alt='options button' onclick='showOptionsMenu(this)'>
					</div>

					<div class='trackDuration'>
						<span class='duration'>". $albumSong->getDuration() ."</span>
					</div>
				</li>";
				//increases number by 1 for each song in album
			$i = $i + 1;



		}

		?>

		<script>
			var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
			tempPlaylist = JSON.parse(tempSongIds);
			console.log(tempPlaylist);
		</script>

	</ul>
</div>

<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn-> getUsername()); ?>

</nav>





