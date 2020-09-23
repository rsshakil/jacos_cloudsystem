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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request->all();
        //
        $this->validate($request,[
            'blog_title' => 'required|string|min:5',
            'feature_img' => 'required',
        ]);
        $arr =array(
            'blog_title'=>$request->blog_title,
            'blog_content'=>$request->blog_content,
            'blog_by'=>$request->blog_by
        );
        $feature_img = $request->feature_img;
        if (!empty($feature_img)) {
            $imgs = $this->all_used_fun->save_base64_image($feature_img, 'blog_image_'. time(), $path_with_end_slash = "storage/app/public/backend/images/blog_images/");
            $arr['feature_img'] = $imgs;
        }
        if($request->cmn_blog_id!=''){
            cmn_blog::where('cmn_blog_id',$request->cmn_blog_id)->update($arr);
        }else{
            cmn_blog::insert($arr);
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
