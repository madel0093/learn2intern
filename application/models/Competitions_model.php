<?php  

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Competitions_model extends CI_Model{

	public $name;
	public $description;
	public $startTime;
	public $endTime;
	public $registration_open;

	private $id = 0;
	private $companyId;
	private $table_name = 'competitions';

	public function __construct() {
		parent::__construct();
	}

	public function getCompetition( $id) {
		if( !is_numeric($id) )
			return null;

		$query = $this->db->get_where($this->table_name, array('id' => $id));
		return $query->row(0, 'Competitions_model');
	}

	public function getCompanyCompetitions( $user_id ) {
		$query = $this->db->get_where($this->table_name, array('companyId' => $user_id));
		return $query->result_array();
	}

	public function getSupervisorsCompetitions( $user_id ) {
		$sql = 'SELECT * FROM competitions WHERE id IN 
		( SELECT competitionId FROM supervisors_competitions WHERE supervisorId = ? )';
		
		$query = $this->db->query($sql, array( $user_id ));
		return $query->result_array();
	}
	
	public function getOpenCompetitions( ) {
		$query = $this->db->get_where($this->table_name, array('registration_open' => true));
		return $query->result_array();
	}

	public function getCompetitions() {
		$this->db->from($this->table_name);
		$query = $this->db->get();
		return $result = $query->result();
	}

	public function getID() {
		return $this->id;
	}

	public function RegisterToCompetition($studentId,$competitionId){
		$data = array(
			'studentId'=>$studentId,
			'competitionId'=>$competitionId
			);
		$this->db->insert('students_competitions',$data);	
	}
	
	public function IsUserRegisteredToCompetition($studentId,$competitionId){
		$query = $this->db->get_where('students_competitions', array('studentId'=>$studentId,'competitionId'=>$competitionId));
		return ($query->num_rows() == 1 ? true : false);
	}

	public function save( $user_id ) {
		$this->startTime = date("Y-m-d H:i:s", strtotime($this->startTime));
		$this->endTime   = date("Y-m-d H:i:s", strtotime($this->endTime));
		if( $this->id == 0 )
			$this->create( $user_id );
		else $this->update();
	}

	private function create( $user_id ) {
		$this->db->set('companyId', $user_id);
		$this->db->insert($this->table_name, $this);
		$this->id = $this->db->insert_id();
	}

	private function update() {
		$this->db->update($this->table_name, $this, array('id' => $this->id));
	}

	public function delete( $id ) {
		$this->db->delete($this->table_name, array('id' => $id));
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
			array(
				'field' => 'startTime',
				'label' => 'Start Time',
				'rules' => 'trim|required|is_date'
				),
			array(
				'field' => 'endTime',
				'label' => 'End Time',
				'rules' => 'trim|required|is_date|date_greater_than[startTime]'
				),
			array(
				'field' => 'supervisors[]',
				'label' => 'Supervisors',
				'rules' => 'callback_in_my_supervisors'
				)
			);
		return $rules;
	}

}

?>