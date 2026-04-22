<?php

namespace App\Http\Controllers;

use App\Models\Halaqah;
use Illuminate\Http\Request;

class TahfidzController extends Controller
{
    public function halaqahData()
    {
        $halaqah = Halaqah::paginate(20);

        return view('pages.tahfidz.halaqahData', compact('halaqah'));
    }
}
