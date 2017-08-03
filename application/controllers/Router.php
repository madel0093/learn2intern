<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Router extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {

		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}
		else if($this->ion_auth->is_admin()) {

		}
		else if($this->ion_auth->is_student()) {
			redirect('Students/index', 'refresh');
		}
		else if($this->ion_auth->is_company()) {
			redirect('competitions', 'refresh');
		}
		else if($this->ion_auth->is_supervisor()) {
			redirect('competitions', 'refresh');
		}
		else {
			log_message('error', 'Some one logged in & was assigned to undefined groub');
		}

	}

}