<?php

namespace App\Http\Controllers\FinancementProjet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinancementProjet extends Controller
{
    public function financement()
    {
        return view('financementProjet.financement');
    }
}
