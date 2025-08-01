<?php

namespace App\Menu\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use Illuminate\Support\Facades\Auth;

class RoleFilter implements FilterInterface
{
    public function transform($item)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return $item;
        }

        $user = Auth::user();
        
        // Check if item has role restriction
        if (isset($item['role'])) {
            $allowedRoles = is_array($item['role']) ? $item['role'] : [$item['role']];
            
            // If user doesn't have required role, hide the menu item
            if (!in_array($user->role, $allowedRoles)) {
                return false;
            }
        }

        // Check submenu items for role restrictions
        if (isset($item['submenu'])) {
            $filteredSubmenu = [];
            
            foreach ($item['submenu'] as $subitem) {
                $filteredSubitem = $this->transform($subitem);
                if ($filteredSubitem !== false) {
                    $filteredSubmenu[] = $filteredSubitem;
                }
            }
            
            // If no submenu items remain, hide the parent menu
            if (empty($filteredSubmenu)) {
                return false;
            }
            
            $item['submenu'] = $filteredSubmenu;
        }

        return $item;
    }
}
