<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';
    protected $guarded = []; //blacklist
    protected $primaryKey = 'kode_guru';
    public $incrementing = false;
    protected $keyType = 'string';
}
