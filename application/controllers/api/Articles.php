<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Articles extends RestController {

    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Digunakan untuk mengambil daftar artikel yang ada.
     * 
     * GET /api/articles
     *   Parameter:
     *   -> read: 1 untuk mode membaca, 0 untuk mode pencarian
     *   -> query: Kueri pencarian artikel (opsional)
     * 
     * @return 
     * error:
     *  -> 200: Artikel ditemukan
     *  -> 404: Artikel tidak ada
     */
    public function index_get()
    {
        $isReadMode = $this->get('read');
        $query = $this->get('query');
        $id = $this->get('article');
        $isUstadzMode = $this->get('ustadz_mode');
        $ustadz_id = $this->get('ustadz_id');
        $like = 0;

        if ($isUstadzMode === "1") {
            if ($ustadz_id === null) {
                $this->response([
                    'status' => 400,
                    'message' => 'Because ustadz mode is true, Ustadz ID cannot be null!'
                ], RestController::HTTP_BAD_REQUEST);
            } else {
                if ($isReadMode == "0") {
                    if ($query === null) {
                        /* $get_db = $this->db->query("SELECT a.id, a.title, a.post_date, a.content, b.name AS ustadz_name
                        FROM tbl_article a
                        INNER JOIN tbl_ustadz b ON a.ustadz_id = b.id
                        ORDER BY post_date DESC")->result(); */
                        $get_db = $this->db->select('a.id, a.title, a.post_date, a.content, a.has_img, a.extension, b.name AS ustadz_name')
                                            ->from('tbl_article a')
                                            ->join('tbl_ustadz b', 'a.ustadz_id = b.id')
                                            ->where('a.ustadz_id', $ustadz_id)
                                            ->order_by('a.post_date', 'desc')
                                            ->get()->result();
                    } else {
                        /* $get_db = $this->db->query("SELECT a.id, a.title, a.post_date, a.content, b.name AS ustadz_name
                        FROM tbl_article a
                        INNER JOIN tbl_ustadz b ON a.ustadz_id = b.id
                        WHERE a.title LIKE \"%$query%\" OR b.name LIKE \"%$query%\" OR a.content LIKE \"%$query%\"
                        ORDER BY post_date DESC")->result(); */
                        $get_db = $this->db->select('a.id, a.title, a.post_date, a.content, a.has_img, a.extension, b.name AS ustadz_name')
                                            ->from('tbl_article a')
                                            ->join('tbl_ustadz b', 'a.ustadz_id = b.id')
                                            ->where('a.ustadz_id', $ustadz_id)
                                            ->like('a.title', $query)
                                            ->or_like('b.name', $query)
                                            ->or_like('a.content', $query)
                                            ->order_by('a.post_date', 'desc')
                                            ->get()->result();
                    }    
                } else if ($isReadMode == "1") {
                    if ($id !== null) {
                        /* $get_db = $this->db->query("SELECT a.id, a.title, a.post_date, a.content, b.name AS ustadz_name
                        FROM tbl_article a
                        INNER JOIN tbl_ustadz b ON a.ustadz_id = b.id
                        WHERE a.id = \"%$query%\"
                        ORDER BY post_date DESC")->result(); */
                        $get_db = $this->db->select('a.id, a.title, a.post_date, a.content, a.has_img, a.extension, b.name AS ustadz_name')
                                            ->from('tbl_article a')
                                            ->join('tbl_ustadz b', 'a.ustadz_id = b.id')
                                            ->where('a.ustadz_id', $ustadz_id)
                                            ->where('a.id', $id)
                                            ->order_by('a.post_date', 'desc')
                                            ->get()->result();
        
                        $like = $this->db->select('article_id')
                                    ->from('tbl_article_likes')
                                    ->where('article_id', $id)
                                    ->get()
                                    ->result_array();
                    }
                }
                
                if ($get_db) {
                    if ($isReadMode == "1") {
                        $this->response([
                            'status' => 200,
                            'message' => 'OK',
                            'data' => $get_db,
                            'likes' => count($like)
                        ], RestController::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => 200,
                            'message' => 'OK',
                            'data' => $get_db
                        ], RestController::HTTP_OK);
                    }
                } else {
                    $this->response([
                        'status' => 404,
                        'message' => 'Not Found',
                        'data' => array()
                    ], RestController::HTTP_NOT_FOUND);
                }
            }
        } else {
            if ($isReadMode == "0") {
                if ($query === null) {
                    /* $get_db = $this->db->query("SELECT a.id, a.title, a.post_date, a.content, b.name AS ustadz_name
                    FROM tbl_article a
                    INNER JOIN tbl_ustadz b ON a.ustadz_id = b.id
                    ORDER BY post_date DESC")->result(); */
                    $get_db = $this->db->select('a.id, a.title, a.post_date, a.content, a.has_img, a.extension, b.name AS ustadz_name')
                                        ->from('tbl_article a')
                                        ->join('tbl_ustadz b', 'a.ustadz_id = b.id')
                                        ->order_by('a.post_date', 'desc')
                                        ->get()->result();
                } else {
                    /* $get_db = $this->db->query("SELECT a.id, a.title, a.post_date, a.content, b.name AS ustadz_name
                    FROM tbl_article a
                    INNER JOIN tbl_ustadz b ON a.ustadz_id = b.id
                    WHERE a.title LIKE \"%$query%\" OR b.name LIKE \"%$query%\" OR a.content LIKE \"%$query%\"
                    ORDER BY post_date DESC")->result(); */
                    $get_db = $this->db->select('a.id, a.title, a.post_date, a.content, a.has_img, a.extension, b.name AS ustadz_name')
                                        ->from('tbl_article a')
                                        ->join('tbl_ustadz b', 'a.ustadz_id = b.id')
                                        ->like('a.title', $query)
                                        ->or_like('b.name', $query)
                                        ->or_like('a.content', $query)
                                        ->order_by('a.post_date', 'desc')
                                        ->get()->result();
                }    
            } else if ($isReadMode == "1") {
                if ($id !== null) {
                    /* $get_db = $this->db->query("SELECT a.id, a.title, a.post_date, a.content, b.name AS ustadz_name
                    FROM tbl_article a
                    INNER JOIN tbl_ustadz b ON a.ustadz_id = b.id
                    WHERE a.id = \"%$query%\"
                    ORDER BY post_date DESC")->result(); */
                    $get_db = $this->db->select('a.id, a.title, a.post_date, a.content, a.has_img, a.extension, b.name AS ustadz_name')
                                        ->from('tbl_article a')
                                        ->join('tbl_ustadz b', 'a.ustadz_id = b.id')
                                        ->where('a.id', $id)
                                        ->order_by('a.post_date', 'desc')
                                        ->get()->result();
    
                    $like = $this->db->select('article_id')
                                ->from('tbl_article_likes')
                                ->where('article_id', $id)
                                ->get()
                                ->result_array();
                }
            }
            
            if ($get_db) {
                if ($isReadMode == "1") {
                    $this->response([
                        'status' => 200,
                        'message' => 'OK',
                        'data' => $get_db,
                        'likes' => count($like)
                    ], RestController::HTTP_OK);
                } else {
                    $this->response([
                        'status' => 200,
                        'message' => 'OK',
                        'data' => $get_db
                    ], RestController::HTTP_OK);
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
     * Digunakan untuk menambah artikel baru.
     * 
     * GET /api/articles
     *   Parameter:
     *   -> title: Judul artikel
     *   -> content: Isi artikel
     *   -> ustadz_id: Ustadz ID yang terdaftar
     * 
     * @return 
     * error:
     *  -> 200: Artikel berhasil ditambahkan
     *  -> 500: Artikel gagal ditambahkan
     *  -> 400: Terdapat field yang kosong
     */
    public function index_post()
    {
        $data = [
            'title' => $this->post('title'),
            'content' => $this->post('content'),
            'ustadz_id' => $this->post('ustadz_id')
        ];
        if ($data['title'] === null) {
            $this->response([
                'status' => 400,
                'message' => 'Title must be defined!'
            ], RestController::HTTP_BAD_REQUEST);
        } else if ($data['content'] === null) {
            $this->response([
                'status' => 400,
                'message' => 'Content must be defined!'
            ], RestController::HTTP_BAD_REQUEST);
        } else if ($data['ustadz_id'] === null) {
            $this->response([
                'status' => 400,
                'message' => 'Ustadz_id must be defined!'
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            $this->db->insert('tbl_article', $data);
            if ($this->db->affected_rows() > 0) {
                $this->response([
                    'status' => 200,
                    'message' => 'Successfully add article!'
                ], RestController::HTTP_OK);
            } else {
                $error = $this->db->error();
                $this->response([
                    'status' => 500,
                    'message' => 'Internal Error: ' . $error
                ], RestController::HTTP_NOT_MODIFIED);
            }
        }
    }

    public function index_put($id)
    {
        $data = [
            'title' => $this->put('title'),
            'content' => $this->put('content')
        ];
        if ($data['title'] === null) {
            $this->response([
                'status' => 400,
                'message' => 'Title must be defined!'
            ], RestController::HTTP_BAD_REQUEST);
        } else if ($data['content'] === null) {
            $this->response([
                'status' => 400,
                'message' => 'Content must be defined!'
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            $this->db->update('tbl_article', $data, ['id' => $id]);
            
            if ($this->db->affected_rows() > 0) {
                $this->response([
                    'status' => 200,
                    'message' => 'Successfully update article!'
                ], RestController::HTTP_OK);
            } else {
                $error = $this->db->error();
                $this->response([
                    'status' => 500,
                    'message' => 'Internal Error: ' . $error
                ], RestController::HTTP_NOT_MODIFIED);
            }
        }
    }

    public function index_delete($id)
    {
        if ($id === null) {
            $this->response([
                'status' => 304,
                'message' => 'Not defined article id!'
            ], RestController::HTTP_NOT_ACCEPTABLE);
        } else {
            $this->db->delete('tbl_article', ['id' => $id]);
            if ($this->db->affected_rows() > 0) {
                $this->response([
                    'status' => 200,
                    'message' => $id . ' is deleted.'
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => 404,
                    'message' => $id . ' not found.'
                ], RestController::HTTP_NOT_FOUND);
            }
        }
    }
}

/* End of file Api.php */
