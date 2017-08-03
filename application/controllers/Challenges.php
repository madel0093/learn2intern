<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Challenges extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if ( !$this->ion_auth->logged_in() )
			redirect('auth/login', 'refresh');

		if( $this->ion_auth->is_student() )
			redirect('Students/index', 'refresh');
	}

	public function index( $id ) {
		if( !is_numeric($id) )
			show_404();

		$user_id = $this->ion_auth->get_user_id();

		$this->load->model('Challenges_model');
		$challenge = $this->Challenges_model->getChallenge( $id );
		if( !$challenge )
			show_404();

		$this->load->model('CheckPoints_model');
		$checkpoints = $this->CheckPoints_model->getChallengeCheckPoints( $id );

		$this->load->model('Users_model');
		$data = array(
			'challenge' => $challenge, 
			'checkpoints' => $checkpoints,
			'edit' => $this->Users_model->user_can_manage_challenge_checkpoints($user_id, $id)
			);
		$this->load->view('Challenges/viewOneChallenge', $data);
	}

	public function create( $competition_id ) {

		$user_id = $this->ion_auth->get_user_id();
		$this->load->model('Users_model');
		if( !$this->Users_model->user_can_manage_competition_challenges($user_id, $competition_id) )
			show_404();

		$this->load->model('Challenges_model', 'model');

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->model->getRules());

		if( isset($_POST['create']) ) {
			$this->model->name = $this->input->post('name');
			$this->model->description = $this->input->post('description');

			if ($this->form_validation->run()) {
				$this->model->save( $competition_id );
				redirect('challenges/index/'.$this->model->getID(), 'refresh');
			}
		}

		$this->load->view('Challenges/createChallenge', array(
			'model' => $this->model,
			'action' => 'create'
			));
	}

	public function update( $id ) {

		$user_id = $this->ion_auth->get_user_id();
		$this->load->model('Users_model');
		if( !$this->Users_model->user_can_manage_challenge($user_id, $id) )
			show_404();

		$this->load->model('Challenges_model', 'model');
		$this->model = $this->model->getChallenge($id);

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->model->getRules());

		if( isset($_POST['update']) ) {
			$this->model->name = $this->input->post('name');
			$this->model->description = $this->input->post('description');
			
			if ($this->form_validation->run()) {
				$this->model->save( $competition_id );
				redirect('challenges/index/'.$this->model->getID(), 'refresh');
			}
		}

		$this->load->view('Challenges/updateChallenge', array(
			'model' => $this->model,
			'action' => 'update'
			));
	}

	public function delete( $id ) {
		$user_id = $this->ion_auth->get_user_id();
		$this->load->model('Users_model');
		if( !$this->Users_model->user_can_manage_challenge($user_id, $id) )
			show_404();

		$this->load->model('Challenges_model');
		$competition_id = $this->Challenges_model->getChallenge($id)->getCompetitionID();
		$this->Challenges_model->delete($id);
		redirect('competitions/index/'.$competition_id, 'refresh');
	}

}