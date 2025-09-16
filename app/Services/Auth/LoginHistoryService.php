<?php
namespace App\Services\Auth;


use App\Models\User;
use App\Models\Auth\LoginHistory;


class LoginHistoryService
    {



    public function getAll()
    {
               $history= LoginHistory::select('id', 'user_id', 'ip_address', 'logged_in_at','user_agent')
                ->with(['user:id,username,email'])
                ->orderBy('logged_in_at', 'desc')
                ->get();

                return response()->json($history);
    }

    





}