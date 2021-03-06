<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    public $table = 'guru';
    protected $guarded = []; //blacklist
    protected $primaryKey = 'kode_guru';
    public $incrementing = false;
    protected $keyType = 'string';
    use SoftDeletes;
}
