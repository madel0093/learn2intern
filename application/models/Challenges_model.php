<?php  

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Challenges_model extends CI_Model{

	public $name;
	public $description;

	private $id = 0;
	private $competition_id;
	private $table_name = 'challenges';

	public function __construct() {
		parent::__construct();
	}

	public function getChallenge( $id ) {
		if( !is_numeric($id) )
			return null;

		$query = $this->db->get_where($this->table_name, array('id' => $id));
		return $query->row(0, 'Challenges_model');
	}

	public function getCompetitionChallenges( $competition_id, $return_object = false ) {
		$query = $this->db->get_where($this->table_name, array('competition_id' => $competition_id));
		if( $return_object )
			return $query->result('Challenges_model');
		else return $query->result_array();
	}

	public function getStudentStatus( $user_id ) {
		$sql = 'SELECT COUNT(*) 
		FROM students_checkpoints 
		WHERE studentId = ? AND verdict = ?';
		
		$query = $this->db->query($sql, array( $user_id, 'correct' ));
		$correct_checkpoints = $query->row_array()['COUNT(*)'];

		if( $correct_checkpoints == 0 )
			return 'empty';

		$sql = 'SELECT COUNT(*) 
		FROM checkpoints 
		WHERE challenge_id = ?';

		$query = $this->db->query($sql, array( $this->id ));
		$all_checkpoints = $query->row_array()['COUNT(*)'];

		if( $correct_checkpoints == $all_checkpoints )
			return 'full';

		return 'some';
	}

	public function getTotalScore() {
		$sql = 'SELECT SUM(score) 
		FROM checkpoints 
		WHERE challenge_id = ?';
		
		$query = $this->db->query($sql, array( $this->id ));
		return intval($query->row_array()['SUM(score)']);
	}

	public function getStudentScore( $user_id ) {
		$sql = 'SELECT SUM(score) FROM checkpoints WHERE challenge_id = ? 
		AND id IN ( SELECT checkpoint_id FROM students_checkpoints WHERE studentId = ? AND verdict = ? )';
		
		$query = $this->db->query($sql, array( $this->id, $user_id, 'correct' ));
		return intval($query->row_array()['SUM(score)']);
	}

	public function getID() {
		return $this->id;
	}

	public function getCompetitionID() {
		return $this->competition_id;
	}

	public function save( $competition_id ) {
		if( $this->id == 0 )
			$this->create( $competition_id );
		else $this->update();
	}

	private function create( $competition_id ) {
		$this->db->set('competition_id', $competition_id);
		$this->db->insert($this->table_name, $this);
		$this->id = $this->db->insert_id();
	}

	private function update() {
		$this->db->update($this->table_name, $this, array('id' => $this->id));
	}

	public function delete( $id ) {
		$this->db->delete($this->table_name, array('id' => $id ));
	}

	public function getRules() {
		$rules = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'trim|required'
				),
			array(
				'field' => 'description',
				'label' => 'Description',
				'rules' => 'trim|required',
				),
			);
		return $rules;
	}

}

?>