<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Mahasiswa extends ResourceController
{
    use ResponseTrait;
    protected $mahasiwamodel;
    public function __construct()
    {
        $this->mahasiwamodel = new MahasiswaModel();
    }
    // all users
    public function index()
    {
        $mahasiswa = $this->mahasiwamodel->orderBy('nim', 'DESC')->findAll();
        if ($mahasiswa) {
            $data = [
                'response' => true,
                'mahasiswa' => $mahasiswa
            ];
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data tidak ditemukan');
        }
    }

    // single user
    public function get($nim = null)
    {
        $mahasiswa = $this->mahasiwamodel->find($nim);
        if ($mahasiswa) {
            $data = [
                'response' => true,
                'mahasiswa' => $mahasiswa
            ];
            if ($data['mahasiswa']) {
                return $this->respond($data);
            }
        } else {
            return $this->failNotFound('Data tidak ditemukan');
        }
    }

    // create
    public function create()
    {
        if ($this->mahasiwamodel->find($this->request->getPost('nim'))) {
            return $this->failResourceExists('NIM telah digunakan');
        } else {
            $this->mahasiwamodel->save([
                'nim' => $this->request->getPost('nim'),
                'nama' => $this->request->getPost('nama'),
                'jurusan' => $this->request->getPost('jurusan'),
                'judul_ta' => $this->request->getPost('judul_ta'),
                'ipk' => $this->request->getPost('ipk')
            ]);

            $response = [
                'error'  => null,
                'messages' => 'Data telah diinput'
            ];

            return $this->respondCreated($response);
        }
    }

    // update
    public function update($nim = null)
    {
        $mahasiswa = $this->mahasiwamodel->find($nim);
        if ($mahasiswa) {
            $this->mahasiwamodel->save([
                'nim' => $nim,
                'nama' => $this->request->getPost('nama'),
                'jurusan' => $this->request->getPost('jurusan'),
                'judul_ta' => $this->request->getPost('judul_ta'),
                'ipk' => $this->request->getPost('ipk')
            ]);

            $response = [
                'error'  => null,
                'messages' => 'Data telah diupdate'
            ];

            return $this->respond($response);
        } else {
            return $this->failNotFound('Data tidak ditemukan');
        }
    }

    public function delete($nim = null)
    {
        if ($this->mahasiwamodel->find($nim)) {
            $this->mahasiwamodel->delete($nim);
            $response = [
                'error'  => null,
                'messages' => 'Data telah dihapus'
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Data tidak ditemukan');
        }
    }
}
