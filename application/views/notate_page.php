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
<div id="results">
</div>
<div id="board"></div>
<script>
    $(document).ready(function() {
        var pgn = '[Date "<?= date('m/d/Y') ?>"]\
                    [Result "1/2-1/2"]\
                    [White "White"]\
                    [Black "Black"]\
                    [WhiteElo ""]\
                    [BlackElo ""]\
                    [Event "Chess Tournament"]\
                    [Round "1"]\
                    [Site "Als Chess Notations"]\
        ';
        var cfg = { position: '2n1r3/p1k2pp1/B1p3b1/P7/5bP1/2N1B3/1P2KP2/2R5 b - - 4 25',
            pgn: pgn, locale: 'en', pieceStyle: 'merida' };
        var board = pgnEdit('board', cfg);
        
        $('#board').attr('style', "width: 80%");

        // automatically adds all comments "after" the selected move
        $('.afterComment').attr('checked', "checked");
        $('.commentRadio').hide();

        $('#boardButtonreset').on('click', function() {
            window.location.reload(true);
        });

        // Hide the save button if user is not logged in
        var session_logged_in = "<?php echo $this->session->userdata('logged_in') ?>";
        if(session_logged_in == "") { 
            $('#headerButton').hide();
        }

        // Save the game (header + pgn) to the database
        $(document).on('click','#boardButtonsave', function() {
            $.post('main/update_game', { "header": pgnData[0], "pgn": pgnData[1] }, function(event) {
                    $('#results').html(event);
                });
        });

    });
</script>
</body>
</html>