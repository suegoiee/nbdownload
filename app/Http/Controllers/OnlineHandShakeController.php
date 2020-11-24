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

            
            $log= new \stdClass();
            $log->log_ip = $request->ip();

            switch ( $request->tmp_category )
            {
                case 'Driver':
                case 'Driver and Application':
                    if ( empty( $request->file_path ) ) {
                        $log->log_action = 'Driver/Application: '.$request->tmp_no.' file path not selected';
                        $this->dispatchNow(CreateLog::fromRequest($log));
                        return [ 'status' => 'error', 'message' => 'File folder is empty.' ];
                    }
                    if ( empty( $request->tmp_guid ) ) {
                        $log->log_action = 'Driver/Application: '.$request->tmp_no.' tmp_guid null';
                        $this->dispatchNow(CreateLog::fromRequest($log));
                        return [ 'status' => 'error', 'message' => 'Guid is empty.' ];
                    }
                    if ( empty( $request->tmp_upgradeguid ) ) {
                        $log->log_action = 'Driver/Application: '.$request->tmp_no.' tmp_upgradeguid null';
                        $this->dispatchNow(CreateLog::fromRequest($log));
                        return [ 'status' => 'error', 'message' => 'Upgrade Guid is empty.' ];
                    }
                    if ( empty( $request->tmp_silentInstantparameter ) ) {
                        $log->log_action = 'Driver/Application: '.$request->tmp_no.' tmp_silentInstantparameter null';
                        $this->dispatchNow(CreateLog::fromRequest($log));
                        return [ 'status' => 'error', 'message' => 'Silent Install Parameter is empty.' ];
                    }
                    if(strpos($request->tmp_file_name,'www.microsoft.com') !== FALSE){
                        $file_path_name = $request->tmp_file_name;
                    }
                    else{
                        $file_path_name = $request->file_path . '/' . $file_rename;
                        $file_path = '/downloads/nb_drivers/' . $file_path_name;
                        if ( is_file( $file_path ) ) {
                            $log->log_action = 'Driver/Application: '.$request->tmp_no.' Server already have a same file in '.$file_path;
                            $this->dispatchNow(CreateLog::fromRequest($log));
                            return [ 'status' => 'error', 'message' => 'Server already have a same file, please reject this sync data!'];
                        }
                        $copy_path = $path . $request->tmp_file_name;
                        $file_size = ( file_exists( $copy_path ) ) ? filesize( $copy_path ) : 0;
                        if ( $file_size == 0 ) {
                            $log->log_action = 'Driver/Application: '.$request->tmp_no.' File size is null in '.$copy_path;
                            $this->dispatchNow(CreateLog::fromRequest($log));
                            return [ 'status' => 'error', 'message' => 'File size is null!<br>' . $copy_path ];
                        }
                        copy( $copy_path, $file_path );
                        $action = 'Driver/Application: '.$request->tmp_no.' copy from '.$copy_path. ' to '.$file_path.'.';
                    }
                    break;
                case 'Application':
                    if ( empty( $request->tmp_guid ) ) {
                        $log->log_action = 'Application: '.$request->tmp_no.' tmp_guid null';
                        $this->dispatchNow(CreateLog::fromRequest($log));
                        return [ 'status' => 'error', 'message' => 'Guid is empty.' ];
                    }
                    if ( empty( $request->tmp_upgradeguid ) ) {
                        $log->log_action = 'Application: '.$request->tmp_no.' tmp_upgradeguid null';
                        $this->dispatchNow(CreateLog::fromRequest($log));
                        return [ 'status' => 'error', 'message' => 'Upgrade Guid is empty.' ];
                    }
                    if ( empty( $request->tmp_silentInstantparameter ) ) {
                        $log->log_action = 'Application: '.$request->tmp_no.' tmp_silentInstantparameter null';
                        $this->dispatchNow(CreateLog::fromRequest($log));
                        return [ 'status' => 'error', 'message' => 'Silent Install Parameter is empty.' ];
                    }
                    if(strpos($request->tmp_file_name,'www.microsoft.com') !== FALSE){
                        $file_path_name = $request->tmp_file_name;
                    }
                    else{
                        $file_path_name = 'nb/' . $file_rename;
                        $file_path = '/downloads/uti_exe/' . $file_path_name;
                        if ( is_file( $file_path ) ) {
                            $log->log_action = 'Application: '.$request->tmp_no.' Server already have a same file in '.$file_path;
                            $this->dispatchNow(CreateLog::fromRequest($log));
                            return [ 'status' => 'error', 'message' => 'Server already have a same file, please reject this sync data!' ];
                        }
                        $file_size = 0;
                        $copy_path = $path . $request->tmp_file_name;
                        $file_size = ( file_exists( $copy_path ) ) ? filesize( $copy_path ) : 0;
                        if ( $file_size == 0 ) {
                            $log->log_action = 'Application: '.$request->tmp_no.' File size is null in '.$copy_path;
                            $this->dispatchNow(CreateLog::fromRequest($log));
                            return [ 'status' => 'error', 'message' => 'File size is null!<br>' . $copy_path ];
                        }
                        copy( $copy_path, $file_path );
                        $action = 'Application: '.$request->tmp_no.' copy from '.$copy_path. ' to '.$file_path.'.';
                    }
                    break;
                case 'BIOS':
                    $file_path_name = 'nb/' . $file_rename;
                    $file_size = ( file_exists( $bios_root . $file_path_name ) ) ? filesize( $bios_root . $file_path_name ) : 0;
                    if ( $file_size == 0 ) {
                        $log->log_action = 'BIOS: '.$request->tmp_no.' File size is null in '.$bios_root . $file_path_name;
                        $this->dispatchNow(CreateLog::fromRequest($log));
                        return [ 'status' => 'error', 'message' => 'File size is null!' ];
                    }
                    $action = 'BIOS: '.$request->tmp_no.' has found in '.$bios_root . $file_path_name;
                break;
                case 'EC':
                case 'VBIOS':
                    $file_path_name = 'nb/' . $file_rename;
                    $file_size = ( file_exists( $EC_VBIOS_root . $file_path_name ) ) ? filesize( $EC_VBIOS_root . $file_path_name ) : 0;
                    if ( $file_size == 0 ){ 
                        $log->log_action = 'EC/VBIOS: '.$request->tmp_no.' File size is null in '.$EC_VBIOS_root . $file_path_name;
                        $this->dispatchNow(CreateLog::fromRequest($log));
                        return [ 'status' => 'error', 'message' => 'File size is null!' ];
                    }
                    $action = 'EC/VBIOS: '.$request->tmp_no.' has found in '.$EC_VBIOS_root . $file_path_name;
                    break;
            }

            $log->log_action = $action;
            $this->dispatchNow(CreateLog::fromRequest($log));


            $category = $request->tmp_category;
            $filter_cloumn = $request->tmp_type;
            $type_id_list = array();
            $type_id = 0 ;
            if ( $category == 'Driver' || $category == 'Driver and Application' ) {
                $type_id = 90 ;
                $type_id_list = config('global.drivers_type_id_list');
            } else {
                $filter_cloumn = $category;
                $type_id_list = config('global.others_type_id_list');
            }
            $found_key = array_search($filter_cloumn, array_column($type_id_list, 'category_name'));
            $type_id = $type_id_list[$found_key]['type_id']; 








            

            isset($file_size) ? $file_size = $file_size : $file_size = 0;
            $list = array(
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
                'download_size' => $file_size,
                'type_id' => $type_id,
                'action' => 'insert'
            );
            $result = retrieve_by_curl($list, 'POST', 'https://internal-cms.msi.com.tw/api/v1/nb/add_download');
            
            $download = CmsDownloadTmp::where('tmp_no', $request->tmp_no)->first();
            $download->tmp_status = 1;
            $download->save();

            $log= new \stdClass();
            $log->log_action = 'Approve '.$request->tmp_no.' data to online. By hand. Result: '.$result['message'];
            $log->log_ip = $request->ip();
            $this->dispatchNow(CreateLog::fromRequest($log));
            return redirect()->back();
        }
        elseif($request->action == 'Reject'){
            $data = CmsDownloadTmp::where('tmp_no', $request->tmp_no)->first();
            $data->tmp_status = 2;
            $data->save();

            $log= new \stdClass();
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
        $log->log_action = 'update '.$request['download_id'].' online data and relation';
        $log->log_ip = $request->ip();
        $this->dispatchNow(CreateLog::fromRequest($log));
        return redirect()->back();
    }
    
    public function createOnlineData(Request $request)
    {
        $log= new \stdClass();
        $log->log_ip = $request->ip();
        $file_path_name = 'nb/' . $request->download_file;
        if($request->download_category == 'BIOS'){
            $bios_root = '/downloads/bos_exe/';
            $file_size = ( file_exists( $bios_root . $file_path_name ) ) ? filesize( $bios_root . $file_path_name ) : 0;
            if ( $file_size == 0 ) {
                $log->log_action = 'BIOS create manual: '.$request->tmp_no.' File size is null in '.$bios_root . $file_path_name;
                $this->dispatchNow(CreateLog::fromRequest($log));
                return [ 'status' => 'error', 'message' => ' File size is null in '.$bios_root . $file_path_name ];
            }
            $action = 'BIOS create manual: '.$request->tmp_no.' has found in '.$bios_root . $file_path_name;
        }
        else{
            $EC_VBIOS_root = '/downloads/archive/frm_exe/';
            $file_size = ( file_exists( $EC_VBIOS_root . $file_path_name ) ) ? filesize( $EC_VBIOS_root . $file_path_name ) : 0;
            if ( $file_size == 0 ){ 
                $log->log_action = 'EC/VBIOS create manual: '.$request->tmp_no.' File size is null in '.$EC_VBIOS_root . $file_path_name;
                $this->dispatchNow(CreateLog::fromRequest($log));
                return [ 'status' => 'error', 'message' => 'File size is null in '.$EC_VBIOS_root . $file_path_name ];
            }
            $action = 'EC/VBIOS create manual: '.$request->tmp_no.' has found in '.$EC_VBIOS_root . $file_path_name;
        }
        $log->log_action = $action;
        $this->dispatchNow(CreateLog::fromRequest($log));

        $request['API_KEY'] = env('API_KEY');
        $type_array = explode(',', $request->type_id);
        $request['type_alias'] = CmsDownloadType::where('type_id', $type_array[1])->first()->type_title;
        $request['type_id'] = $type_array[0];
        $request['download_size'] = $file_size;
        unset($request['_token']);
        $list = $request->all();
        dd(http_build_query($list));
        $result = retrieve_by_curl($list, 'POST', 'https://internal-cms.msi.com.tw/api/v1/nb/add_relationships');
        $log= new \stdClass();
        $log->log_action = 'create '.$request['download_title'].' online data and relation. Result: '.$result['message'] ? 'done' : 'failed';
        $log->log_ip = $request->ip();
        $this->dispatchNow(CreateLog::fromRequest($log));
        return redirect()->back();
    }
    
}
