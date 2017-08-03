<?php  

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CheckPoints_model extends CI_Model{

	public $name;
	public $instructions;
	public $type;
	public $meta;
	public $score = 0;
	public $point_order = 0;
	public $trials = 1;

	private $id = 0;
	private $challenge_id;
	private $submission_result;
	private $show_form = true;
	private $table_name = 'checkpoints';

	public function __construct() {
		parent::__construct();
	}

	public function getCheckPoint( $id ) {
		if( !is_numeric($id) )
			return null;

		$query = $this->db->get_where($this->table_name, array('id' => $id));
		$obj = $query->row(0, 'CheckPoints_model');
		if( !$obj ) return $obj;
		$obj->meta = unserialize($obj->meta);
		return $obj;
	}

	public function getChallengeCheckPoints( $challenge_id, $return_object = false ) {
		$query = $this->db->get_where($this->table_name, array('challenge_id' => $challenge_id));
		if( $return_object )
			return $query->result('CheckPoints_model');
		else return $query->result_array();
	}

	public function getStudentStatus( $user_id ) {
		$sql = 'SELECT verdict
		FROM students_checkpoints
		WHERE studentId = ? AND checkpoint_id = ?';
		
		$query = $this->db->query($sql, array( $user_id, $this->id ));
		if( $query->num_rows() == 0 )
			return 'no_trial';
		else return $query->row(0)->verdict;
	}

	public function canSubmit( $user_id ) {
		$sql = 'SELECT trials, verdict
		FROM students_checkpoints
		WHERE studentId = ? AND checkpoint_id = ?';
		
		$query = $this->db->query($sql, array( $user_id, $this->id ));
		if( $query->num_rows() == 0 || ($query->row(0)->trials < $this->trials && $query->row(0)->verdict != 'correct') )
			return true;
		else return false;
	}

	public function showForm() {
		return $this->show_form;
	}

	public function processSubmission( $submission, $user_id ) {
		$this->submission_result = '';
		if( isset($submission['answer-mcq']) ) {
			$answer = $submission['answer'];
			if( $answer == $this->meta['correct'] )
				$this->user_attempt($user_id, 'correct');
			else $this->user_attempt($user_id, 'wrong');
		} elseif( isset($submission['watch-video']) ) {
			$this->user_attempt($user_id, 'correct');
		} elseif ( isset($submission['file-upload']) ) {
			$response = $this->process_upload('file');
			if( isset($response['error']) ) {
				$this->submission_result = "<p class=\"error-wrapper text-center\">{$response['error']}</p>";
			} else {
				$meta = array('name' => $response['file_name'], 'type' => $response['file_type']);
				$this->user_attempt($user_id, 'wait');
				$this->update_student_checkpoint_meta( $user_id, $meta );
			}
		}
	}

	public function process_upload( $field_name ) {
		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'gif|jpg|png|zip|pdf';
		$config['max_size']             = 20480;
		$this->load->library('upload', $config);
		if ( !$this->upload->do_upload( $field_name ) ) {
			return array('error' => $this->upload->display_errors('', ''));
		} else {
			return $this->upload->data();
		}
	}

	public function user_attempt( $user_id, $verdict ) {
		$query = $this->db->get_where('students_checkpoints', array(
			'studentId' => $user_id,
			'checkpoint_id' => $this->id ));

		if( $query->num_rows() == 0 ) {
			$this->db->insert('students_checkpoints', array(
				'studentId' => $user_id,
				'checkpoint_id' => $this->id,
				'trials' => 1,
				'verdict' => $verdict ));
		} else {
			$row = $query->row(0);
			$this->db->update('students_checkpoints', array('trials' => $row->trials+1, 'verdict' => $verdict),
				array('studentId' => $user_id, 'checkpoint_id' => $this->id));
		}

		switch ($verdict) {
			case 'correct':
			$this->show_form = false;
			if( $this->type == 'video' ){
				$this->submission_result = "<p class=\"success-wrapper text-center\">Watching the video has been confirmed</p>";
			} else {
				$this->submission_result = "<p class=\"success-wrapper text-center\">Correct Answer</p>";
			}
			break;
			
			case 'wrong':
			$this->show_form = false;
			$this->submission_result = "<p class=\"error-wrapper text-center\">Wrong Answer";
			if( $this->canSubmit($user_id) ) {
				$this->submission_result .= "<br>You still can submit again.";
				$this->show_form = true;
			}
			$this->submission_result .= "</p>";
			break;

			case 'wait':
			$this->show_form = false;
			$this->submission_result = "<p class=\"warning-wrapper text-center\">Your submission is waiting for approval</p>";
			break;
		}

	}

	public function getTotalScore() {
		return $this->score;
	}

	public function getStudentScore( $user_id ) {
		$sql = 'SELECT verdict FROM students_checkpoints WHERE checkpoint_id = ? AND studentId = ?';
		$query = $this->db->query($sql, array( $this->id, $user_id ));
		return  $query->row_array()['verdict'] == 'correct' ? $this->score : 0;
	}

	public function getTotalTrials() {
		return $this->trials;
	}

	public function getStudentTrials( $user_id ) {
		$sql = 'SELECT trials FROM students_checkpoints WHERE checkpoint_id = ? AND studentId = ?';
		$query = $this->db->query($sql, array( $this->id, $user_id ));
		return  intval($query->row_array()['trials']);
	}

	public function getSubmissions() {
		$sql = 'SELECT stdchp.studentId, usr.username, stdchp.meta 
		FROM students_checkpoints as stdchp
		INNER JOIN users as usr ON stdchp.studentId = usr.id AND stdchp.verdict = ?';
		
		$query = $this->db->query($sql, array( 'wait' ));
		return $query->result_array();
	}

	public function acceptSubmission($checkpoint_id, $student_id) {
		$this->db->update('students_checkpoints', array('verdict' => 'correct'), array(
			'checkpoint_id' => $checkpoint_id, 'studentId' => $student_id ));
	}

	public function refuseSubmission($checkpoint_id, $student_id) {
		$this->db->update('students_checkpoints', array('verdict' => 'wrong'), array(
			'checkpoint_id' => $checkpoint_id, 'studentId' => $student_id ));
	}

	public function getID() {
		return $this->id;
	}

	public function getChallengeID() {
		return $this->challenge_id;
	}

	public function getSubmissionMessage() {
		return $this->submission_result;
	}

	public function getTypes() {
		return array(
			'' => '-- Select Check Point Type --',
			'mcq' => 'MCQ',
			'video' => 'Video',
			'submit' => 'Manual Verification',
			);
	}

	public function load( $input ) {
		$this->name = isset($input['name']) ? $input['name'] : "";
		$this->instructions = isset($input['instructions']) ? $input['instructions'] : "";
		$this->type = isset($input['type']) ? $input['type'] : "";
		$this->score = isset($input['score']) ? $input['score'] : 0;
		$this->trials = isset($input['trials']) ? $input['trials'] : 1;

		switch ($this->type) {
			case 'mcq':
			$this->meta = array(
				'question' => isset($input['question']) ? trim($input['question']) : '',
				'choices' => isset($input['options']) ? $input['options'] : array(),
				'correct' => isset($input['correct']) ? $input['correct'] : -1,
				);
			break;
			
			case 'video':
			$this->meta = array(
				'video_url' => $input['video']
				);
			break;
		}
	}

	public function save( $challenge_id ) {
		$this->meta = serialize($this->meta);
		if( $this->id == 0 )
			$this->create( $challenge_id );
		else $this->update();
	}

	private function create( $challenge_id ) {
		$this->db->set('challenge_id', $challenge_id);
		$this->db->insert($this->table_name, $this);
		$this->id = $this->db->insert_id();
		$this->challenge_id = $challenge_id;
	}

	private function update() {
		$this->db->update($this->table_name, $this, array('id' => $this->id));
	}

	public function delete( $id ) {
		$this->db->delete($this->table_name, array('id' => $id ));
	}

	private function update_student_checkpoint_meta( $user_id, $meta ) {
		$meta = serialize($meta);
		$this->db->update('students_checkpoints', array('meta' => $meta), array(
			'checkpoint_id' => $this->id, 'studentId' => $user_id));
	}

	public function getRules() {
		$rules = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'trim|required'
				),
			array(
				'field' => 'instructions',
				'label' => 'Instructions',
				'rules' => 'trim|required',
				),
			array(
				'field' => 'type',
				'label' => 'Type',
				'rules' => 'trim|required',
				),
			array(
				'field' => 'type',
				'label' => 'Type',
				'rules' => 'trim|required|in_list[mcq,video,submit]',
				array(
					'in_list' => 'Invalid Check Point Type',
					)
				),
			array(
				'field' => 'meta',
				'label' => 'Meta',
				'rules' => 'callback_meta_for_type',
				),
			array(
				'field' => 'score',
				'label' => 'Score',
				'rules' => 'trim|required|numeric|greater_than_equal_to[0]',
				),
			array(
				'field' => 'trials',
				'label' => 'Trials',
				'rules' => 'trim|required|numeric|greater_than_equal_to[1]',
				)
			);
		return $rules;
	}

}

?>