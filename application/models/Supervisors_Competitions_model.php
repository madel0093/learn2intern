
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Supervisors_Competitions_model extends CI_Model{

	private $table_name = 'supervisors_competitions';

	public function __construct() {
		parent::__construct();
	}

	public function setCompetitionSupervisors($competition_id, $supervisors){
		$this->db->delete($this->table_name, array('competitionId' => $competition_id));
		if( !is_array($supervisors) )
			return;
		foreach ($supervisors as $supervisor_id) {
			$this->db->insert($this->table_name, array(
				'supervisorId' => $supervisor_id, 
				'competitionId' => $competition_id,
				));
		}
	}

	public function getMyCompetitionSupervisors( $competition_id ) {
		if( !is_numeric( $competition_id ) )
			return null;
		$query = $this->db->get_where($this->table_name, array('competitionId' => $competition_id));
		return array_column($query->result_array(), 'supervisorId');
	}

}

?>