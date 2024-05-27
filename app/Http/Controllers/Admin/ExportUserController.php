<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
class ExportUserController extends Controller
{
    public function export(Request $request)
    {
        $data=$request->idProducts;
        return Excel::download(new UserExport($data), time().'products'.'.xlsx');
    }

}
