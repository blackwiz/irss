<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_company extends CI_Controller {
    public function  __construct() {
        parent::__construct();
        $this->dokumen_lib->check_admin_login();
        $this->dokumen_lib->cek_wewenang_menu();
        $this->load->model("m_master_company");
    }

    public function index() {
        $this->lists();
    }
	
    public function lists() {

		$data['home'] = base_url().'master_company';
		$data['modul'] = 'Management Company';
		$data['title'] = 'List Company';
		$data['subtitle'] = 'Company';
		$data['listener'] = 'master_company/listener';
		
		$data["menu"] = $this->dokumen_lib->build_menu();
		$data['content'] = $this->load->view('backend/master_company/list', $data, TRUE);
		$data["content"] = $this->load->view("backend/v_home", $data);
	       
    }
    
    public function listener() {
			// variable initialization
			$search = "";
			$start = 10;
			$rows = 0;
			$where = array();
			
			// get search value (if any)
			if ($this->input->post('sSearch') != "" ) 
			{
				//$search = $this->input->post('sSearch');
				$where["LOWER(company_name) LIKE "] = "'%".strtolower($this->input->post('sSearch'))."%'";
			}
			
			// limit
			$rows = $this->dokumen_lib->get_start($this->input->post('iDisplayStart'));
			$start = $this->dokumen_lib->get_rows($this->input->post('iDisplayLength'));

			// sort
			$sort_dir = $this->dokumen_lib->get_sort_dir($this->input->post('sSortDir_0'));

			// run query to get user listing
			$cols = array(  "a.company_name", "a.company_email", "sum_jobs_active", "sum_jobs_expire", "a.company_id");
			$sumcols = 5;
			$sql = $this->m_master_company->Listener($start, $rows, $where, $this->dokumen_lib->get_sort($this->input->post('iSortCol_0'),$cols,$sumcols), $sort_dir);
			$iFilteredTotal = $sql->num_rows();

			$iTotal = $this->m_master_company->RowsAll($where)->num_rows();

				/*
				 * Output
				 */
				 $output = array(
					 "sEcho" => intval($this->input->post('sEcho')),
					 "iTotalRecords" => $iFilteredTotal,
					 "iTotalDisplayRecords" => $iTotal,
					 "aaData" => array()
				 );

				// get result after running query and put it in array
				foreach ($sql->result_array() as $row) {
				$record = array();
				$record[] = $row['company_name'];
				$record[] = $row['company_email'];
				$record[] = $row['sum_jobs_active'];
				$record[] = $row['sum_jobs_expire'];
				$record[] = '<a class="action btn btn-info" href="'.base_url().'home/company/'.$row['company_id'].'/'.url_title($row['company_name']).'" target="_blank">
								<i class="icon-share-alt icon-white"></i> 
									Detail
							</a>';

				$output['aaData'][] = $record;
			}
			// format it to JSON, this output will be displayed in datatable
			echo json_encode($output);
	}

}
