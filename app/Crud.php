<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crud extends Model
{
    protected $table = 'crud';
    protected $primaryKey = 'id';
    protected $fillable = ['judul', 'slug_judul', 'isi'];
    public $timestamps = false;
}
