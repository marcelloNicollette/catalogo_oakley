<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;

class LeadController extends Controller
{
    public function index()
    {
        $counts = [
            'total' => Lead::count(),
            'won'   => Lead::where('status', 'won')->count(),
            'lost'  => Lead::where('status', 'lost')->count(),
        ];

        $pipelines = Lead::all()
            ->groupBy('status')
            ->map(fn($group) => $group->map(fn($lead) => (object)[
                'title' => $lead->title,
                'contact_name' => $lead->contact_name,
            ]));

        return view('admin.leads.index', compact('counts', 'pipelines'));
    }
}
