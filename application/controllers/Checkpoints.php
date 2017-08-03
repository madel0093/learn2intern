<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CheckPoints extends CI_Controller {

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

    $this->load->model('CheckPoints_model', 'model');
    $this->model = $this->model->getCheckPoint( $id );
    if( !$this->model )
      show_404();

    $user_id = $this->ion_auth->get_user_id();
    $this->load->model('Users_model');
    $manage = $this->Users_model->user_can_manage_checkpoint($user_id, $id);

    $data = array('checkpoint' => $this->model, 'manage' => $manage);
    $this->load->view('CheckPoints/viewOneCheckPoint', $data);
  }

  public function accept($checkpoint_id, $student_id) {
    $user_id = $this->ion_auth->get_user_id();
    $this->load->model('Users_model');
    if( ! $this->Users_model->user_can_manage_checkpoint($user_id, $checkpoint_id) )
      show_404();

    $this->load->model('CheckPoints_model');
    $this->CheckPoints_model->acceptSubmission($checkpoint_id, $student_id);
    redirect('checkpoints/index/'.$checkpoint_id, 'refresh');
  }

  public function refuse($checkpoint_id, $student_id) {
    $user_id = $this->ion_auth->get_user_id();
    $this->load->model('Users_model');
    if( ! $this->Users_model->user_can_manage_checkpoint($user_id, $checkpoint_id) )
      show_404();

    $this->load->model('CheckPoints_model');
    $this->CheckPoints_model->refuseSubmission($checkpoint_id, $student_id);
    redirect('checkpoints/index/'.$checkpoint_id, 'refresh');
  }

  public function create( $challenge_id ) {

    $user_id = $this->ion_auth->get_user_id();
    $this->load->model('Users_model');
    if( !$this->Users_model->user_can_manage_challenge_checkpoints($user_id, $challenge_id) )
      show_404();

    $this->load->model('CheckPoints_model', 'model');

    $this->load->library('form_validation');
    $this->form_validation->set_rules($this->model->getRules());

    if( isset($_POST['create']) ) {
      $this->model->load($this->input->post());

      if ($this->form_validation->run()) {
        $this->model->save( $challenge_id );
        redirect('challenges/index/'.$this->model->getChallengeID(), 'refresh');
      }
    }

    $this->load->view('CheckPoints/createCheckPoint', array(
      'model' => $this->model,
      'action' => 'create'
      ));
  }

  public function update( $id ) {

    $user_id = $this->ion_auth->get_user_id();
    $this->load->model('Users_model');
    if( !$this->Users_model->user_can_manage_checkpoint($user_id, $id) )
      show_404();

    $this->load->model('CheckPoints_model', 'model');
    $this->model = $this->model->getCheckPoint($id);

    $this->load->library('form_validation');
    $this->form_validation->set_rules($this->model->getRules());

    if( isset($_POST['update']) ) {
      $this->model->load($this->input->post());

      if ($this->form_validation->run()) {
        $this->model->save( $id );
        redirect('challenges/index/'.$this->model->getChallengeID(), 'refresh');
      }
    }

    $this->load->view('CheckPoints/updateCheckPoint', array(
      'model' => $this->model,
      'action' => 'update'
      ));
  }

  public function delete( $id ) {
    $user_id = $this->ion_auth->get_user_id();
    $this->load->model('Users_model');
    if( !$this->Users_model->user_can_manage_checkpoint($user_id, $id) )
      show_404();

    $this->load->model('CheckPoints_model');
    $challenge_id = $this->CheckPoints_model->getCheckPoint($id)->getChallengeID();
    $this->CheckPoints_model->delete($id);
    redirect('challenges/index/'.$challenge_id, 'refresh');
  }

  /* Custom Validation */
  public function meta_for_type( $str ) {
    $type = $this->input->post('type');
    switch ( $type ) {
      case 'mcq':
      $question = $this->input->post('question');
      if( !isset($question) || empty(trim($question)) ) {
        $this->form_validation->set_message('meta_for_type', "Please enter the question");
        return false;
      }

      $options = $this->input->post('options');
      if( !is_array($options) || count($options) == 0 ) {
        $this->form_validation->set_message('meta_for_type', "Please enter your choices");
        return false;
      }
      if( in_array("", $options) ) {
        $this->form_validation->set_message('meta_for_type', "Please delete the empty choices");
        return false;
      }
      if( count($options) < 2 ) {
        $this->form_validation->set_message('meta_for_type', "Minimum number of choices is 2");
        return false;
      }
      $correct = $this->input->post('correct');
      if( !isset($correct) || !is_numeric($correct) || !isset($options[$correct]) ) {
        $this->form_validation->set_message('meta_for_type', "Please select the correct answer");
        return false;
      }
      return true;
      break;

      case 'video':
      $video_url = $this->input->post('video');
      if( !isset($video_url) ) {
        $this->form_validation->set_message('meta_for_type', "Please enter the video url");
        return false;        
      }
      if( !filter_var($video_url, FILTER_VALIDATE_URL) ) {
        $this->form_validation->set_message('meta_for_type', "Invalid Video Url");
        return false;
      }

      case 'submit':
      return true;
      break;
    }
    $this->form_validation->set_message('meta_for_type', "Select your check point type");
    return false;
  }

}