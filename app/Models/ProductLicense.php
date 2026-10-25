<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLicense extends Model
{
    protected $table = 'product_licenses';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_REVOKED = 'revoked';

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

    public function activations()
    {
        return $this->hasMany(ProductLicenseActivation::class, 'license_id', 'id');
    }

    public function isActive(): bool
    {
        if ($this->status !== self::STATUS_ACTIVE) {
            return false;
        }

        if (!empty($this->expires_at) && $this->expires_at < time()) {
            return false;
        }

        return true;
    }

    public function canActivate(): bool
    {
        if (!$this->isActive()) {
            return false;
        }

        if ($this->max_activations > 0 && $this->activation_count >= $this->max_activations) {
            return false;
        }

        return true;
    }

    public function getRemainingActivationsAttribute(): int
    {
        if ($this->max_activations == 0) {
            return 999;
        }

        return max(0, $this->max_activations - $this->activation_count);
    }
}
