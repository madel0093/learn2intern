<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();

		if ( !$this->ion_auth->logged_in() )
			redirect('auth/login', 'refresh');

		if( !$this->ion_auth->is_student() )
			show_404();

		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
	}

	public function index()
	{
		$this->load->helper(array('url','utility'));
		$this->load->view('Students/Index');
	}

	public function RegisterCompetition($competitionId)
	{
		$this->load->model('Competitions_model');
		$Competition = $this->Competitions_model->getCompetition($competitionId);
		$user = $this->ion_auth->user()->row();
		if($Competition->registration_open==true){
			if($this->Competitions_model->IsUserRegisteredToCompetition($user->id,$competitionId)==false){
				$this->Competitions_model->RegisterToCompetition($user->id,$competitionId);
			}
		}
		redirect('students/competition/'.$competitionId, 'refresh');
	}

	public function competitions()
	{
		$this->load->model('Competitions_model');
		$Competitions= $this->Competitions_model->getCompetitions();
		$data['Competitions'] = array();
		$user = $this->ion_auth->user()->row();
		for($i = 0; $i < count($Competitions) ; $i++) {
			$element['model'] = $Competitions[$i];
			$element['registered'] = $this->Competitions_model->IsUserRegisteredToCompetition($user->id,$Competitions[$i]->id);
			array_push($data['Competitions'], $element);
		}
		$this->load->view('Students/Competitions',$data);
	}

	public function competition( $competition_id ) {
		$this->load->model('Competitions_model');
		$competition = $this->Competitions_model->getCompetition( $competition_id );
		if( !$competition )
			show_404();

		$this->load->model('Challenges_model');
		$challenges = $this->Challenges_model->getCompetitionChallenges( $competition_id, true );

		$user_id = $this->ion_auth->get_user_id();
		$registered = $this->Competitions_model->IsUserRegisteredToCompetition($user_id, $competition_id);
		$this->load->view('Students/CompetitionChallenges', array(
			'user_id' => $user_id,
			'competition' => $competition,
			'challenges' => $challenges, 
			'registered' => $registered));
	}

	public function challenge( $challenge_id ) {
		$this->load->model('Challenges_model');
		$challenge = $this->Challenges_model->getChallenge( $challenge_id );
		if( !$challenge )
			show_404();

		$this->load->model('CheckPoints_model');
		$checkpoints = $this->CheckPoints_model->getChallengeCheckPoints( $challenge_id, true );

		$user_id = $this->ion_auth->get_user_id();
		$this->load->model('Competitions_model');
		$registered = $this->Competitions_model->IsUserRegisteredToCompetition($user_id, $challenge->getCompetitionID());
		$this->load->view('Students/ChallengeCheckPoints', array(
			'user_id' => $user_id,
			'challenge' => $challenge,
			'checkpoints' => $checkpoints,
			'registered' => $registered));
	}

	public function checkpoint( $checkpoint_id ) {
		$this->load->model('CheckPoints_model');
		$checkpoint = $this->CheckPoints_model->getCheckPoint( $checkpoint_id );
		if( !$checkpoint )
			show_404();

		$user_id = $this->ion_auth->get_user_id();
		$can_submit = $checkpoint->canSubmit( $user_id );
		if( $_SERVER['REQUEST_METHOD'] == 'POST' && $can_submit )
			$checkpoint->processSubmission( $this->input->post(), $user_id );

		$this->load->view('Students/CheckPoint', array('checkpoint' => $checkpoint, 'can_submit' => $can_submit));
	}

	public function profile(){
		$this->load->view('Students/Profile');
	}

	public function todolist(){
		$this->load->view('Students/ToDoList');
	}

}