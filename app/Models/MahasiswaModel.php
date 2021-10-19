<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    // ...
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['nim', 'nama', 'jurusan', 'judul_ta', 'ipk'];
}
