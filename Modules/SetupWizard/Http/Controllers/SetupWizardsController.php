<?php

namespace Modules\SetupWizard\Http\Controllers;

use App\Http\Controllers\Controller;

class SetupWizardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('setupwizard::index');
    }
}
