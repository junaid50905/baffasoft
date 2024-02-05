<?php

namespace Vanguard\Imports;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Vanguard\CompanyOwner;
use Vanguard\GatePass;
use Vanguard\IdCardRecord;
use Vanguard\Member;
use Vanguard\MoneyCollection;
use Vanguard\Support\Enum\UserStatus;

class MembersImport implements WithHeadingRow, ToCollection // ToModel
{
    private $member;
    public function __construct()
    {
        $members = Member::select('id','username','organization_name')->get();
        $this->member = $members;

    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

//        $member = $this->member->where('organization_name','=',Str::of($row['shipperexporter'])->trim())->first();
        $member = $this->member->where('username','=',Str::of($row['member_no'])->trim()->padLeft(4,'0'))->first();
        $member_id = $member ? $member->id : '1';
//        $on_behalf_of_member = $this->member->where('organization_name','=',Str::of($row['on_behave_of'])->trim())->first();
//        $on_behalf_of_member_id = $on_behalf_of_member ? $on_behalf_of_member->id : '1';
        return new MoneyCollection([
            'member_id' => $member_id ?? NULL,
            'voucher_no' => $row['receipt_no'],
            'transaction_date' => $this->getDateFormat($row['date']),
            'member_name' => $row['member_name'],
            'member_no' => $row['member_no'],
//            'receipt_type' => 'gate_pass',
            'status'=>'Active',
            'payment_type'=> 'Cash',
            'created_user_id' => NULL,
            'created_user_name' => $row['received_by'],
            'created_at' => $this->getDateFormat($row['date']),
//            'receipt_description' => 'No',
            'amount' => $row['amount'],

        ]);
    }

    private function importGatePass(array $row){

//        $member = $this->member->where('organization_name','=',Str::of($row['shipperexporter'])->trim())->first();
        $member = $this->member->where('username','=',Str::of($row['bmn'])->trim()->padLeft(4,'0'))->first();
        $member_id = $member ? $member->id : '1';
        $on_behalf_of_member = $this->member->where('organization_name','=',Str::of($row['on_behave_of'])->trim())->first();
        $on_behalf_of_member_id = $on_behalf_of_member ? $on_behalf_of_member->id : '1';
        return new GatePass([
            'master_airway_bill_no' => $row['mawb_no'],
            'flight_no' => $row['flight_no'],
            'bmn' => $row['bmn'],
            'member' => $row['shipperexporter'], // $member->id ?? NULL,
            'member_id' => $member_id ?? NULL, // $member->id ?? NULL,
            'shipper_invoice_no' => $row['invoice_no'],
            'date' => $this->getDateFormat($row['invoice_date']),
            'weight' => $row['weightapprox'],
            'contents' => $row['contents'],
            'destination' => $row['destination'],
            'routing' => $row['routing'],
            'on_behalf_of_member_id' => $on_behalf_of_member_id,
            'on_behalf_of_member' => $row['on_behave_of'],
            'agent_name' => $row['on_behave_of_name'],
            'agent_id_no' => $row['id_no'],
            'no_of_piece' => $row['no_of_pcs'],
            'gross_weight' => $row['gross_weight'],
            'cbm' => $row['cbm'],
            'vwt' => $row['vwt'],
            'chargeable_weight' => $row['chargable_weight'],
            'dimensioni' => $row['dimensioni'],
            'dimensionii' => $row['dimensionii'],
            'dimensioniii' => $row['dimensioniii'],
            'dimensioniiv' => $row['dimensioniv'],
            'dimensionv' => $row['dimensionv'],
            'dimensionvi' => $row['dimensionvi'],
            'created_by' => $row['created_by'],
            'updated_by' => $row['last_updated_by'],
            'created_at' => $this->getDateFormat($row['created_date']),
            'created_user_id' => '1', // $row['created_by'] ?? '1',
            'updated_at' => $this->getDateFormat($row['last_updated_date']),
            'updated_user_id' => '1' // $row['last_updated_by'] ?? '1',

        ]);

    }

    public function memberPassCollection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $member = $this->member->where('username','=',Str::of($row['bmnid'])->trim()->padLeft(4,'0'))->first();
            if($member){
                $member->password = Str::of($row['gate_pass_password'])->trim();
                $member->update();
            }
        }
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $member = $this->member->where('username','=',Str::of($row['bmn'])->trim()->padLeft(4,'0'))->first();
            if($member){
                $member->id_card_records()->create([
                    'bmn_no' => Str::of($row['bmn'])->trim()->padLeft(4,'0'),
                    'year' => 2021,
                    'total' => $row['total']
                ]);
            }else{
                $id_card = new IdCardRecord();
                $id_card->member_id = '0001';
                $id_card->bmn_no = Str::of($row['bmn'])->trim()->padLeft(4,'0');
                $id_card->year = 2021;
                $id_card->total = $row['total'];
                $id_card->save();
            }
        }
    }

    public function saveMemberDetails(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $name = $this->getFirstName($row['first_name']) ?? NULL;
            $contact_no = $this->getContactNo($row['contact_no']) ?? [];
            $member = new Member();
            $member->username = $row['bmn'];
            $member->email = $this->skipSpace($contact_no['email_address']);
            $member->organization_name = $row['company_name'];
            $member->password = '$2y$10$PEEzpAlNLy10JkagzZngpOeTWQ1sFAkfLI4HK8yti7KvYUbGlRoh.'; // '654321'
            $member->first_name = $name;
            $member->phone = $this->skipSpace($contact_no['mobile_no']);
            $member->status = UserStatus::ACTIVE;
            $member->email_verified_at = (string) now();
            if ($member->save()) {
                $member->member_detail()->create([
//                   'firm_name'     => $row['company_name'],
                    'place_of_enlistment'     => 'Chattogram',
//                    'place_of_enlistment'     => 'Dhaka',
                    'form_submit_date'     => $this->getDateFormat($row['date_of_admission']),
                    'firm_type'     => $this->getFirmName($row['first_name']) ?? NULL,
                    'type_local'     => $row['type_local'],
                    'tin_number'     => Str::of($row['tin_number'])->after('Tin:')->trim() ?? ''
                ]);
                $company_owner = [
                    'name' => $name,
//                    'nid_no' => Str::of($row['nid'])->after('NID:')->trim() ?? '',
                    'mobile_no' => $this->skipSpace($contact_no['mobile_no']),
                    'email' => $this->skipSpace($contact_no['email_address'])
                ];
                $member->company_owners()->create($company_owner);
                $address = $this->getAddress($row['address']);
                $address[0] = array_merge($address[0], $contact_no);
                $member->member_address()->createMany($address);
            }
        }
    }





    private function skipSpace($string){
        return preg_replace('!\s+!', ' ', $string);
    }
    private function getDateFormat($date){
        if($date)
            return date('Y-m-d',strtotime($date));
        else
            return date('Y-m-d H:i:s',time());
    }

    private function getFirstName($first_name){
        $type_of_companies = ['Limited','Director','Managing Director','Chairman','Vice. Chairman & CEO','CEO','Country Manager','CM & Managing Director','CEO & Director','Funder & CEO','Proprietor','Managing Partner','Partner',];
        $member_name = $first_name;
        foreach ($type_of_companies as $name){
            if(Str::of($first_name)->contains($name)){
                $member_name = Str::of($first_name)->before($name)->trim(); //Str::remove($name, $first_name);
            }
        }
        return $member_name;
    }

    private function getFirmName($first_name){
        if(Str::of($first_name)->contains(['Limited','Director','Managing Director','Chairman','Vice. Chairman & CEO','CEO','Country Manager','CM & Managing Director','CEO & Director','Funder & CEO'])){
            $type_of_company = 'Limited';
        }elseif (Str::of($first_name)->contains(['Managing Partner','Partner']))
            $type_of_company = 'Partner';
        else
            $type_of_company = 'Proprietor';
        return $type_of_company;
    }

    private function getAddress($address){
//        $address = $collection[0][1]['address'];
        $offices = [];
        if (Str::containsAll($address, ['Dhaka office', 'Chattogram office'])) {
            if (Str::contains($address, 'Dhaka office')) {
                $dhaka_office = $slice = Str::between($address, 'Dhaka office:', 'Chattogram office');
                $offices[0]['address'] = Str::of($dhaka_office)->trim();
                $offices[0] = Arr::prepend($offices[0], 'register', 'member_address_type');
            }
            if (Str::contains($address, 'Chattogram office')) {
                $chattagram_office = $slice = Str::after($address, 'Chattogram office:');
                $offices[1]['address'] = Str::of($chattagram_office)->trim();
                $offices[1] = Arr::prepend($offices[1], 'branch', 'member_address_type');
            }
        } elseif (Str::contains($address, 'Dhaka office')) {
            $dhaka_office = $slice = Str::after($address, 'Dhaka office:');
            $offices[0]['address'] = Str::of($dhaka_office)->trim();
        } elseif (Str::contains($address, 'Chattogram office')) {
            $chattagram_office = $slice = Str::after($address, 'Chattogram office:');
            $offices[0]['address'] = Str::of($chattagram_office)->trim();
        } else {
            $offices[0]['address'] = Str::of($address)->trim();
        }
        return $offices;

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
