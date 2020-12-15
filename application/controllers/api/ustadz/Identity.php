<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Identity extends RestController {

    public function index_get(String $ustadzId)
    {
        if ($ustadzId === null) {
            $this->response(array(
                'message' => "Please provide an Ustadz ID!"
            ), RestController::HTTP_NOT_ACCEPTABLE);
        } else {
            $query = $this->db->select('name, phone, gender, email, address')
                                ->from('tbl_ustadz')
                                ->where('id', $ustadzId)
                                ->get();
            if ($query->num_rows() > 0) {
                $this->response($query->row(), RestController::HTTP_OK);
            } else {
                $this->response(array(
                    'message' => "Ustadz ID not found!"
                ), RestController::HTTP_NOT_FOUND);
            }
        }
    }

    public function index_put(String $ustadzId)
    {
        if ($ustadzId == null) {
            $this->response(array(
                'message' => "Please provide an Ustadz ID!"
            ), RestController::HTTP_NOT_ACCEPTABLE);
        } else {
            $data = array (
                'name' => $this->put('name'),
                'phone' => $this->put('phone'),
                'gender' => $this->put('gender'),
                'address' => $this->put('address'),
                'email' => $this->put('email')
            );
            $this->db->update('tbl_ustadz', $data, ['id' => $ustadzId]);
            $this->response(array(
                'message' => "Successfully modified!"
            ), RestController::HTTP_OK);
        }
    }

}

/* End of file Identity.php */
