<?php

namespace App\Models\cms;

use Illuminate\Database\Eloquent\Model;

class CmsDownloados extends Model
{    
    protected $table = 'cms_downloados';
    protected $primaryKey = 'os_id';
    
    public $timestamps = false;
    
}
