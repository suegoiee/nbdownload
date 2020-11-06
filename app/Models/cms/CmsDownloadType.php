<?php

namespace App\Models\cms;

use Illuminate\Database\Eloquent\Model;

class CmsDownloadType extends Model
{    
    protected $table = 'cms_downloadtype';
    protected $primaryKey = 'type_id';
    
    const CREATED_AT = 'type_create';
    const UPDATED_AT = 'type_modify';
    public $timestamps = true;
    
}
