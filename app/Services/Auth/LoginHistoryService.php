<?php
namespace App\Services\Auth;


use App\Models\User;
use App\Models\Auth\LoginHistory;


class LoginHistoryService
    {



    public function getAll($page, $perPage)
    {
               $history= LoginHistory::select('id', 'user_id', 'ip_address', 'logged_in_at','user_agent')
                ->with(['user:id,username,email'])
                ->orderBy('logged_in_at', 'desc')
                ->paginate($perPage, ['*'], 'page', $page);

                  // Usa un string simple para la relación con las columnas
  

                return response()->json([
        'data' => $history->items(),
        'pagination' => [
            'current_page' => $history->currentPage(),
            'last_page' => $history->lastPage(),
            'per_page' => $history->perPage(),
            'total' => $history->total(),
            'next_page_url' => $history->nextPageUrl(),
            'prev_page_url' => $history->previousPageUrl(),
        ]
    ]);
    
    }

    





}