<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Credential extends RestController {

    public function index_get()
    {
        $this->response([
            'status' => 404,
            'message' => 'Request Not Found!'
        ], RestController::HTTP_NOT_FOUND);
    }

    public function index_post()
    {
        $data = array(
            'id' => $this->post('username'),
            'password' => $this->post('password')
        );
        if ($data['id'] === null || $data['password'] === null) {
            $this->response([
                'status' => 401,
                'message' => 'Username/Password is required!'
            ], RestController::HTTP_UNAUTHORIZED);
        } else {
            $find = $this->db->select('*')
                            ->from('tbl_ustadz')
                            ->where('id', $data['id'])
                            ->where('password', $data['password'])
                            ->get();
            if ($find->num_rows() > 0) {
                $user = $find->row();
                $this->response([
                    'status' => 200,
                    'message' => 'Username/Password is registered!',
                    'username' => $user->name
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => 403,
                    'message' => 'Username/Password is wrong!'
                ], RestController::HTTP_FORBIDDEN);
            }
        }
    }

    public function index_put()
    {
        $dataReceived = array (
            'username' => $this->put('username'),
            'oldPass' => $this->put('old_pass'),
            'newPass' => $this->put('new_pass')
        );

        if ($dataReceived['username'] == null || $dataReceived['oldPass'] == null || $dataReceived['newPass'] == null) {
            $this->response(array(
                'message' => "Please provide username, old_pass, and new_pass!!"
            ), RestController::HTTP_BAD_REQUEST); // 400
        } else {
            $find = $this->db->select("id, password")
                            ->from('tbl_ustadz')
                            ->where('id', $dataReceived['username'])
                            ->get();
            if ($find->num_rows() == 0) {
                $this->response(array(
                    'message' => $dataReceived['username'] . " is not found!"
                ), RestController::HTTP_NOT_FOUND); // 404
            } else {
                $founded = $find->row();
                if ($dataReceived['oldPass'] !== $founded->password) {
                    $this->response(array(
                        'message' => "Wrong password!"
                    ), RestController::HTTP_NOT_ACCEPTABLE); // 406
                } else {
                    $data = array(
                        'password' => $dataReceived['newPass']
                    );
                    $this->db->update('tbl_ustadz', $data, ['id' => $dataReceived['username']]);
                    $this->response(array(
                        'message' => "Successfully change password!"
                    ), RestController::HTTP_OK);
                }
            }
        }
    }

}

/* End of file Credential.php */
