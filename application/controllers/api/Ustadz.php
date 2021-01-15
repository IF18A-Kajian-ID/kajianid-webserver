<?php defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Ustadz extends RestController {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('Characters', 'chars');
    }
    
    public function index_get() {
        $search = $this->get("search");
        $isReadMode = $this->get("read");

        if ($isReadMode == "1") {
            $ustadzId = $this->get("ustadz_id");

            $query = $this->db->select("*")
                                ->from("tbl_ustadz")
                                ->where("id", $ustadzId)
                                ->get()
                                ->result_array();
        } else {
            if ($search != null) {
                $query = $this->db->select("*")
                                ->from("tbl_ustadz")
                                ->like("id", $search)
                                ->get()
                                ->result_array();
            } else {
                $query = $this->db->select("*")
                                ->from("tbl_ustadz")
                                ->get()
                                ->result_array();
            }
        }

        if ($query) {
            $this->response([
                'status' => 200,
                'message' => 'OK',
                'data' => $query
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => 404,
                'message' => 'Not Found',
                'data' => array()
            ], RestController::HTTP_NOT_FOUND);
        }
    }

    public function index_post() {
        $id = $this->post("id");
        $name = $this->post("name");
        $phone = $this->post("phone");
        $gender = $this->post("gender");
        $email = $this->post("email");
        $address = $this->post("address");
        $password = $this->post("password");

        if ($id == null) {
            $this->response([
                'status' => 406,
                'message' => 'ID cannot be null!'
            ], RestController::HTTP_NOT_ACCEPTABLE);
        } else if ($name == null) {
            $this->response([
                'status' => 406,
                'message' => 'Name cannot be null!'
            ], RestController::HTTP_NOT_ACCEPTABLE);
        } else if ($phone == null) {
            $this->response([
                'status' => 406,
                'message' => 'Phone cannot be null!'
            ], RestController::HTTP_NOT_ACCEPTABLE);
        } else if ($gender == null) {
            $this->response([
                'status' => 406,
                'message' => 'Gender cannot be null!'
            ], RestController::HTTP_NOT_ACCEPTABLE);
        } else if ($email == null) {
            $this->response([
                'status' => 406,
                'message' => 'Email cannot be null!'
            ], RestController::HTTP_NOT_ACCEPTABLE);
        } else if ($address == null) {
            $this->response([
                'status' => 406,
                'message' => 'Address cannot be null!'
            ], RestController::HTTP_NOT_ACCEPTABLE);
        } else if ($password == null) {
            $this->response([
                'status' => 406,
                'message' => 'Password cannot be null!'
            ], RestController::HTTP_NOT_ACCEPTABLE);
        } else {
            $this->db->insert('tbl_ustadz', [
                'id' => $id,
                'name' => $name,
                'phone' => $phone,
                'gender' => $gender,
                'email' => $email,
                'address' => $address,
                'password' => $password
            ]);
            $this->response([
                'status' => 200,
                'message' => 'Successfully registered!'
            ], RestController::HTTP_OK);
        }
    }

    public function index_delete($id) {
        if ($id == null) {
            $this->response([
                'status' => 406,
                'message' => 'Please provide Ustadz ID!'
            ], RestController::HTTP_NOT_ACCEPTABLE);
        } else {
            $this->db->delete('tbl_ustadz', [
                'id' => $id
            ]);

            if ($this->db->affected_rows() > 0) {
                $this->response([
                    'status' => 200,
                    'message' => $id . ' deleted!'
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => 404,
                    'message' => $id . ' isn\'t found!'
                ], RestController::HTTP_NOT_FOUND);
            }
        }
    }
}