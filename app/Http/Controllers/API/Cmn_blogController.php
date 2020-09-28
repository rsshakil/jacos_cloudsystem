<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CMN\cmn_tbl_col_setting;
use App\Models\CMN\cmn_scenario;
use App\Models\CMN\cmn_connect;
use App\Models\CMN\cmn_blog;
use App\Models\ADM\User;
use App\Models\CMN\cmn_companies_user;
use DB;
class Cmn_blogController extends Controller
{
    private $all_used_fun;

    public function __construct(){
        $this->all_used_fun = new AllUsedFunction();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $result = cmn_blog::where('is_delete','0')->orderBy('is_top_blog','ASC')->orderBy('cmn_blog_id','DESC')->get();
        return response()->json(['blog_list' => $result]);
    }
    public function get_all_published_blog_list()
    {
        //
        $result = cmn_blog::where('is_delete','0')->where('blog_status','published')->where('is_top_blog','0')->orderBy('is_top_blog','DESC')->orderBy('cmn_blog_id','DESC')->get();
        return response()->json(['blog_list' => $result]);
    }
    public function get_signle_top_blog()
    {
        $result = cmn_blog::where('is_delete','0')->where('blog_status','published')->where('is_top_blog','1')->first();
        if($result){
            return response()->json(['blog_list' => $result]);
        }else{
            $result = array();
            return response()->json(['blog_list' => $result]);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ckeditor_file_up(Request $request)
    {
        $file_name = $request->file('upload')->getClientOriginalName();
        $path = $request->file('upload')->storeAs(config('const.ORDER_DATA_PATH').date('Y-m'), $file_name);
        // $received_path = base_path().'/storage/app//'.config('const.ORDER_DATA_PATH').date('Y-m').'/'.$file_name;
        $received_path = url('/storage/app//'.config('const.ORDER_DATA_PATH').date('Y-m').'/'.$file_name);
        return response()->json(['url' => $received_path]);
    }
    public function store(Request $request)
    {
        // return $request->all();
        //
        $this->validate($request,[
            'blog_title' => 'required|string|min:5',
            'blog_content'=>'required'
        ]);
        $arr =array(
            'blog_title'=>$request->blog_title,
            'blog_content'=>$request->blog_content,
            'blog_by'=>$request->blog_by
        );
        $feature_img = $request->feature_img;
        $img = '';
        if (!empty($feature_img)) {
            if($request->cmn_blog_id!=''){
                $info=cmn_blog::where('cmn_blog_id',$request->cmn_blog_id)->first();
                $img = $info->feature_img;
            }
            if($img!=$feature_img){
                $imgs = $this->all_used_fun->save_base64_image($feature_img, 'blog_image_'. time(), $path_with_end_slash = "storage/app/public/backend/images/blog_images/");
                $arr['feature_img'] = $imgs;
            }
        }
        if($request->cmn_blog_id!=''){
            cmn_blog::where('cmn_blog_id',$request->cmn_blog_id)->update($arr);
        }else{
            $this->validate($request,[
                'feature_img' => 'required'
            ]);
            cmn_blog::insert($arr);
        }
        return response()->json(['success' => 1]);
    }

    public function update_blog_infos(Request $request){
        $act_type = $request->action_type;
        $blog_info = $request->blog;
        $cmn_blog_id = $blog_info['cmn_blog_id'];
        if($act_type==0 || $act_type==1){
            $pub_type = ($act_type==0?'unpublished':'published');
            cmn_blog::where('cmn_blog_id',$cmn_blog_id)->update(['blog_status'=>$pub_type]);
        }else if($act_type==2){
            cmn_blog::where('cmn_blog_id', '>', 0)->update(['is_top_blog'=>'0']);
            cmn_blog::where('cmn_blog_id',$cmn_blog_id)->update(['is_top_blog'=>'1']);
        }else{
            cmn_blog::where('cmn_blog_id',$cmn_blog_id)->update(['is_delete'=>'1']);
        }
        return response()->json(['success' => 1]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
