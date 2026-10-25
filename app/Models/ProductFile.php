<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class ProductFile extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'product_files';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];

    static $Active = 'active';
    static $Inactive = 'inactive';
    static $fileStatus = ['active', 'inactive'];

    public $translatedAttributes = ['title', 'description'];

    public function getTitleAttribute()
    {
        return getTranslateAttributeValue($this, 'title');
    }

    public function getDescriptionAttribute()
    {
        return getTranslateAttributeValue($this, 'description');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function downloads()
    {
        return $this->hasMany(ProductDownloadLog::class, 'product_file_id', 'id');
    }

    public function isExternalLink(): bool
    {
        return ($this->access_type === 'external_link' && !empty($this->external_link));
    }

    public function getRemainingDownloads($userId, $orderId = null): int
    {
        if (empty($this->download_limit) || $this->download_limit == 0) {
            return -1; // Unlimited
        }

        $query = $this->downloads()->where('user_id', $userId);
        if (!empty($orderId)) {
            $query->where('product_order_id', $orderId);
        }

        $used = $query->count();
        return max(0, (int)$this->download_limit - $used);
    }

    public function getDownloadUrl()
    {
        if ($this->isExternalLink()) {
            return $this->external_link;
        }

        return '/panel/store/products/files/' . $this->id . '/download';
    }

    public function getOnlineViewUrl()
    {
        return url($this->path);
    }

    public function getVolume()
    {
        return $this->volume . ' MB';
    }

    public function getIconXByType($type = null)
    {
        $icon = 'document';

        if (empty($type)) {
            $type = $this->file_type;
        }

        // 'pdf', 'powerpoint', 'sound', 'video', 'image', 'archive', 'document', 'project'
        if (!empty($type)) {
            if (in_array($type, ['pdf', 'powerpoint', 'document'])) {
                $icon = 'document-text';
            } else if (in_array($type, ['sound'])) {
                $icon = 'music-play';
            } else if (in_array($type, ['video'])) {
                $icon = 'video-vertical';
            } else if (in_array($type, ['image'])) {
                $icon = 'image';
            } else if (in_array($type, ['archive'])) {
                $icon = 'archive-book';
            }
        }

        return $icon;
    }

}
