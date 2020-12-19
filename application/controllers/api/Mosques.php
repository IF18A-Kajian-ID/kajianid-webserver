<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Mosques extends RestController {

    public function index_get(String $mode = 'user')
    {
        $query = $this->get('q');
        $id = $this->get('id');
        if ($mode === 'path') {
            if ($query !== null) {
                $get_db = $this->db->select("*")
                                    ->from("tbl_mosque")
                                    ->where("lat_lng", $query)
                                    ->get();
            } else {
                $get_db = $this->db->select("*")
                                    ->from("tbl_mosque")
                                    ->where("lat_lng", 'nul')
                                    ->get();
            }

            $this->response(array(
                'status' => 200,
                'count' => $get_db->num_rows(),
                'data' => $get_db->result()
            ), RestController::HTTP_OK);
        } else if ($mode === 'user') {
            if ($query !== null) {
                $get_db = $this->db->select('*')
                                    ->from('tbl_mosque')
                                    ->like('name', $query)
                                    ->get();
            } else if ($id !== null) {
                $get_db = $this->db->select('*')
                                    ->from('tbl_mosque')
                                    ->where('id', $id)
                                    ->get();
            } else {
                $get_db = $this->db->select('*')
                                    ->from('tbl_mosque')
                                    ->get();
            }

            $this->response(array(
                'status' => 200,
                'count' => $get_db->num_rows(),
                'data' => $get_db->result()
            ), RestController::HTTP_OK);
        } else if ($mode === 'ustadz') {
            $ustadz_id = $this->get('ustadz_id');
            if ($ustadz_id !== null) {
                if ($query !== null) {
                    $get_db = $this->db->select('a.mosque_id, b.name, b.lat_lng, b.address, a.ustadz_id, a.timestamp')
                                        ->from('tbl_mosque_ustadz a')
                                        ->join('tbl_mosque b', 'a.mosque_id = b.id', 'inner')
                                        ->where('a.ustadz_id', $ustadz_id)
                                        ->like('name', $query)
                                        ->get();
                } else if ($id !== null) {
                    $get_db = $this->db->select('a.mosque_id, b.name, b.lat_lng, b.address, a.ustadz_id, a.timestamp')
                                        ->from('tbl_mosque_ustadz a')
                                        ->join('tbl_mosque b', 'a.mosque_id = b.id', 'inner')
                                        ->where('a.ustadz_id', $ustadz_id)
                                        ->where('a.mosque_id', $id)
                                        ->get();
                } else {
                    $get_db = $this->db->select('a.mosque_id, b.name, b.lat_lng, b.address, a.ustadz_id, a.timestamp')
                                        ->from('tbl_mosque_ustadz a')
                                        ->join('tbl_mosque b', 'a.mosque_id = b.id', 'inner')
                                        ->where('a.ustadz_id', $ustadz_id)
                                        ->get();
                }
    
                $this->response(array(
                    'status' => 200,
                    'count' => $get_db->num_rows(),
                    'data' => $get_db->result()
                ), RestController::HTTP_OK);
            } else {
                $this->response(array(
                    'status' => 401,
                    'count' => 0,
                    'data' => [],
                ), RestController::HTTP_UNAUTHORIZED);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'mosque_id' => $this->post('id'),
            'ustadz_id' => $this->post('ustadz_id')
        ];

        if ($data['mosque_id'] === null) {
            $this->response([
                'status' => 406,
                'message' => 'Mosque ID cannot be null!'
            ], RestController::HTTP_NOT_ACCEPTABLE);
        } else if ($data['ustadz_id'] === null) {
            $this->response([
                'status' => 406,
                'message' => 'Ustadz ID cannot be null!'
            ], RestController::HTTP_NOT_ACCEPTABLE);
        } else {
            $get_mosque_num = $this->db->select('id')->from('tbl_mosque')->where('id', $data['mosque_id'])->get()->num_rows();
            $get_ustadz_num = $this->db->select('id')->from('tbl_ustadz')->where('id', $data['ustadz_id'])->get()->num_rows();

            if ($get_mosque_num <= 0) {
                $this->response([
                    'status' => 404,
                    'message' => 'Mosque ID isn\'t registered!'
                ], RestController::HTTP_NOT_FOUND);
            } else if ($get_ustadz_num <= 0) {
                $this->response([
                    'status' => 404,
                    'message' => 'Ustadz ID isn\'t registered!'
                ], RestController::HTTP_NOT_FOUND);
            } else {
                $find_dup = $this->db->select('*')
                                    ->from('tbl_mosque_ustadz')
                                    ->where('mosque_id', $data['mosque_id'])
                                    ->where('ustadz_id', $data['ustadz_id'])
                                    ->get()->num_rows();
                if ($find_dup >= 1) {
                    $this->response([
                        'status' => 304,
                        'message' => 'Mosque already registered on Ustadz ID ' . $data['ustadz_id'] . ', no data added!'
                    ], RestController::HTTP_NOT_MODIFIED);
                } else {
                    $this->db->insert('tbl_mosque_ustadz', $data);
                    $this->response([
                        'status' => 200,
                        'message' => 'Successfully registered!'
                    ], RestController::HTTP_OK);
                }
            }
        }
    }

    // DELETE /api/mosques/<mosque_id>/<ustadz_id>
    public function index_delete($id, $ustadz_id)
    {
        if (($id === null) || ($ustadz_id === null)) {
            $this->response([
                'status' => 406,
                'message' => 'Please provide both Mosque ID and Ustadz ID!'
            ], RestController::HTTP_NOT_ACCEPTABLE);
        } else {
            $this->db->delete('tbl_mosque_ustadz', [
                'mosque_id' => $id,
                'ustadz_id' => $ustadz_id
            ]);

            if ($this->db->affected_rows() > 0) {
                $this->response([
                    'status' => 200,
                    'message' => $id . ' deleted from ' . $ustadz_id . '!'
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => 404,
                    'message' => $id . ' isn\'t found on ' . $ustadz_id . '\'s account!'
                ], RestController::HTTP_NOT_FOUND);
            }
        }
    }
}

/* End of file Mosques.php */
