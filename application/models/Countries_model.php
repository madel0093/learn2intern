<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Countries_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }
	public function getCountries(){
		$this->db->from('countries');
        $query = $this->db->get();
        return $result = $query->result();
	}	
}
?>