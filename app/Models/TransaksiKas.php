<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransaksiKas extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'transaksi_kas';
    protected $primaryKey = 'kode_transaksi_kas';
    protected $dates = ['deleted_at'];

}
