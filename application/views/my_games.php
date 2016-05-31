<!DOCTYPE html>
<head>
	<title>My Games</title>
</head>
<body>
	<div class="wrapper">
		<h3 class="inline-block"><?=$this->session->userdata('first_name') ?>'s Games</h3>
		<table class="table talbe-striped table-hover table-condensed">
			<thead>
				<th>#</th>
				<th>White</th>
				<th>Black</th>
				<th>Date</th>
				<th>Event</th>
				<th>Analyze</th>
			</thead>
			<tbody>
				<?= $table ?>
			</tbody>
		</table>
		<div id="my_games_buttons">
			<a class="btn btn-primary btn-md" href="paste_pgn" role="button">Start a New Game</a>
		</div>
	</div>
</body>
</html>