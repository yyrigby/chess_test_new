<!DOCTYPE html>
<html>
<head lang="en">
    <title>Game Notation</title>

    <!-- Libraries Js from PgnViewerJS -->
    <script src="../assets/js/pgnvjs.js" type="text/javascript"></script>

    <!-- CSS used -->
    <link rel="stylesheet" href="../assets/css/pgnvjs.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">

</head>
<body>
<div id="my_buttons">
    <button id="my_save_button">Save</button>
</div>

<div id="board"></div>
<script>
    $(document).ready(function() {

        var pgn = <?= "'" . $pgn . "'" ?>;
        pgn = pgn + "\ ";
        var fen = <?= "'" . $fen . "'" ?>;
        var game_id = <?= $game_id ?>;
        console.log(game_id);
        // console.log("pgn is " + pgn);
        // console.log("fen is " + fen);
        var cfg = { position: fen,
            pgn: pgn, locale: 'en', pieceStyle: 'merida' };
        var board = pgnEdit('board', cfg);
        // console.log(pgnData);

        // generate chessboard
        $('#board').attr('style', "width: 80%");

        // automatically adds all comments after the selected move
        $('.afterComment').attr('checked', "checked");
        $('.commentRadio').hide();

        $('#boardButtonreset').on('click', function() {
            window.location.reload(true);
        });

        $("#my_save_button").click(function() {
            $.post("/games/update_game", { pgn: pgnData[1], game_id: game_id }, function(event) {
                console.log(event);
            });
        });

    });
</script>
</body>
</html>