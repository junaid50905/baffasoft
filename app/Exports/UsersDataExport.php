<?php

namespace Vanguard\Exports;
use Vanguard\User;
use Illuminate\COntracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsersDataExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function __construct()
    {
        $users = User::all();
    }
    public function view() : View
    {
        return view('user.partials.row');
    }
}
