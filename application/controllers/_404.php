<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Natthapong
 * Date: 5/7/2557
 * Time: 17:11 AM
 */

class _404 extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view("404");
    }

} 