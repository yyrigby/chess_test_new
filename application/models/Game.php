<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Game extends CI_Controller {

	public function get_games($user_id) {
		$query = "SELECT id, white, black, date, event
				FROM games
				WHERE user_id = ?
				ORDER BY date DESC";
		return $this->db->query($query,$user_id)->result_array();
	}

	public function get_game($game_id) {
		$query = "SELECT * FROM games WHERE id = ?";
		return $this->db->query($query,$game_id)->row_array();
	}


	public function create($pgnData) {
		$query = 'INSERT INTO games (event, site, date, round, board, white, whiteELO, black, blackELO, result, fen, pgn, created_at, updated_at, user_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?, NOW(), NOW(), ?)';
		$array = array('event' => $pgnData['event'],
						'site' => $pgnData['site'],
						'date' => $pgnData['date'],
						'round' => $pgnData['round'],
						'board' => $pgnData['board'],
						'white' => $pgnData['white'],
						'whiteElo' => $pgnData['whiteELO'],
						'black' => $pgnData['black'],
						'blackELO' => $pgnData['blackELO'],
						'result' => $pgnData['result'],
						'fen' => $pgnData['fen'],
						'pgn' => $pgnData['pgn'],
						'user_id' => $this->session->userdata('user_id'));
		$this->db->query($query, $array);
		return $this->db->insert_id();
	}

	public function update($pgnData) {
		$query = 'UPDATE games
				SET pgn=?, updated_at=NOW()
				WHERE id=?';
		$array = array(
						'pgn' => $pgnData['pgn'],
						'game_id' => $pgnData['game_id']);
		$this->db->query($query, $array);
		return "good job";
	}











}