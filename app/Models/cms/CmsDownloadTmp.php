<?php

namespace App\Models\cms;

use Illuminate\Database\Eloquent\Model;

class CmsDownloadTmp extends Model
{    
    protected $table = 'cms_download_tmp';
    protected $primaryKey = 'tmp_no';
    
    const CREATED_AT = 'tmp_ctime';
    const UPDATED_AT = null;
    public $timestamps = true;
    
    protected $fillable = [
        'tmp_marketing_name',
        'tmp_prd_model_name',
        'tmp_title',
        'tmp_file_name',
        'tmp_device',
        'tmp_version',
        'tmp_guid',
        'tmp_upgradeguid',
        'tmp_deviceid',
        'tmp_silentInstantparameter',
        'tmp_crc',
        'tmp_releasedate',
        'tmp_os',
        'tmp_type',
        'tmp_category',
        'tmp_other',
        'tmp_packageVersion',
        'tmp_reboot',
        'tmp_source',
        'tmp_osImage',
        'tmp_status',
        'tmp_prd_list_no',
        'tmp_file_category',
        'tmp_description',
    ];
}
