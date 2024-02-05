<?php

namespace Vanguard\Http\Controllers\Web\Member;

use Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Vanguard\GatePass;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\Request;
use Vanguard\Imports\MembersImport;
use Vanguard\Member;
use Vanguard\MemberDetail;
use Excel;

class MembersController extends Controller
{

    private $member;
    public function __construct()
    {
        $this->middleware('auth:front');
        $members = Member::select('id','username','organization_name')->get();
        $this->member = $members;

    }
    /**
     * Displays the application dashboard.
     *
     * @return Factory|View
     */
    public function index()
    {
//        return auth('front')->user();
        if (session()->has('verified')) {
            session()->flash('success', __('E-Mail verified successfully.'));
        }

        $member = Auth::guard('front')->user();
        //Auth::guard('front')->logout();
        //var_dump(Auth::guard('front')->check());
//        if (!Auth::guard('front')->check())
//            return redirect('login');
//        return view('member.index');
        $member_details = MemberDetail::firstWhere('member_id', $member['id']);
        $company_owners = $member->company_owners;
//         return $member->check_privilege('gate_pass');
        return redirect()->to('member/home');
        return view('member.profile', compact(['member', 'member_details', 'company_owners']));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileImportExport()
    {

        ini_set('max_execution_time', '720000'); //300 seconds = 5 minutes
        ini_set('memory_limit', '40960M');
//        return $normalTimeLimit = ini_get('max_execution_time');
//        return DB::connection('mysql_archived')->table('gate_passes')->get();
//        return DB::connection('mysql_archived')->select('select * from gate_passes');
//        return GatePass::all();
//        $someModel = new SomeModel;
//        $someModel->setConnection('mysql2');
//        $something = $someModel->find(1);
//        return $something;

//        return Member::where('username','=',Str::of('801')->trim()->padLeft(4,'0'))->first()->id;

//        $on_behalf_of_member = $this->member->where('organization_name','=','HL Global Forwarding (Bangladesh) Limited')->first();
//        $on_behalf_of_member_id = $on_behalf_of_member ? $on_behalf_of_member->id : null;
        //        return $on_behalf_of_member_id;

        $import = new MembersImport;
        $file = storage_path('id_card_2021.xlsx');
         return $collection = Excel::toCollection($import, $file);
//        $arr = [];
//         foreach ($collection[0] as $x){
//             try {
////                 $results = \DB::connection("example")
////                     ->select(\DB::raw("SELECT * FROM unknown_table"))
////                     ->first();
//                 $member = $this->member->where('username','=',Str::of($x['bmn'])->trim()->padLeft(4,'0'))->first();
////                 $member = Member::where('username','=',Str::of($x['bmn'])->trim()->padLeft(4,'0'))->first();
//                     if(!$member)
//                         $arr[] = $x['bmn'];
//                 // Closures include ->first(), ->get(), ->pluck(), etc.
//             } catch(QueryException $ex){
//                 dd($ex->getMessage());
//                 // Note any method of class PDOException can be called on $ex.
//             }
////             $arr[] = $member;
//         }
//         return $arr;
//         return '1';

//        return $company_name = $collection[0][3];
//        return $contact_no = $this->getContactNo($company_name) ?? [];

        Excel::import($import, $file);


        return 'OK';

        return view('file-import');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
//Sl. No. 	Company Name	BMN(BAFFA Membership No.)	Name of Contact Parson	Current Address	Contact No.	Date of  Admission 	FFL No.(Freight Forwarder License No.)	Tin Number

    public function fileImport(Request $request)
    {
//        Excel::import(new MembersImport, $request->file('file')->store('temp'));
        $collection = Excel::toCollection(new MembersImport, 'users.xlsx');
        return back();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileExport()
    {
        return Excel::download(new UsersExport, 'users-collection.xlsx');
    }
    private function getContactNo($contact_no){
        $all_address = [
            'telephone_no' => '',
            'fax_no' => '',
            'mobile_no' => '',
            'email_address' => '',
            'website' => ''
        ];
//        $contact_no = $collection[0][0]['contact_no'];
        if (Str::contains($contact_no, 'Mob')) {
            $position_name = [
                'telephone_no' => 'Tel:',
                'fax_no' => 'Fax:',
                'mobile_no' => 'Mob:',
                'email_address' => 'Email:',
                'website' => 'www.'
            ];
            $position = [
                'telephone_no' => '',
                'fax_no' => '',
                'mobile_no' => '',
                'email_address' => '',
                'website' => ''
            ];

            foreach ($position as $k => $v) {
                $position[$k] = strpos($contact_no, $position_name[$k]);
            }
            $position = Arr::where($position, function ($value, $key) {
                return is_int($value);
            });
            $position_keys = array_keys($position);
            $position_keys_last = count($position_keys) - 1;
            foreach (array_keys($position_keys) as $val) {
                if ($val == $position_keys_last) {
                    $slice = Str::after($contact_no, $position_name[$position_keys[$val]]);
                    $all_address[$position_keys[$val]] = Str::of($slice)->trim();
                } else {
                    $slice = Str::between($contact_no, $position_name[$position_keys[$val]], $position_name[$position_keys[$val + 1]]);
                    $all_address[$position_keys[$val]] = Str::of($slice)->trim();
                }
            }
        }
        return $all_address;
    }
}
