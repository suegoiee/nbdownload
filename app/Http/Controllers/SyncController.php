<?php

namespace App\Http\Controllers;

use App\Jobs\CreateLog;
use App\Models\cms\CmsLog;
use App\Models\cms\CmsDownloadTmp;
use Illuminate\Http\Request;

class SyncController extends Controller
{
    
    public function sync(Request $request)
    {
        $url = 'http://rdsys-opk:8080/getjsonmodel.aspx';
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_PORT, 8080 );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_POST, false );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, [ 'Content-Type: application/json' ] );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        $response = curl_exec( $ch );
        curl_close( $ch );

        $response = json_decode($response);
        $model_marketing_recoeds = $response->ModelMarketingRecord;
        $time_start = time();
        for ( $i = 0; $i < count($model_marketing_recoeds); $i++ )
        // for ( $i = count($model_marketing_recoeds)-1; $i > 0; $i--)
        {
            $model_market = $model_marketing_recoeds[$i]->model . ';' . $model_marketing_recoeds[$i]->marketing;
            $check = ( in_array( trim( $model_market ), config('sync.exclude') ) ) ? true : false;
            if ( !$check )
            {
                $url = 'http://rdsys-opk:8080/getjsonmarketing.aspx?Source='.$model_marketing_recoeds[$i]->source.'&Model='.urlencode( $model_marketing_recoeds[$i]->model ).'&Marketing='.urlencode( $model_marketing_recoeds[$i]->marketing );
                $ch = curl_init();
                curl_setopt( $ch, CURLOPT_PORT, 8080 );
                curl_setopt( $ch, CURLOPT_URL, $url );
                curl_setopt( $ch, CURLOPT_POST, false );
                curl_setopt( $ch, CURLOPT_HTTPHEADER, [ 'Content-Type: application/json' ] );
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
                $response = curl_exec( $ch );
                curl_close( $ch );
                $software_records = json_decode($response)->SoftwareRecord;
                if ( isset( $software_records ) && !empty( $software_records ) )
                {
                    foreach( $software_records as $software_record )
                    {
                        $file_root = str_replace( '\\', '/', $software_record->file );
                        $path = $model_marketing_recoeds[$i]->source == 'MSI' ? [ '//rdsys-opk/ADKTools', '//NB-BIOS/ADKTools' ] : [ '//rdsys-opk/MSIK_ADKTools' ];
                        $tmp_file_name = str_replace( $path, '', $file_root );                    

                        //ims status
                        strpos( $software_record->version, 'IMS') === false ? $status = 2 : $status = 0;
                        
                        
                        $cms_download_tmp = CmsDownloadTmp::create([
                            'tmp_marketing_name' => $model_marketing_recoeds[$i]->marketing,
                            'tmp_prd_model_name' => $model_marketing_recoeds[$i]->model,
                            'tmp_title' => $software_record->title,
                            'tmp_file_name' => $tmp_file_name,
                            'tmp_device' => $software_record->device,
                            'tmp_version' => $software_record->version,
                            'tmp_guid' => $software_record->guid,
                            'tmp_upgradeguid' => $software_record->upgradeGuid,
                            'tmp_deviceid' => $software_record->deviceID,
                            'tmp_silentInstantparameter' => $software_record->silentInstantParameter,
                            'tmp_crc' => $software_record->crc,
                            'tmp_releasedate' => $software_record->releaseDate,
                            'tmp_os' => $software_record->os,
                            'tmp_type' => $software_record->type,
                            'tmp_category' => $software_record->category,
                            'tmp_other' => $software_record->other,
                            'tmp_packageVersion' => $software_record->packageVersion,
                            'tmp_reboot' => $software_record->reboot,
                            'tmp_source' => $model_marketing_recoeds[$i]->source,
                            'tmp_osImage' => $software_record->osImage,
                            'tmp_status' => $status,
                            'tmp_prd_list_no' => '0',
                            'tmp_file_category' => '',
                            'tmp_description' => ''
                        ]);
                    }
                }
                else
                {
                    // Some message
                }
            }
            $end_time = time()-$time_start;
            $count = $i+1;
            $log= new \stdClass();
            $log->log_action = 'sync '.$count.'th time of '.count($model_marketing_recoeds). ' recoeds. '.$end_time.' seconds used';
            $log->log_ip = $request->ip();
            $this->dispatchNow(CreateLog::fromRequest($log));
        }

        echo 'Sync data successfully!';
    }
}
