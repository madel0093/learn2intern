<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supervisors_model extends CI_Model{

	private $table_name = 'supervisors';

	public function __construct() {
		parent::__construct();
	}

	public function getMySupervisors( $user_id ) {
		if( !is_numeric( $user_id ) )
			return null;

		$sql = 'SELECT users.id, users.username
		FROM users
		INNER JOIN supervisors ON users.id = supervisors.id AND supervisors.companyId = ?
		ORDER BY users.first_name ASC, users.last_name ASC';
		
		$query = $this->db->query($sql, array( $user_id ));
		return $query->result_array();		
	}

}

?>