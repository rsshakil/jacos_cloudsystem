<?php

namespace App\Http\Controllers\API;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\CMN\cmn_scenario;
use App\Models\CMN\cmn_scenario_history;

class Cmn_ScenarioController extends Controller
{
    private $sc_history_array;
    public function __construct()
    {
        parent::__construct();
        $this->sc_history_array = array();
    }

    /**
     * Execute scenario
     *
     * @return \Illuminate\Http\Response
     */
    public function exec(Request $request)
    {
        // return $request->all();
        // return response()->json(['status'=>$request->all()]);
        \Log::debug(get_class().':'.__FUNCTION__.' start  ---------------');
        \Log::Info(Auth::user());

        if (!Auth::user()) {
            $this->validate($request, ['email' => 'required|email', 'password' => 'required']);
            $user = ['email' => $request->get('email'),'password'=>$request->get('password')];
            if (!Auth::attempt($user)) {
                // ログインエラー
                return self::history_create($this->error, "Authentication faild");
            }
            // ログイン成功
            \Log::debug(Auth::user());
        }else{
            \Log::Info(Auth::user());
        }

        // 実行ユーザー
        $this->sc_history_array['adm_user_id']=Auth::id();

        // シナリオ情報取得
        $cmn_scenario_id=$request->get('scenario_id');

        if (!$cmn_scenario_id) {
            // シナリオ名指定
            $cmn_scenario_name=$request->get('scenario_name');
            if (!$cmn_scenario_name) {
                // シナリオ指定なし
                return self::history_create($this->error, "Not scenario select");
            }
            // $cmn_scenario_name よりシナリオ取得
            \Log::debug('cmn_scenario_name:'.$cmn_scenario_name);

            // scenario info check
            $sc = cmn_scenario::where('name', $cmn_scenario_name)->first();
        } else {
            // シナリオID指定
            // $cmn_scenario_id よりシナリオ取得
            \Log::debug('cmn_scenario_id:'.$cmn_scenario_id);

            // scenario info check
            $sc = cmn_scenario::where('cmn_scenario_id', $cmn_scenario_id)->first();
        }

        // シナリオチェック
        if (empty($sc)) {
            return self::history_create($this->error, "No scenario found");
        }

        \Log::info($sc);
        // シナリオファイル存在チェック
        if (!file_exists(app_path().'/'.$sc->file_path.'.php')) {
            return self::history_create($this->error, 'Scenario file is not exist!'.$sc->file_path);
        }

        // ファイル読み込み
        $customClassPath = "\\App\\";
        $nw_f_pth = explode('/', $sc->file_path);
        foreach ($nw_f_pth as $p) {
            $customClassPath .= $p.'\\';
        }
        $customClassPath = rtrim($customClassPath, "\\");
        $sc_obj = new $customClassPath;

        // シナリオ実行function存在チェック
        if (!method_exists($sc_obj, 'exec')) {
            // exec functionが存在しない場合
            return self::history_create($this->error, 'Scenario exec function is not exist!');
        }

        try {
            // シナリオ実行
            $ret = $sc_obj->exec($request, $sc);

            // シナリオ結果
            if (($ret)&&(isset($ret['status']))&&($ret['status'] !== $this->success)) {
                // error

                // return self::history_create($this->error, 'scenario exec error!');
                return self::history_create($this->error, $ret['message']);
            } else {
                // success
                \Log::debug('scenario exec success');
            }
        } catch (\Throwable $th) {
            //throw $th;
            // error
            // \Log::error($th->getTrace());
            return self::history_create($this->error, $th->getMessage());
        } finally {
            \Log::debug(get_class().':'.__FUNCTION__.' end  ---------------');
        }
        return $ret;
        return self::history_create($this->success, "scenario exec success");
    }

    private function history_create($status, $information)
    {
        if ($status === $this->error) {
            \Log::error($information);
        }

        $this->sc_history_array['status']=$status;
        $this->sc_history_array['information']=$information;
        cmn_scenario_history::insert($this->sc_history_array);

        return response()->json(['status'=>$status, 'message' => $information]);
    }

    public function exec_demo(Request $request, $id)
    {
        return response()->json(['req'=>$request->all()]);
    }
    public function get_scenario_list()
    {
        $result = cmn_scenario::select('cmn_scenarios.*', 'byr_buyers.super_code')
        ->leftJoin('byr_buyers', 'byr_buyers.byr_buyer_id', '=', 'cmn_scenarios.byr_buyer_id')
        ->leftJoin('slr_sellers', 'slr_sellers.slr_seller_id', '=', 'cmn_scenarios.slr_seller_id')
        ->get();
        return response()->json(['scenario_list'=>$result]);
    }
}
