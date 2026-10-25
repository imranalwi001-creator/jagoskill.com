<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLicenseActivation extends Model
{
    protected $table = 'product_license_activations';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];

    public function license()
    {
        return $this->belongsTo(ProductLicense::class, 'license_id', 'id');
    }
}
