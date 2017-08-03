<?php  

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model{

	public function __construct() {
		parent::__construct();
	}

	public function user_can_manage_competition( $user_id, $competition_id ) {
		$sql = 'SELECT id
		FROM competitions
		WHERE companyId = ? AND id = ?';
		
		$query = $this->db->query($sql, array( $user_id, $competition_id ));
		return ( $query->num_rows() > 0 ) ? true : false;
	}

	public function user_can_manage_competition_challenges( $user_id, $competition_id ) {
		$sql = 'SELECT supervisorId
		FROM supervisors_competitions
		WHERE supervisorId = ? AND competitionId = ?';
		
		$query = $this->db->query($sql, array( $user_id, $competition_id ));
		return ( $query->num_rows() > 0 ) ? true : false;
	}

	public function user_can_manage_challenge_checkpoints( $user_id, $challenge_id ) {
		$sql = 'SELECT chl.id
		FROM challenges as chl
		INNER JOIN competitions as com ON  chl.competition_id = com.id AND chl.id = ?
		INNER JOIN supervisors_competitions as spcom ON spcom.competitionId = com.id AND spcom.supervisorId = ?';
		
		$query = $this->db->query($sql, array( $challenge_id, $user_id ));
		return ( $query->num_rows() > 0 ) ? true : false;
	}

	public function user_can_manage_challenge( $user_id, $challenge_id ) {
		$sql = 'SELECT chl.id
		FROM challenges as chl
		INNER JOIN competitions as com ON  chl.competition_id = com.id AND chl.id = ?
		INNER JOIN supervisors_competitions as spcom ON spcom.competitionId = com.id AND spcom.supervisorId = ?';
		
		$query = $this->db->query($sql, array( $challenge_id, $user_id ));
		return ( $query->num_rows() > 0 ) ? true : false;
	}

	public function user_can_manage_checkpoint( $user_id, $checkpoint_id ) {
		$sql = 'SELECT chp.id
		FROM checkpoints as chp
		INNER JOIN challenges as chl ON chp.challenge_id = chl.id AND chp.id = ?
		INNER JOIN competitions as com ON  chl.competition_id = com.id
		INNER JOIN supervisors_competitions as spcom ON spcom.competitionId = com.id AND spcom.supervisorId = ?';
		
		$query = $this->db->query($sql, array( $checkpoint_id, $user_id ));
		return ( $query->num_rows() > 0 ) ? true : false;
	}

	public function get_my_manual_verifications_checkpoints( $user_id ) {
		$sql = 'SELECT com.name as competition, chl.name as challenge, chp.name as checkpoint, chp.id as id, COUNT(*) as cnt
		FROM students_checkpoints as stdchp
		INNER JOIN checkpoints as chp ON stdchp.checkpoint_id = chp.id AND stdchp.verdict = "wait"
		INNER JOIN challenges as chl ON chp.challenge_id = chl.id
		INNER JOIN competitions as com ON  chl.competition_id = com.id
		INNER JOIN supervisors_competitions as spcom ON spcom.competitionId = com.id AND spcom.supervisorId = ?
		GROUP BY chp.id';
		
		$query = $this->db->query($sql, array( $user_id ));
		return $query->result_array();
	}

}

?>