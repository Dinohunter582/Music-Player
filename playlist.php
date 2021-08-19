<!--header tag goes here -->
<?php include("includes/includedFiles.php"); 

//finds the specified id for the album being selected if none returns to the home page
if(isset($_GET['id'])) {
	$playlistId = $_GET['id'];
}
else {
	header("Location: index.php");
}
//gets album name and artist name
$playlist = new Playlist($con, $playlistId);
$owner = new User($con, $playlist->getOwner());
?>

<!--displays are album artwork and name and the artist name as well -->
<div class="entityInfo">

	<div class="leftSection">
        <div class="playlistImage">
            <img src="assets/images/icons/playlist.png">
        </div>
		
	</div>

	<div class="rightSection">
		<h2><?php echo $playlist->getName(); ?></h2>
		<p>By <?php echo $playlist->getOwner(); ?></p>
		<p><?php echo $playlist->getNumberOfSongs(); ?> songs</p>
        <button class="button" onclick="deletePlaylist('<?php echo $playlistId; ?>')">DELETE PLAYLIST</button>

	</div>

</div>
<!--displays a list of songs in the album -->
<div class="tracklistContainer">
	<ul class="trackList">
		
		<?php
		$songIdArray = $playlist->getSongIds();

		$i = 1;
		foreach($songIdArray as $songId) {

			// gets song information and artist
			$playlistSong = new Song($con, $songId);
			$songArtist = $playlistSong->getArtist();
			
			// display are track information
			echo "<li class='tracklistRow'>
					<div class='trackCount'>
						<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"". $playlistSong->getId() ."\", tempPlaylist, true)'>
						<span class='trackNumber'>$i</span>
					</div>


					<div class='trackInfo'>
						<span class='trackname'>" . $playlistSong->getTitle() . "</span>
						<span class='artistName'>". $songArtist->getName() ."</span>
					</div>

					<div class='trackOptions'>
					<input type='hidden' class='songId' value='" . $playlistSong->getId() . "'>
					<img class='optionsButton' src='assets/images/icons/more.png' alt='options button' onclick='showOptionsMenu(this)'>
				</div>

					<div class='trackDuration'>
						<span class='duration'>". $playlistSong->getDuration() ."</span>
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
	<div class="item" onclick="removeFromPlaylist(this, '<?php echo $playlistId; ?>')">Remove from Playlist</div>
</nav>