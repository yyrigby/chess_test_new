<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Games extends CI_Controller {

	// grabs the user's games from the database and loads them to the my_games
	public function my_games()
	{
		// $this->output->enable_profiler();
		if(!$this->session->userdata('logged_in'))
		{
			redirect('/');
		} else {
			$this->load->model('game');
			$games = $this->game->get_games($this->session->userdata('user_id'));

			$table = "";
			$game_no = 1;
			foreach($games as $game){
				$table = $table . "<tr>
										<td>" . $game_no . "</td>
										<td>" . $game['white'] . "</td>
										<td>" . $game['black'] . "</td>
										<td>" . $game['date'] . "</td>
										<td>" . $game['event'] . "</td>
										<td><a href='view_game/" . $game['id'] . "'>Analyze</a></td>
									</tr>";
				$game_no ++;
			}
			$data['table'] = $table;

			$this->load->view('header');
			$this->load->view('my_games', $data);
		}
	}

	public function view_game($game_number)
	{
		$this->output->enable_profiler();
		$this->load->model('game');
		$game = $this->game->get_game($game_number);
		$data = [];
		// if($this->session->userdata('user_id') != $game['user_id'])
		// {
			// redirect('/my_games');
		// } else {
			$data['fen'] = $game['fen'];
			$data['pgn'] = '[Date "' . $game['date'] . '"]\
		                    [Result "' . $game['result'] . '"]\
		                    [White "' . addslashes($game['white']) . '"]\
		                    [Black "' . addslashes($game['black']) . '"]\
		                    [WhiteElo "' . $game['whiteELO'] . '"]\
		                    [BlackElo "' . $game['blackELO'] . '"]\
		                    [Event "' . addslashes($game['event']) . '"]\
		                    [Round "' . $game['round'] . '"]\
		                    [Site "' . addslashes($game['site']) . '"]\
					        ' . addslashes($game['pgn']) . ' \
					        ';
			$data['game_id'] = $game_number;
			$this->load->view('header');
			$this->load->view('game_page', $data);
		// }
	}

	public function create_game() {
		$this->output->enable_profiler();
		$pgnData = $this->input->post();
		var_dump($pgnData);

		$this->load->model('game');
		$game_id = $this->game->create($pgnData);

		redirect('view_game/'.$game_id);
	}

	public function update_game() {
		$pgnData = $this->input->post();

		$this->load->model('game');
		echo $this->game->update($pgnData);

		die();
	}



}