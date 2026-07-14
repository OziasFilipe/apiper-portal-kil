<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Company;
use App\Models\Server;
use App\Models\Service;
use App\Models\Integration;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $stats = [
            'total_clients' => Client::count(),
            'total_companies' => Company::count(),
            'total_servers' => Server::count(),
            'total_services' => Service::count(),
            'active_integrations' => Integration::where('status', true)->count(),
            'recent_clients' => Client::latest()->take(5)->get(['id', 'name', 'email', 'status', 'created_at']),
            'recent_services' => Service::latest()->take(5)->get(['id', 'name', 'status', 'price', 'created_at']),
            'server_health' => Server::select('status')->get()->groupBy('status')->map->count(),
        ];

        return $this->success($stats);
    }
}
