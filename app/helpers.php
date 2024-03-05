<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Role;

if (!function_exists('getAccessRights')) {
    function getAccessRights()
    {
        // Check if a user is authenticated
        if (Auth::check()) {
            // Get the authenticated user's role
            $loginUserRole = Auth::user()->role;
            
            // Fetch role rights associated with the user's role
            $roleRights = Role::where('alias', $loginUserRole)->first();
            
            // Initialize access rights array
            $accessRights = [];
            
            // If role rights are found, decode access rights
            if (!empty($roleRights)) {
                $accessRights = json_decode($roleRights->access_rights, true);
            }
            
            return $accessRights;
        }

        // Return an empty array if the user is not authenticated or no role rights are found
        return [];
    }
}
