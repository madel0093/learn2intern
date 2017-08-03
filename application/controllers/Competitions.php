<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Competitions extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if ( !$this->ion_auth->logged_in() )
			redirect('auth/login', 'refresh');

		if( $this->ion_auth->is_student() )
			redirect('Students/index', 'refresh');
	}

	public function index( $id = 0 ) {
		$user_id = $this->ion_auth->get_user_id();
		if( is_numeric($id) && $id > 0 ) {

			$this->load->model('Competitions_model');
			$competition = $this->Competitions_model->getCompetition( $id );
			if( !$competition )
				show_404();

			$this->load->model('Challenges_model');
			$challenges = $this->Challenges_model->getCompetitionChallenges( $id );

			$this->load->model('Users_model');
			$data = array(
				'competition' => $competition, 
				'challenges' => $challenges,
				'edit' => $this->Users_model->user_can_manage_competition_challenges($user_id, $id),
				);
			$this->load->view('Competitions/viewOneCompetition', $data);

		} elseif( $this->ion_auth->is_company() ) {

			$this->load->model('Competitions_model');
			$competitions = $this->Competitions_model->getCompanyCompetitions( $user_id );
			$data = array('competitions' => $competitions, 'edit' => true);
			$this->load->view('Competitions/viewMyCompetitions', $data);

		} elseif( $this->ion_auth->is_supervisor() ) {

			$this->load->model('Competitions_model');
			$competitions = $this->Competitions_model->getSupervisorsCompetitions( $user_id );
			$data = array('competitions' => $competitions, 'edit' => false);
			$this->load->view('Competitions/viewMyCompetitions', $data);

		}
	}

	public function create() {
		if( !$this->ion_auth->is_company() )
			show_404();

		$user_id = $this->ion_auth->get_user_id();
		$this->load->model('Supervisors_model', 'supervisor');
		$supervisors = $this->supervisor->getMySupervisors($user_id);

		$this->load->model('Competitions_model', 'model');
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->model->getRules());

		if( isset($_POST['create']) ) {
			$this->model->name = $this->input->post('name');
			$this->model->description = $this->input->post('description');
			$this->model->startTime = $this->input->post('startTime');
			$this->model->endTime = $this->input->post('endTime');
			$this->model->registration_open = isset($_POST['registration_open']) ? true : false;

			if ($this->form_validation->run()) {
				$this->model->save( $user_id );
				$this->load->model('Supervisors_Competitions_model');
				$this->Supervisors_Competitions_model
				->setCompetitionSupervisors($this->model->getID(), $this->input->post('supervisors'));

				redirect('competitions', 'refresh');
			}
		}

		$this->load->view('Competitions/createCompetition', array(
			'model' => $this->model,
			'supervisors' => $supervisors,
			'current_supervisors' => $this->input->post('supervisors'), 
			'action' => 'create'
			));
	}

	public function update( $id ) {

		$user_id = $this->ion_auth->get_user_id();
		$this->load->model('Users_model');
		if( !$this->Users_model->user_can_manage_competition($user_id, $id) )
			show_404();

		$this->load->model('Competitions_model', 'model');
		$this->model = $this->model->getCompetition($id);

		$this->load->model('Supervisors_model', 'supervisor');
		$supervisors = $this->supervisor->getMySupervisors($user_id);

		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->model->getRules());

		if( isset($_POST['update']) ) {
			$this->model->name = $this->input->post('name');
			$this->model->description = $this->input->post('description');
			$this->model->startTime = $this->input->post('startTime');
			$this->model->endTime = $this->input->post('endTime');
			$this->model->registration_open = isset($_POST['registration_open']) ? true : false;

			if ($this->form_validation->run()) {
				$this->model->save( $user_id );
				$this->load->model('Supervisors_Competitions_model');
				$this->Supervisors_Competitions_model
				->setCompetitionSupervisors($this->model->getID(), $this->input->post('supervisors'));

				redirect('competitions', 'refresh');
			}
		}

		$this->load->model('Supervisors_Competitions_model');
		$current_supervisors = $this->Supervisors_Competitions_model->getMyCompetitionSupervisors( $id );		
		$this->load->view('Competitions/updateCompetition', array(
			'model' => $this->model,
			'supervisors' => $supervisors,
			'current_supervisors' => $current_supervisors,
			'action' => 'update'
			));
	}

	public function delete( $id ) {
		$user_id = $this->ion_auth->get_user_id();
		$this->load->model('Users_model');
		if( !$this->Users_model->user_can_manage_competition($user_id, $id) )
			show_404();

		$this->load->model('Competitions_model');
		$this->Competitions_model->delete($id, $user_id);
		redirect('competitions', 'refresh');
	}

	public function manualVerifications() {
		if( !$this->ion_auth->is_supervisor() )
			show_404();

		$user_id = $this->ion_auth->get_user_id();
		$this->load->model('Users_model');
		$submissions = $this->Users_model->get_my_manual_verifications_checkpoints( $user_id );
		$this->load->view('Competitions/ManualVerifications', array('data' => $submissions));
	}

	/* Custom Validation */
	public function in_my_supervisors( $str ) {
		$selected_supervisors = $this->input->post('supervisors');

		$this->load->model('Supervisors_model', 'supervisor');
		$user_id = $this->ion_auth->get_user_id();
		$supervisors = array_column($this->supervisor->getMySupervisors($user_id), 'id');

		if( count(array_intersect($selected_supervisors, $supervisors)) != count($selected_supervisors) ) {
			$this->form_validation->set_message('in_my_supervisors', 
				"You are not allowed to choose supervisors not assigned to your company");
			return false;
		}
		return true;
	}

}