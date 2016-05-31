<!DOCTYPE html>
<html>
<head lang="en">
    <title>Paste PGN</title>

    <!-- Libraries Js from PgnViewerJS -->
    <script src="../assets/js/chessboard-0.3.0.js" type="text/javascript"></script>
    <script src="../assets/js/chess.js" type="text/javascript"></script>

    <!-- CSS used -->
    <link rel="stylesheet" href="../assets/css/pgnvjs.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
    
    <script>
        $(document).ready(function() {
            // Set the FEN position board set up
            var onDrop = function(source, target, piece, newPos, oldPos, orientation) {
              // console.log("Source: " + source);
              // console.log("Target: " + target);
              // console.log("Piece: " + piece);
              // console.log("New position: " + ChessBoard.objToFen(newPos));
              // console.log("Old position: " + ChessBoard.objToFen(oldPos));
              // console.log("Orientation: " + orientation);
              // console.log("--------------------");
            };

            var cfg = {
              draggable: true,
              dropOffBoard: 'trash',
              position: 'start',
              onDrop: onDrop,
              sparePieces: true
            };
            var board = ChessBoard('fen_board', cfg);
            $('#startPositionBtn').on('click', board.start);
            $('#clearBoardBtn').on('click', board.clear);

            // Get FEN button
            function clickGetPositionBtn() {
              var fen = board.fen();
              fen = fen + " " + document.getElementById("next_move").value;
              fen = fen + " ";
              if(document.getElementById("checkbox1").checked == true){
                fen = fen + "K"; 
              } if(document.getElementById("checkbox2").checked == true){
                fen = fen + "Q"; 
              } if(document.getElementById("checkbox3").checked == true){
                fen = fen + "k"; 
              } if(document.getElementById("checkbox4").checked == true){
                fen = fen + "q"; 
              };
              fen = fen + " - 0 1";
              $('#fen_input').val(fen);
            }

            $('#getPositionBtn').on('click', clickGetPositionBtn);

            // Reset Form Button
            $('#boardButtonreset').on('click', function() {
                document.getElementById("paste_pgn_form").reset();
            });

            // Save Form Button
            $('#boardButtonsave').on('click', function() {
                var chess = new Chess();
                var error = "";

                var fen = document.getElementById("fen_input").value;
                var validate_fen = chess.validate_fen(fen);
                var pgn = document.getElementById("pgn_textbox").value;
                if(fen != "" && validate_fen.valid == false){
                    error = error + "<p>" + validate_fen.error + "</p>";
                } if(pgn != "" && chess.load_pgn(pgn) == false){
                    error = error + "<p>Your pgn is invalid.</p>";
                }
                if(error != ""){
                    $('.error').html(error);
                } else {
                    console.log(document.getElementById("fen_input").value);
                    console.log('submit!');
                    document.getElementById("paste_pgn_form").submit();
                }
            });
        });
    </script>
</head>
<body>
<div id="board" class="default whole container_fluid">
    <div id="headerButton" class="default headers">
        <button id="boardButtonreset" class="button reset">reset</button>
        <button id="boardButtonsave" class="button save">save</button>
    </div>
    <h4 id="paste_pgn_title">Please add your game information</h4>
    <div class="error"></div>
    <form id="paste_pgn_form" action="games/create_game" method="post">
        <div class="row">
            <div id="pgn_form_left" class="col-md-6">
                <label>Event</label><input type="text" name="event">
                <label>Site</label><input type="text" name="site" placeholder="">
                <label>Date</label><input type="date" name="date">
                <label>Round</label><input type="number" name="round" placeholder="">
                <label>Board</label><input type="number" name="board" placeholder="">
                <label>White</label><input type="text" name="white" placeholder="">
                <label>WhiteELO</label><input type="number" name="whiteELO" placeholder="">
                <label>Black</label><input type="text" name="black" placeholder="">
                <label>BlackELO</label><input type="number" name="blackELO" placeholder="">
                <label>Result</label><select name="result">
                                    <option value="*"></option>
                                    <option value="1-0">1-0</option>
                                    <option value="0-1">0-1</option>
                                    <option value="1/2-1/2">1/2-1/2</option>
                                </select>
                <label class="block_label">Paste PGN or leave blank for a new game</label><textarea id="pgn_textbox" type="text" name="pgn" placeholder="1.d4 Nf6 2.c4 g6 3.Nc3 Bg7 4.Nf3 O-O 5.e4 d6 6.Be2"></textarea>
                <label>Next Move</label><select id='next_move' name="next_move">
                                            <option value="w">White</option>
                                            <option value="b">Black</option>
                                        </select>
                <label class="block_label">Castling Availability</label>
                    <input id="checkbox1" class="checkbox" type="checkbox" name="K" value="K" checked>White King Castle<br>
                    <input id="checkbox2" class="checkbox" type="checkbox" name="Q" value="Q" checked>White Queen Castle<br>
                    <input id="checkbox3" class="checkbox" type="checkbox" name="k" value="k" checked>Black King Castle<br>
                    <input id="checkbox4" class="checkbox" type="checkbox" name="q" value="q" checked>Black Quen Castle<br>
            </div>
            <div id="pgn_form_right" class="col-md-6">
                <label>FEN</label><input id="fen_input" type="text" name="fen" placeholder="rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR">
                <div id="fen_board" style="width: 400px">
                </div>
                <div id="pgn_buttons">
                    <a role="button" id="startPositionBtn" class="btn btn-primary btn-md">Start Position</a>
                    <a role="button" id="clearBoardBtn" class="btn btn-primary btn-md">Clear Board</a>
                    <a role="button" id="getPositionBtn" class="btn btn-primary btn-md">Get FEN</a>
                </div>
            </div>
        </div> <!-- End of row -->
    </form>
</div>
</body>
</html>