<?php

namespace App\Http\Controllers\API\CMN;

use Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\CMN\CmnScenarioHistoryController;
use App\Exceptions\JcsException;

use Illuminate\Http\Request;
use DB;
use App\Models\CMN\cmn_scenario;
use App\Models\CMN\cmn_scenario_history;

class CmnScenarioController extends Controller
{
    private $sc_his;

    public function __construct()
    {
        parent::__construct();
        $this->sc_his = new CmnScenarioHistoryController;
    }

    /**
     * exec
     *
     * @param  mixed $request
     * @return void
     */
    public function exec(Request $request)
    {
        \Log::debug(__METHOD__.':start---');

        // ユーザチェック
        if (!Auth::user()) {
            $this->validate($request, ['email' => 'required|email', 'password' => 'required']);
            $user = ['email' => $request->get('email'),'password'=>$request->get('password')];
            if (!Auth::attempt($user)) {
                // ログインエラー
                return $this->sc_his->history_create($this->error, "Authentication faild");
            }
            // ログイン成功
            \Log::debug(Auth::user());
        } else {
            \Log::Info(Auth::user());
        }

        // Permissionチェック
        // TODO

        // 実行ユーザー
        $this->sc_his->sc_history_array['adm_user_id']=Auth::id();

        // シナリオ情報取得
        $cmn_scenario_id=$request->get('scenario_id');
        $cmn_scenario_name=$request->get('scenario_name');

        try {
            $sc = $this->getScenarioInfo($cmn_scenario_id, $cmn_scenario_name);

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
                throw new JcsException('Scenario exec function is not exist!');
            }

            $this->sc_his->sc_history_array['cmn_scenario_id']=$sc->cmn_scenario_id;
            $this->sc_his->sc_history_array['data']=$sc->class;

            // シナリオ実行
            $ret = $sc_obj->exec($request, $sc);

            // シナリオ結果
            if (($ret)&&(isset($ret['status']))&&($ret['status'] !== $this->success)) {
                // error
                throw new JcsException($ret['message']);
            }

            // \Log::debug($ret);

            // 正常終了
            if (isset($ret['cmn_connect_id'])) {
                // cmn_connect_idセット
                $this->sc_his->sc_history_array['cmn_connect_id']=$ret['cmn_connect_id'];
            }
            if (isset($ret['data_id'])) {
                // data_idセット
                $this->sc_his->sc_history_array['data_id']=$ret['data_id'];
            }

            // hisotry
            $this->sc_his->history_create($this->success, $ret['message']);
        } catch (\Exception $th) {
            \Log::error('$th->getCode():'.$th->getCode());
            // JCS_EXCEPTION判定
            if ($th->getCode() != config('const.JCS_EXCEPTION')) {
                // JCS_EXCEPTION以外のPHP Exceptionはトレースログ出力
                \Log::error($th);
            }

            // 異常終了
            $this->sc_his->history_create($this->error, $th->getMessage());
            return ['status'=>$this->error, 'message'=>$th->getMessage()];
        } finally {
            \Log::debug(__METHOD__.':end---');
        }

        $ret_data = '';
        if (isset($ret['data'])) {
            $ret_data = $ret['data'];
        }
        return ['status'=>$this->success, 'message'=>$ret['message'],'data'=>$ret_data];
    }

    private function getScenarioInfo($cmn_scenario_id, $cmn_scenario_name)
    {
        \Log::debug(__METHOD__.':start---');
        if ($cmn_scenario_id) {
            // シナリオID指定
            // $cmn_scenario_id よりシナリオ取得
            \Log::debug('cmn_scenario_id:'.$cmn_scenario_id);

            // scenario info check
            $sc = cmn_scenario::where('cmn_scenario_id', $cmn_scenario_id)->first();
        } elseif ($cmn_scenario_name) {
            // シナリオ名指定
            // $cmn_scenario_name よりシナリオ取得
            \Log::debug('cmn_scenario_name:'.$cmn_scenario_name);

            // scenario info check
            $sc = cmn_scenario::where('name', $cmn_scenario_name)->first();
        } else {
            throw new JcsException("Not scenario select".' $cmn_scenario_id:'.$cmn_scenario_id.' $cmn_scenario_name:'.$cmn_scenario_name);
        }

        // シナリオチェック
        if (empty($sc)) {
            throw new JcsException('No scenario found'.' $cmn_scenario_id:'.$cmn_scenario_id.' $cmn_scenario_name:'.$cmn_scenario_name);
        }

        \Log::info($sc);
        // シナリオファイル存在チェック
        if (!file_exists(app_path().'/'.$sc->file_path.'.php')) {
            throw new JcsException('Scenario file is not exist!'.$sc->file_path);
        }

        \Log::debug(__METHOD__.':end---');
        return $sc;
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
