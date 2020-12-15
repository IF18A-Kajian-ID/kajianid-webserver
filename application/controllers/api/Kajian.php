<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Kajian extends RestController {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('Characters', 'chars');
    }
    

    /**
     * Digunakan untuk mengambil daftar kajian yang ada.
     * 
     * GET /api/articles
     *   Parameter:
     *   -> read: 1 untuk mode membaca, 0 untuk mode pencarian
     *   -> q: Kueri pencarian artikel (opsional)
     * 
     * @return 
     * error:
     *  -> 200: Artikel ditemukan
     *  -> 404: Artikel tidak ada
     */
    public function index_get()
    {
        $isReadMode = $this->get('read');
        $isUstadzMode = $this->get('ustadz_mode');
        $ustadz_id = $this->get('ustadz_id');
        $id = $this->get('kajian');
        $query = $this->get('q');
        if ($isUstadzMode == "1") {
            if ($ustadz_id === null) {
                $this->response([
                    'status' => 400,
                    'message' => 'Because ustadz mode is true, Ustadz ID cannot be null!'
                ], RestController::HTTP_BAD_REQUEST);
            } else {
                if ($isReadMode !== null) {
                    if ($isReadMode === "0") {
                        if ($query === null) {
                            $get_db = $this->db->select('a.id, a.kajian_title, b.name AS ustadz_name, a.mosque_id,
                                                        c.name AS mosque_name, a.address, a.place, a.youtube_link,
                                                        a.description, a.img_resource, a.date_announce, a.date_due')
                                                ->from('tbl_info a')
                                                ->join('tbl_ustadz b', 'a.ustadz_id = b.id', 'inner')
                                                ->join('tbl_mosque c', 'a.mosque_id = c.id', 'inner')
                                                ->where('a.ustadz_id', $ustadz_id)
                                                ->get()
                                                ->result_array();
                        } else {
                            $get_db = $this->db->select('a.id, a.kajian_title, b.name AS ustadz_name, a.mosque_id,
                                                        c.name AS mosque_name, a.address, a.place, a.youtube_link,
                                                        a.description, a.img_resource, a.date_announce, a.date_due')
                                                ->from('tbl_info a')
                                                ->join('tbl_ustadz b', 'a.ustadz_id = b.id', 'inner')
                                                ->join('tbl_mosque c', 'a.mosque_id = c.id', 'inner')
                                                ->where('a.ustadz_id', $ustadz_id)
                                                ->like('a.kajian_title', $query)
                                                ->or_like('b.name', $query)
                                                ->or_like('a.address', $query)
                                                ->or_like('c.name', $query)
                                                ->get()
                                                ->result_array();
                        }
                    } else if ($isReadMode === "1") {
                        $get_db = $this->db->select('a.id, a.kajian_title, b.name AS ustadz_name, a.mosque_id,
                                                        c.name AS mosque_name, a.address, a.place, a.youtube_link,
                                                        a.description, a.img_resource, a.date_announce, a.date_due')
                                                ->from('tbl_info a')
                                                ->join('tbl_ustadz b', 'a.ustadz_id = b.id', 'inner')
                                                ->join('tbl_mosque c', 'a.mosque_id = c.id', 'inner')
                                                ->where('a.ustadz_id', $ustadz_id)
                                                ->where('a.id', $id)
                                                ->get()
                                                ->result_array();
                    }
        
                    if ($get_db) {
                        $this->response([
                            'status' => 200,
                            'message' => 'OK',
                            'data' => $get_db
                        ], RestController::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => 404,
                            'message' => 'Not Found',
                            'data' => array()
                        ], RestController::HTTP_NOT_FOUND);
                    }
                }
            } 
        } else {
            if ($isReadMode !== null) {
                if ($isReadMode === "0") {
                    if ($query === null) {
                        $get_db = $this->db->select('a.id, a.kajian_title, b.name AS ustadz_name, a.mosque_id,
                                                    c.name AS mosque_name, a.address, a.place, a.youtube_link,
                                                    a.description, a.img_resource, a.date_announce, a.date_due')
                                            ->from('tbl_info a')
                                            ->join('tbl_ustadz b', 'a.ustadz_id = b.id', 'inner')
                                            ->join('tbl_mosque c', 'a.mosque_id = c.id', 'inner')
                                            ->get()
                                            ->result_array();
                    } else {
                        $get_db = $this->db->select('a.id, a.kajian_title, b.name AS ustadz_name, a.mosque_id,
                                                    c.name AS mosque_name, a.address, a.place, a.youtube_link,
                                                    a.description, a.img_resource, a.date_announce, a.date_due')
                                            ->from('tbl_info a')
                                            ->join('tbl_ustadz b', 'a.ustadz_id = b.id', 'inner')
                                            ->join('tbl_mosque c', 'a.mosque_id = c.id', 'inner')
                                            ->where('a.kajian_title', $query)
                                            ->or_where('b.name', $query)
                                            ->or_where('a.address', $query)
                                            ->or_where('c.name', $query)
                                            ->get()
                                            ->result_array();
                    }
                } else if ($isReadMode === "1") {
                    $get_db = $this->db->select('a.id, a.kajian_title, b.name AS ustadz_name, a.mosque_id,
                                                    c.name AS mosque_name, a.address, a.place, a.youtube_link,
                                                    a.description, a.img_resource, a.date_announce, a.date_due')
                                            ->from('tbl_info a')
                                            ->join('tbl_ustadz b', 'a.ustadz_id = b.id', 'inner')
                                            ->join('tbl_mosque c', 'a.mosque_id = c.id', 'inner')
                                            ->where('a.id', $id)
                                            ->get()
                                            ->result_array();
                }
    
                if ($get_db) {
                    $this->response([
                        'status' => 200,
                        'message' => 'OK',
                        'data' => $get_db
                    ], RestController::HTTP_OK);
                } else {
                    $this->response([
                        'status' => 404,
                        'message' => 'Not Found',
                        'data' => array()
                    ], RestController::HTTP_NOT_FOUND);
                }
            } else {
                $this->response([
                    'status' => 404,
                    'message' => 'Not Found',
                    'data' => array()
                ], RestController::HTTP_NOT_FOUND);
            }
        }
    }

    /**
     * Digunakan untuk mengambil daftar kajian yang ada.
     * 
     * GET /api/articles
     *   Parameter:
     *   title*
     *   ustadz_id*
     *   mosque_id*
     *   address
     *   place*
     *   yt_url
     *   desc
     *   due*
     *   file
     * 
     * @return 
     * error:
     *  -> 200: Artikel ditemukan
     *  -> 404: Artikel tidak ada
     */
    public function index_post()
    {
        $data = [
            'kajian_title' => $this->post('title'), // *
            'ustadz_id' => $this->post('ustadz_id'), // *
            'mosque_id' => $this->post('mosque_id'), // *
            'address' => $this->post('address'),
            'place' => $this->post('place'), // enum('Video', 'Di Tempat', 'Live Streaming')
            'youtube_link' => $this->post('yt_url'),
            'description' => $this->post('desc'),
            'img_resource' => null,
            'img_filename' => null,
            'date_due' => $this->post('due') // *
        ];

        if ($data['kajian_title'] === null) {
            $this->response([
                'status' => 400,
                'message' => 'Title of Kajian must be not null!'
            ], RestController::HTTP_BAD_REQUEST);
        } else if ($data['ustadz_id'] === null) {
            $this->response([
                'status' => 400,
                'message' => 'Ustadz ID must be not null!'
            ], RestController::HTTP_BAD_REQUEST);
        } else if ($data['mosque_id'] === null) {
            $this->response([
                'status' => 400,
                'message' => 'Mosque ID must be not null!'
            ], RestController::HTTP_BAD_REQUEST);
        } else if ($data['place'] === null) {
            $this->response([
                'status' => 400,
                'message' => 'Place of Kajian must be not null!'
            ], RestController::HTTP_BAD_REQUEST);
        } else if ($data['date_due'] === null) {
            $this->response([
                'status' => 400,
                'message' => 'Date Due must be not null!'
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            if (!$this->chars->isValidDate($data['date_due'], "Y-m-d H:i")) {
                $this->response([
                    'status' => 400,
                    'message' => $data['date_due'] . ' is not a valid Date format (yyyy-MM-dd HH:mm)!'
                ], RestController::HTTP_BAD_REQUEST);
            } else {
                if (($data['place'] == "Video") || ($data['place'] == "Live Streaming")) {
                    $post_domain = parse_url($data['youtube_link']);
                    if (($post_domain['host'] === 'youtube.com') || ($post_domain['host'] === 'www.youtube.com')) {
                        parse_str($post_domain["query"], $params);
                        $data['img_resource'] = "https://img.youtube.com/vi/" . $params['v'] . "/mqdefault.jpg";

                        $this->db->insert('tbl_info', $data);
                        if ($this->db->affected_rows() == 0) {
                            $error = $this->db->error();
                            $this->response([
                                'status' => 500,
                                'message' => 'Internal Error: ' . $error
                            ], RestController::HTTP_NOT_MODIFIED);
                        } else {
                            $this->response([
                                'status' => 200,
                                'message' => $data['kajian_title'] . ' has been added!'
                            ], RestController::HTTP_OK);
                        }
                    } else {
                        $this->response([
                            'status' => 406,
                            'message' => 'We\'re sorry, we currently only support the URL that coming from youtube.com only (https://www.youtube.com/watch?v=...)!'
                        ], RestController::HTTP_NOT_ACCEPTABLE);
                    }
                } else if ($data['place'] == "Di Tempat") {

                    $createFile = $this->chars->createRandomChars(15, false);
                    $this->load->library('upload', array(
                        'upload_path' => "assets/kajian",
                        'file_name' => $createFile,
                        'allowed_types' => 'jpg|png|jpeg',
                        'overwrite' => TRUE
                    ));
                    if ($this->upload->do_upload('file')) {
                        $upload_data = $this->upload->data();
                        $data['img_resource'] = base_url() . 'assets/kajian/' . $upload_data['file_name'];
                        $data['img_filename'] = $upload_data['file_name'];
                    } 

                    $this->db->insert('tbl_info', $data);
                        if ($this->db->affected_rows() == 0) {
                            $error = $this->db->error();
                            $this->response([
                                'status' => 500,
                                'message' => 'Internal Error: ' . $error
                            ], RestController::HTTP_NOT_MODIFIED);
                        } else {
                            $this->response([
                                'status' => 200,
                                'message' => $data['kajian_title'] . ' has been added!'
                            ], RestController::HTTP_OK);
                        }
                } else {
                    $this->response([
                        'status' => 400,
                        'message' => 'Place of Kajian is not recognized!'
                    ], RestController::HTTP_BAD_REQUEST);
                }
            }
        }
    }

    public function index_delete($id)
    {
        if ($id === null) {
            $this->response(array(
                'message' => "Please provide an Kajian ID!"
            ), RestController::HTTP_BAD_REQUEST);
        } else {
            $query = $this->db->select('img_filename')
                                ->from('tbl_info')
                                ->where('id', $id)
                                ->get();
            $query_num = $query->num_rows();
            if ($query_num != 0) {
                $file = $query->row();
                if ($file->img_filename !== null) {
                    unlink("assets/kajian/" . $file->img_filename);
                }
                $this->db->delete('tbl_info', array(
                    'id' => $id
                ));
                $this->response(array(
                    'message' => "$id deleted successfully!"
                ), RestController::HTTP_OK);
            } else {
                $this->response(array(
                    'message' => "Kajian ID $id isn't found!"
                ), RestController::HTTP_NOT_FOUND);
            }
        }
    }

    public function index_put($id)
    {
        if ($id === null) {
            $this->response(array(
                'message' => "Please provide an Kajian ID!"
            ), RestController::HTTP_BAD_REQUEST);
        } else {
            $data = array(
                'kajian_title' => $this->put('title'), // *
                'ustadz_id' => $this->put('ustadz_id'), // *
                'mosque_id' => $this->put('mosque_id'), // *
                'address' => $this->put('address'),
                'place' => $this->put('place'), // enum('Video', 'Di Tempat', 'Live Streaming')
                'youtube_link' => $this->put('yt_url'),
                'description' => $this->put('desc'),
                'date_due' => $this->put('due') // *
            );

            if ($data['kajian_title'] === null) {
                $this->response([
                    'status' => 400,
                    'message' => 'Title of Kajian must be not null!'
                ], RestController::HTTP_BAD_REQUEST);
            } else if ($data['ustadz_id'] === null) {
                $this->response([
                    'status' => 400,
                    'message' => 'Ustadz ID must be not null!'
                ], RestController::HTTP_BAD_REQUEST);
            } else if ($data['mosque_id'] === null) {
                $this->response([
                    'status' => 400,
                    'message' => 'Mosque ID must be not null!'
                ], RestController::HTTP_BAD_REQUEST);
            } else if ($data['place'] === null) {
                $this->response([
                    'status' => 400,
                    'message' => 'Place of Kajian must be not null!'
                ], RestController::HTTP_BAD_REQUEST);
            } else if ($data['date_due'] === null) {
                $this->response([
                    'status' => 400,
                    'message' => 'Date Due must be not null!'
                ], RestController::HTTP_BAD_REQUEST);
            } else {
                if (!$this->chars->isValidDate($data['date_due'], "Y-m-d H:i")) {
                    $this->response([
                        'status' => 400,
                        'message' => $data['date_due'] . ' is not a valid Date format (yyyy-MM-dd HH:mm)!'
                    ], RestController::HTTP_BAD_REQUEST);
                } else {
                    if (($data['place'] == "Video") || ($data['place'] == "Live Streaming")) {
                        $post_domain = parse_url($data['youtube_link']);
                        if (($post_domain['host'] === 'youtube.com') || ($post_domain['host'] === 'www.youtube.com')) {
                            parse_str($post_domain["query"], $params);
                            $data['img_resource'] = "https://img.youtube.com/vi/" . $params['v'] . "/mqdefault.jpg";
    
                            $this->db->update('tbl_info', $data, ['id' => $id]);
                            if ($this->db->affected_rows() == 0) {
                                $error = $this->db->error();
                                $this->response([
                                    'status' => 500,
                                    'message' => 'Internal Error: ' . $error
                                ], RestController::HTTP_NOT_MODIFIED);
                            } else {
                                $this->response([
                                    'status' => 200,
                                    'message' => $data['kajian_title'] . ' has been modified!'
                                ], RestController::HTTP_OK);
                            }
                        } else {
                            $this->response([
                                'status' => 406,
                                'message' => 'We\'re sorry, we currently only support the URL that coming from youtube.com only (https://www.youtube.com/watch?v=...)!'
                            ], RestController::HTTP_NOT_ACCEPTABLE);
                        }
                    } else if ($data['place'] == "Di Tempat") {
                        $this->db->update('tbl_info', $data, ['id' => $id]);
                            if ($this->db->affected_rows() == 0) {
                                $error = $this->db->error();
                                $this->response([
                                    'status' => 500,
                                    'message' => 'Internal Error: ' . $error
                                ], RestController::HTTP_NOT_MODIFIED);
                            } else {
                                $this->response([
                                    'status' => 200,
                                    'message' => $data['kajian_title'] . ' has been modified!'
                                ], RestController::HTTP_OK);
                            }
                    } else {
                        $this->response([
                            'status' => 400,
                            'message' => 'Place of Kajian is not recognized!'
                        ], RestController::HTTP_BAD_REQUEST);
                    }
                }
            }
        }
    }
}

/* End of file Kajian.php */
