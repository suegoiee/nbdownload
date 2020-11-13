<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Jobs\CreateLog;
use App\Models\cms\CmsLog;
use App\Models\cms\CmsDownloadTmp;
use App\Models\cms\CmsDownloadType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class OnlineHandShakeController extends Controller
{    
    public function confirmDownload(Request $request)
    {
        if($request->action == 'Approve'){
            if ( empty( $request->tmp_crc ) ) {
                return redirect()->back();
            }
            if ( empty( $request->tmp_version ) ){
                return redirect()->back();
            }
            





            $tmp_file_path_explode = explode( '/', $request->tmp_file_name );
            $file_name = end( $tmp_file_path_explode );
            $file_extension = pathinfo( $file_name, PATHINFO_EXTENSION );
            $file_base_name = basename( $file_name, "." . $file_extension );
            $file_rename = ( ( $request->tmp_file_category ) ? ( $request->tmp_file_category . '_' ) : '' ) . $file_base_name . '_' . $request->tmp_version. '_' . $request->tmp_crc . '.' . $file_extension;
            if ( !empty( $request->tmp_file_category ) ) $file_rename = $request->tmp_device . '_' . $file_rename;

            $path = ( $request->tmp_source == 'MSI') ? '/mnt/rdfile' : '/mnt/rdfilek';

            switch ( $request->tmp_category )
            {
                case 'Driver':
                case 'Driver and Application':
                    if ( empty( $request->tmp_file_category ) ) return [ 'status' => 'error', 'message' => 'File folder is empty.' ];
                    if ( empty( $request->tmp_guid ) ) return [ 'status' => 'error', 'message' => 'Guid is empty.' ];
                    if ( empty( $request->tmp_upgradeguid ) ) return [ 'status' => 'error', 'message' => 'Upgrade Guid is empty.' ];
                    if ( empty( $request->tmp_silentInstantparameter ) ) return [ 'status' => 'error', 'message' => 'Silent Install Parameter is empty.' ];
                    if(strpos($request->tmp_file_name,'www.microsoft.com') !== FALSE){
                        $file_path_name = $request->tmp_file_name;
                    }
                    else{
                        $file_path_name = $request->tmp_file_category . '/' . $file_rename;
                        $file_path = '/downloads/nb_drivers/' . $file_path_name;
                        if ( is_file( $file_path ) ) return [ 'status' => 'error', 'message' => 'Server already have a same file, please reject this sync data!'];

                        $copy_path = $path . $request->tmp_file_name;
                        $file_size = ( file_exists( $copy_path ) ) ? filesize( $copy_path ) : 0;
                        if ( $file_size == 0 ) return [ 'status' => 'error', 'message' => 'File size is null!<br>' . $copy_path ];
                        copy( $copy_path, $file_path );
                        $action = 'Driver/Driver and Application copy from '.$copy_path. ' to '.$file_path.'.';
                    }
                    break;
                case 'Application':
                    if ( empty( $request->tmp_guid ) ) return [ 'status' => 'error', 'message' => 'Guid is empty.' ];
                    if ( empty( $request->tmp_upgradeguid ) ) return [ 'status' => 'error', 'message' => 'Upgrade Guid is empty.' ];
                    if ( empty( $request->tmp_silentInstantparameter ) ) return [ 'status' => 'error', 'message' => 'Silent Install Parameter is empty.' ];

                    if(strpos($request->tmp_file_name,'www.microsoft.com') !== FALSE){
                        $file_path_name = $request->tmp_file_name;
                    }
                    else{
                        $file_path_name = 'nb/' . $file_rename;
                        $file_path = '/downloads/uti_exe/' . $file_path_name;
                        if ( is_file( $file_path ) ) return [ 'status' => 'error', 'message' => 'Server already have a same file, please reject this sync data!' ];

                        $file_size = 0;
                        $copy_path = $path . $request->tmp_file_name;
                        $file_size = ( file_exists( $copy_path ) ) ? filesize( $copy_path ) : 0;
                        if ( $file_size == 0 ) return [ 'status' => 'error', 'message' => 'File size is null!<br>' . $copy_path ];

                        copy( $copy_path, $file_path );
                        $action = 'Application copy from '.$copy_path. ' to '.$file_path.'.';
                    }
                    break;
                case 'BIOS':
                    $file_path_name = 'nb/' . $file_rename;
                    $file_size = ( file_exists( '/downloads/bos_exe/' . $file_path_name ) ) ? filesize( '/downloads/bos_exe/' . $file_path_name ) : 0;
                    if ( $file_size == 0 ) {
                        return [ 'status' => 'error', 'message' => 'File size is null!' ];
                    }
                    $action = 'BIOS '.$file_path_name;
                break;
                case 'EC':
                case 'VBIOS':
                    $file_path_name = 'nb/' . $file_rename;
                    $file_size = ( file_exists( '/downloads/archive/frm_exe/' . $file_path_name ) ) ? filesize( '/downloads/archive/frm_exe/' . $file_path_name ) : 0;
                    if ( $file_size == 0 ){ 
                        return [ 'status' => 'error', 'message' => 'File size is null!' ];
                    }
                    $action = 'EC/VBIOS '.$file_path_name;
                    break;
            }

            $log= new \stdClass();
            $log->log_table = 'NB_download';
            $log->log_action = $action;
            $log->log_ip = $request->ip();
            $this->dispatchNow(CreateLog::fromRequest($log));








            $postdata = http_build_query(
                array(
                    'API_KEY' => env('API_KEY'),
                    'tmp_no' => $request->tmp_no,
                    'tmp_marketing_name' => $request->tmp_marketing_name,
                    'tmp_prd_model_name' => $request->tmp_prd_model_name,
                    'tmp_title' => $request->tmp_title,
                    'tmp_file_name' => $request->tmp_file_name,
                    'tmp_device' => $request->tmp_device,
                    'tmp_version' => $request->tmp_version,
                    'tmp_guid' => $request->tmp_guid,
                    'tmp_upgradeguid' => $request->tmp_upgradeguid,
                    'tmp_deviceid' => $request->tmp_deviceid,
                    'tmp_silentInstantparameter' => $request->tmp_silentInstantparameter,
                    'tmp_crc' => $request->tmp_crc,
                    'tmp_releasedate' => $request->tmp_releasedate,
                    'tmp_os' => $request->tmp_os,
                    'tmp_type' => $request->tmp_type,
                    'tmp_category' => $request->tmp_category,
                    'tmp_other' => $request->tmp_other,
                    'tmp_packageVersion' => $request->tmp_packageVersion,
                    'tmp_reboot' => $request->tmp_reboot,
                    'tmp_source' => $request->tmp_source,
                    'tmp_osImage' => $request->tmp_osImage,
                    'tmp_status' => $request->tmp_status,
                    'tmp_prd_list_no' => $request->tmp_prd_list_no,
                    'tmp_file_category' => $request->tmp_file_category,
                    'tmp_description' => $request->tmp_description,
                    'file_path' => $request->file_path.'/'.$request->tmp_title,
                    'download_size' => 0
                )
            );
            // dd($postdata, $request->tmp_description);
            $opts = array('http' =>
                array(
                    'method'  => 'POST',
                    'header'  => 'Content-Type: application/x-www-form-urlencoded',
                    'content' => $postdata
                )
            );
            
            $context  = stream_context_create($opts);
            $result = file_get_contents('https://internal-cms.msi.com.tw/api/v1/nb/add_download', false, $context);
            // dd($postdata);
            $log= new \stdClass();
            $log->log_table = 'NB_download';
            $log->log_action = 'Approve '.$request->tmp_no.' data to online. By hand';
            $log->log_ip = $request->ip();
            $this->dispatchNow(CreateLog::fromRequest($log));
            return redirect()->back();
        }
        elseif($request->action == 'Reject'){
            $data = CmsDownloadTmp::where('tmp_no', $request->tmp_no)->first();
            $data->tmp_status = 2;
            $data->save();

            $log= new \stdClass();
            $log->log_table = 'NB_download';
            $log->log_action = 'Reject '.$request->tmp_no.'. By hand';
            $log->log_ip = $request->ip();
            $this->dispatchNow(CreateLog::fromRequest($log));
            return redirect()->back();
        }
    }
    
    public function updateOnlineData(Request $request)
    {
        $request['API_KEY'] = env('API_KEY');
        $type_array = explode(',', $request->type_id);
        $request['type_alias'] = CmsDownloadType::where('type_id', $type_array[1])->first()->type_title;
        $request['type_id'] = $type_array[0];
        unset($request['_token']);
        $list = $request->all();
        $result = retrieve_by_curl($list, 'POST', 'https://internal-cms.msi.com.tw/api/v1/nb/add_relationships');
        $log= new \stdClass();
        $log->log_table = 'NB_download';
        $log->log_action = 'update '.$request['download_id'].' online data and relation';
        $log->log_ip = $request->ip();
        $this->dispatchNow(CreateLog::fromRequest($log));
        return redirect()->back();
    }
    
}
