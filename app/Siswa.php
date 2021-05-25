<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    public $table = 'siswa';
    protected $guarded = []; //blacklist
    protected $primaryKey = 'NIS';
    public $incrementing = false;
    protected $keyType = 'string';
    use SoftDeletes;
}
