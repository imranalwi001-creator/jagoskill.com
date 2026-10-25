<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDownloadLog extends Model
{
    protected $table = 'product_download_logs';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];

    public function file()
    {
        return $this->belongsTo(ProductFile::class, 'product_file_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(ProductOrder::class, 'product_order_id', 'id');
    }
}
