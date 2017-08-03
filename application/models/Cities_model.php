<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cities_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }
	public function getCities($countryId){
		$this->db->from('cities');
		$this->db->where('countryId', $countryId );
        $query = $this->db->get();
        return $result = $query->result();
	}	
}
?>