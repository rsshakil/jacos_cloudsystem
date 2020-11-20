<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\CMN\cmn_tbl_col_setting;
use App\Models\CMN\cmn_scenario;
use App\Models\CMN\cmn_connect;
use App\Models\CMN\cmn_company;
use App\Models\ADM\User;
use App\Models\CMN\cmn_companies_user;
use App\Models\BYR\byr_receive;
use App\Models\BYR\byr_corrected_receive;
use App\Models\BYR\byr_buyer;
use App\Models\BYR\byr_return;
use DB;

class AllUsedFunction extends Controller
{
    /**
     * Get all User by customize id and name
     *
     * @return All Users as an array.
     */
    public function allUsers(){
        $users = User::select('id as user_id','name as user_name')->get();
        return $users;
    }
    /**
     * Get all Users as default
     *
     * @return All Users as an array.
     */
    public function allUsersAll(){
        $users = User::all();
        return $users;
    }
    
    /**
     * Get all permission for a desired role
     *
     * @param  int $role_id
     * @return All permission as an array.
     */
    public function get_role_permission_by_role_id($role_id = null,$status = null)
    {
        if (!empty($role_id)) {
            // $permissions=$this->get_selected_permission_by_role_id($role_id);
            $permissions=$this->get_permissions($role_id);
                $permission_array=array();
                foreach ($permissions as $key => $permission) {
                    if($status==null){
                        $permission_array[]='<button class="btn btn-info btn-sm" style="margin-top:5px;">'.$permission->name.'</button>';
                    }else{
                        $permission_array[]=$permission->name;
                    }
                    
                }
            return $permissions=implode(' ',$permission_array);
        } else {
            return $permissions = Permission::select('id','name')->get();
        }
    }
    /**
     * Get all permission for a desired role
     *
     * @param  int $role_id
     * @return All permission as an array.
     */
    public function get_permissions($role_id = null)
    {
        if ($role_id != null) {
            $permissions = Permission::select('adm_permissions.*')
                ->join('adm_role_has_permissions as rhp', 'adm_permissions.id', '=', 'rhp.permission_id')
                ->where('rhp.role_id', $role_id)
                ->get();
        }else{
            $permissions=Permission::all();
        }
            
     return $permissions;
        
    }
    /**
     * Get all permission for a desired user
     *
     * @param  array $user
     * @return All permissions as an array.
     */
    public function allPermissionForUser($user){
        $all_permissions_for_user= $user->getAllPermissions();
        $all_permissions_for_user_array=array();
        foreach ($all_permissions_for_user as $all_permission_for_user) {
            $all_permissions_for_user_array[]=$all_permission_for_user->name;
        }
        return $all_permissions_for_user_array;
    }
    /**
     * Get all Permissions by customize id and name
     *
     * @return All Permissions as an array.
     */
    public function get_permission_custom_field(){
        return $permissions = Permission::select('id as permission_id','name as permission_name')->get();
    }
    /**
     * Get all Roles by customize id and name
     *
     * @return All Roles as an array.
     */
    public function get_role_custom_field(){
        return $roles = Role::select('id as role_id','name as role_name')->get();
    }
    /**
     * Get all Roles as default
     *
     * @return All Roles as an array.
     */
    public function get_roles(){
        return $roles = Role::all();
    }
    /**
     * Read a csv file by path
     *
     * @param  string $baseUrl
     * @return All csv data as an array.
     */
    public function csvReader($baseUrl)
    {
        $data = array_map('str_getcsv', file($baseUrl));
        $csv_data = array_slice($data, 1);
        // return $csv_data;
        $rowData = $this->convert_from_sjis_to_utf8_recursively($csv_data);
        \Log::debug('----- CSV file read completed from this url: (' . $baseUrl . ')-----');
        return $rowData;
    }

    /**
     * File encoding from SJIJ to utf8
     * @param  SJIJ String or array
     * @return utf-8 encoded string
     */
    public static function convert_from_sjis_to_utf8_recursively($dat)
    {
        if (is_string($dat)) {
            // \Log::debug('----- SJIJ to UTF-8 conversion completed -----');
            // $dat=str_replace("\u{00a0}", ' ', $dat);
            if(mb_detect_encoding($dat) != "UTF-8"){
                return mb_convert_encoding($dat, "UTF-8", "sjis-win");
                // return utf8_encode($dat);   
            }else{
                return mb_convert_encoding($dat,"UTF-8","auto");
                // return $dat;
            }
        } elseif (is_array($dat)) {
            $ret = [];
            foreach ($dat as $i => $d) {
                $ret[$i] = self::convert_from_sjis_to_utf8_recursively($d);
            }

            return $ret;
        } elseif (is_object($dat)) {
            foreach ($dat as $i => $d) {
                $dat->$i = self::convert_from_sjis_to_utf8_recursively($d);
            }

            return $dat;
        } else {
            return $dat;
        }
    }
    /**
     * File encoding from utf8 to SJIJ
     * @param utf-8 String or array
     * @return  SJIJ encoded string
     */
    public static function convert_from_utf8_to_sjis__recursively($dat)
    {
        if (is_string($dat)) {
            // \Log::debug('----- UTF-8 to SJIJ conversion completed -----');
            // Original
            return mb_convert_encoding($dat, "sjis-win", "UTF-8");
            // return mb_convert_encoding($dat, "SJIS", "UTF-8");
        } elseif (is_array($dat)) {
            $ret = [];
            foreach ($dat as $i => $d) {
                $ret[$i] = self::convert_from_utf8_to_sjis__recursively($d);
            }

            return $ret;
        } elseif (is_object($dat)) {
            foreach ($dat as $i => $d) {
                $dat->$i = self::convert_from_utf8_to_sjis__recursively($d);
            }

            return $dat;
        } else {
            return $dat;
        }
    }
    /**
     * File encoding from Latin1 utf8
     * @param Latin1 String or array
     * @return  utf-8 encoded string
     */
    public static function convert_from_latin1_to_utf8_recursively($dat)
   {
      if (is_string($dat)) {
         return utf8_encode($dat);
      } elseif (is_array($dat)) {
         $ret = [];
         foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);

         return $ret;
      } elseif (is_object($dat)) {
         foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

         return $dat;
      } else {
         return $dat;
      }
   }
   /**
     * Change a file name from a given file name
     * @param  String File name
     * @return String formated file name
     */
    public function file_name_change($file_name)
    {
        $file_array = explode('.', $file_name);
        $array_size = sizeof($file_array);
        $file_name_without_ext = $file_array[$array_size - 2];
        $today_for_file = date("YmdHis");
        return $file_name = $file_name_without_ext . "_" . $today_for_file . "." . $file_array[$array_size - 1];
    }
    /**
     * Get cmn_companies information by cmn_company_id or not
     * @param  int $cmn_company_id
     * @return Array Company information
     */
    public function get_company_list($cmn_company_id=0){
        if($cmn_company_id!=0){
            return $results  = cmn_company::where('cmn_company_id',$cmn_company_id)->get();
        }else{
            return $byr_buyer = byr_buyer::select('cmn_companies.*')
            ->join('cmn_companies','cmn_companies.cmn_company_id','=','byr_buyers.cmn_company_id')->get();
        }
    }
    /**
     * Get cmn_companies_users information by adm_user_id or not
     * @param  int $adm_user_id
     * @return Array Formated Company information
     */
    public function get_user_info($adm_user_id=0){
        $arr=array('cmn_company_id'=>0,'byr_buyer_id'=>0,'cmn_connect_id'=>0);
        \Log::info($adm_user_id);
        if($adm_user_id!=0){
            // \Log::info($adm_user_id);
            $cmn_company_info = cmn_companies_user::select('byr_buyers.cmn_company_id','byr_buyers.byr_buyer_id','cmn_connects.cmn_connect_id')
            ->join('byr_buyers', 'byr_buyers.cmn_company_id', '=', 'cmn_companies_users.cmn_company_id')
            ->join('cmn_connects', 'cmn_connects.byr_buyer_id', '=', 'byr_buyers.byr_buyer_id')
            ->where('cmn_companies_users.adm_user_id',$adm_user_id)->first();
            // \Log::info($adm_user_id);
            // \Log::info($cmn_company_info);
            if (!empty($cmn_company_info)) {
                $cmn_company_id = $cmn_company_info->cmn_company_id;
                $byr_buyer_id = $cmn_company_info->byr_buyer_id;
                $cmn_connect_id = $cmn_company_info->cmn_connect_id;
                $arr = array(
                    'cmn_company_id'=>$cmn_company_id,
                    'byr_buyer_id'=>$byr_buyer_id,
                    'cmn_connect_id'=>$cmn_connect_id
                );
            }
        }
        return $arr;
    }
    /**
     * Unserialize Canvas object from serialized Canvas Object
     * @param  Object $canvas_objects Serialized Canvas Object
     * @return Array Formated Object Array
     */
    private function UnserializedCanvasData($canvas_objects)
    {
        $canvas_data = unserialize($canvas_objects);
        $canvas_array = array();
        foreach ($canvas_data['objects'] as $key => $value) {
            $temp_array['type'] = $value['type'];
            $temp_array['version'] = $value['version'];
            $temp_array['originX'] = $value['originX'];
            $temp_array['originY'] = $value['originY'];
            $temp_array['left'] = (float) $value['left'];
            $temp_array['top'] = (float) $value['top'];
            $temp_array['width'] = (float) $value['width'];
            $temp_array['height'] = (float) $value['height'];
            $temp_array['fill'] = $value['fill'];
            $temp_array['stroke'] = $value['stroke'];
            $temp_array['strokeWidth'] = (float) $value['strokeWidth'];
            $temp_array['strokeDashArray'] = $value['strokeDashArray'];
            $temp_array['strokeLineCap'] = $value['strokeLineCap'];
            $temp_array['strokeDashOffset'] = (float) $value['strokeDashOffset'];
            $temp_array['strokeLineJoin'] = $value['strokeLineJoin'];
            $temp_array['strokeMiterLimit'] = (float) $value['strokeMiterLimit'];
            $temp_array['scaleX'] = (float) $value['scaleX'];
            $temp_array['scaleY'] = (float) $value['scaleY'];
            $temp_array['angle'] = (float) $value['angle'];
            $temp_array['flipX'] = (float) $value['flipX'];
            $temp_array['flipY'] = (float) $value['flipY'];
            $temp_array['opacity'] = (float) $value['opacity'];
            $temp_array['shadow'] = $value['shadow'];
            $temp_array['visible'] = (float) $value['visible'];
            $temp_array['clipTo'] = $value['clipTo'];
            $temp_array['backgroundColor'] = $value['backgroundColor'];
            $temp_array['fillRule'] = $value['fillRule'];
            $temp_array['paintFirst'] = $value['paintFirst'];
            $temp_array['globalCompositeOperation'] = $value['globalCompositeOperation'];
            $temp_array['transformMatrix'] = $value['transformMatrix'];
            $temp_array['skewX'] = (float) $value['skewX'];
            $temp_array['skewY'] = (float) $value['skewY'];
            $temp_array['text'] = $value['text'];
            $temp_array['fontSize'] = (float) $value['fontSize'];
            $temp_array['fontWeight'] = $value['fontWeight'];
            $temp_array['fontFamily'] = $value['fontFamily'];
            $temp_array['fontStyle'] = $value['fontStyle'];
            $temp_array['lineHeight'] = (float) $value['lineHeight'];
            $temp_array['underline'] = (float) $value['underline'];
            $temp_array['overline'] = (float) $value['overline'];
            $temp_array['linethrough'] = (float) $value['linethrough'];
            $temp_array['textAlign'] = $value['textAlign'];
            $temp_array['textBackgroundColor'] = $value['textBackgroundColor'];
            $temp_array['charSpacing'] = (float) $value['charSpacing'];
            $temp_array['minWidth'] = (float) $value['minWidth'];
            $temp_array['splitByGrapheme'] = (float) $value['splitByGrapheme'];
            $canvas_array[] = $temp_array;
        }
        // return $canvas_array;

        $new_array = array(
            'version' => $canvas_data['version'],
            'objects' => $canvas_array,
        );
        return $new_array;
    }
     /**
     * Save Base64 image in Directory
     * @param  Object $base64_image_string Base64 Image Object
     * @param  String $output_file_without_extension File name without extension which will be returned as file name
     * @param  String $path_with_end_slash Directory path with end slash where the file will be saved
     * @return Array Formated Object Array
     */
    public function save_base64_image($base64_image_string, $output_file_without_extension, $path_with_end_slash = "")
    {
        $splited = explode(',', substr($base64_image_string, 5), 2);
        $mime = $splited[0];
        $data = $splited[1];

        $mime_split_without_base64 = explode(';', $mime, 2);
        $mime_split = explode('/', $mime_split_without_base64[0], 2);
        if (count($mime_split) == 2) {
            $extension = $mime_split[1];
            if ($extension == 'jpeg') {
                $extension = 'jpg';
            }
            //if($extension=='javascript')$extension='js';
            //if($extension=='text')$extension='txt';
            $output_file_with_extension = $output_file_without_extension . '.' . $extension;
        }
        file_put_contents($path_with_end_slash . $output_file_with_extension, base64_decode($data));
        // move_uploaded_file(base64_decode($data),$path_with_end_slash . $output_file_with_extension);
        return $output_file_with_extension;
    }
    /**
     * Check an Object is an base64 image or not
     * @param  object $base64_obj Base64 Image Object
     * @return boolean If base64 return 1 else 0
     */
    public function itsBase64($base64_obj){
        if(substr($base64_obj, 0,11) === 'data:image/'){     
            return 1;
        }else{
            return 0;
        }
     }
     /**
     * Check string length and add space padding after the string until desired length
     * @param  string $input desired string
     * @param  int $pad_length desired string length
     * @return string formated string with space padding added
     */
     public function mb_str_pad($input, $pad_length)
    {
        $len = $pad_length - mb_strlen($input);
        if ($len<0) {
            return mb_substr($input, 0, $pad_length);
        }
        return $input.str_repeat(' ', $len);
    }
    /**
     * Get file extension from a file name
     * @param  string $file_name desired file name
     * @return string File extension
     */
    public function ext_check($file_name){
        $ext=\explode('.',$file_name)[1];
        return $ext;
    }
    /**
     * Get first 8 character from a date based file name for date
     * @param  string $file_name desired file name
     * @return string date string from file name
     */
    public function header_part($file_name){
        $header=\substr($file_name,0,8);
        return $header;
    }
    /**
     * Split at all position not after the start: ^ and not before the end: $
     * @param  string $string desired string
     * @return string Formated string
     */
    public function mb_str_split($string)
    {
        return preg_split('/(?<!^)(?!$)/u', $string);
    }
    /**
     * Binary number set for date schedule
     * @param  int $binary_number desired binary number Like: 11011
     * @return int Formated binary number as 7 days like: 0011011
     */
    private function binary_format($binary_number)
    {
        $binary_length = strlen($binary_number);

        $formated_binary_number = null;
        if ($binary_length < 7) {
            $addable = 7 - $binary_length;
            $formated_binary_number = str_repeat('0', $addable) . $binary_number;
        } else {
            $formated_binary_number = $binary_number;
        }
        return $formated_binary_number;
    }
    /**
     * Get binary to decimal number
     * @param  int $binary desired binary number Like: 0000011
     * @return int decimal number as like: 3
     */
    private function binary_to_decimal($binary)
    {
        return bindec($binary);
    }
    /**
     * Get decimal to binary number
     * @param  int $decimal desired decimal number Like: 3
     * @return int binary number as like: 11
     */
    private function decimal_to_binary($decimal)
    {
        $bos = null;
        while ($decimal >= 1) {$bin = $decimal % 2;
            $decimal = round($decimal / 2, 0,
                PHP_ROUND_HALF_DOWN);
            $bos .= $bin;
        }
        return strrev($bos);

    }
}
