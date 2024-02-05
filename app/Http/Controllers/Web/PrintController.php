<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Support\Str;
use PDF;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Resources\MemberResource;
use Vanguard\Http\Resources\RenewMemberResource;
use Vanguard\IdCard;
use Vanguard\Member;
use Vanguard\MoneyCollection;
use Vanguard\RenewMember;
use Vanguard\Voter;

class PrintController extends Controller
{
    /*
     * URL
     * https://github.com/barryvdh/laravel-dompdf
     * http://localhost/baffasoft/print_id_card/1
*/
    public function __construct()
    {
        $this->middleware('auth')->only('money_receipt');
        $this->middleware('auth:front')->only('member_money_receipt');

    }

    public function print_member(Member $member)
    {
//        return $member;
        $member = Member::with(['member_detail', 'member_address', 'company_owners', 'privileges'])->findOrFail($member->id);
        $member = new MemberResource($member);
//        return $member;
//        return view('print.member',compact('member'));
        $pdf = PDF::loadView('print.member', compact('member'));
        return $pdf->stream();         //        return $pdf->download('pdf_file.pdf');
    }

    public function print_renew_member(RenewMember $renew_member)
    {
        $renewMember = RenewMember::with(['renew_member_address', 'contact_person'])->findOrFail($renew_member->id);
        $renew_member = new RenewMemberResource($renewMember);
        if (count($renew_member->contact_person))
            $contact_person = $renew_member->contact_person[0];
        else
            $contact_person = [];
//        return view('print.renew_member', compact('renew_member', 'contact_person'));
        $pdf = PDF::loadView('print.renew_member', compact('renew_member', 'contact_person'));
        return $pdf->stream();         //        return $pdf->download('pdf_file.pdf');
    }

    public function id_card(IdCard $id_card)
    {
//        return $id_card;
        $company_owner_name = '';
        if ($id_card->company_owner_id) {
            $company_owner_name = $id_card->company_owner->name;
        }
        $organization_names = $id_card->members->map(function ($name) {
            return $name->organization_name;
        });
//        return view('print.id_card',compact('id_card','company_owner_name','organization_names'));
        $pdf = PDF::loadView('print.id_card', compact('id_card', 'company_owner_name', 'organization_names'));
        return $pdf->stream();         //        return $pdf->download('pdf_file.pdf');
    }

    public function voter(Voter $voter)
    {
        $bar_code = Str::of(Str::random(3))->append($voter->voter_number)->append(Str::random(3));
        $voter_name = $voter->voter_name;
        $voter_number = $voter->voter_number;
        $voter_image = $voter->voter_image;
        $election_name = $voter->election->name;
        $election_chairman = $voter->election->chairman_name;
        $election_chairman_signature = $voter->election->attachment_chairman_signature;
        $company_owner_name = '';
        if ($voter->member_id) {
            $company_owner_name = $voter->member->organization_name;
        }
//        return view('print.voter',compact('voter','company_owner_name','bar_code','election_name'));

        $pdf = PDF::loadView('print.voter', compact('bar_code', 'company_owner_name', 'voter_name', 'voter_number', 'voter_image', 'election_name', 'election_chairman', 'election_chairman_signature'));
        // return $company_owner_name;
        return $pdf->stream();         //        return $pdf->download('pdf_file.pdf');
    }

    private function gen_uid($l = 3)
    {
        return substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 10, $l);
    }

    public function membership_id_card(IdCard $id_card)
    {
//        return base_path('public');
//        return baffasoft_url('attached_images/id_cards/21/v1A43WANdVVpWbQ.JPEG');
//        return $id_card->form_year;
//        return $id_card;
        $company_owner_name = '';
        if ($id_card->company_owner_id) {
            $company_owner_name = $id_card->company_owner->name;
        }

//        return $id_card;


        $organization_names = $id_card->members->map(function ($name) {
            return $name->organization_name;
        });

        $organization_names = json_decode(json_encode($organization_names), true);

        $organization_names = implode(",", $organization_names);

//        return view('print.owner_id_card', compact('id_card','company_owner_name','organization_names'));

        //return view('print.member_id_card', compact('id_card','company_owner_name','organization_names'));

        if ($id_card->card_type == 'Owner')
            $pdf = PDF::loadView('print.owner_id_card', compact('id_card', 'company_owner_name', 'organization_names'));
        else
            $pdf = PDF::loadView('print.member_id_card', compact('id_card', 'company_owner_name', 'organization_names'));
        return $pdf->stream();
        //        return PDF::loadView('print.myPDF')->stream();

    }

    /*
     * URL
     * http://localhost/baffasoft/print_money_receipt/1
*/
    public function member_money_receipt(MoneyCollection $money_collection)
    {
        if ($money_collection->member_id === auth('front')->user()->id) {
//            return $money_collection;
            $organization_name = $money_collection->member->organization_name;
            $pdf = PDF::loadView('print.money_receipt', compact('money_collection', 'organization_name'));
            return $pdf->stream();
        } else {
            return 'Sorry, Please Contact with Baffa.';
        }
    }

    public function money_receipt(MoneyCollection $money_collection)
    {
//        return $money_collection;
        $organization_name = $money_collection->member->organization_name;
        // return view('print.money_receipt',compact('money_collection','organization_name'));
        $pdf = PDF::loadView('print.money_receipt', compact('money_collection', 'organization_name'));
        return $pdf->stream();         //        return $pdf->download('pdf_file.pdf');
//        return PDF::loadView('print.myPDF')->stream();
//        return view('print.myPDF');
    }
}
