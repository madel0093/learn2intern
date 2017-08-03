<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Universities_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }
	public function getUniversities($cityId){
		$this->db->from('universities');
		$this->db->where('cityId', $cityId );
        $query = $this->db->get();
        return $result = $query->result();
	}	
}
?>