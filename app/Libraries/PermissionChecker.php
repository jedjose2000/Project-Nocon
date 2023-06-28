<?php

namespace App\Libraries;

class PermissionChecker
{
    public function hasPermission($module, $action)
    {
        $session = session();
        $userRole = $session->get('user_level');

        // Retrieve permissions from the database based on user role
        $permissions = $this->getPermissionsByRole($userRole);

        // Check if the user's role has the requested module and action permissions
        if (isset($permissions[$module]) && in_array($action, $permissions[$module])) {
            return true;
        }

        return false;
    }

    private function getPermissionsByRole($userRole)
    {
        // Retrieve permissions from the database based on user role
        $permissions = [];

        // Query the database to retrieve permissions based on the user role
        $db = \Config\Database::connect();
        $query = $db->table('tblroles')
            ->select('tblpermissions.module, tblpermissions.function')
            ->join('tbluserpermissions', 'tblroles.id = tbluserpermissions.roleId')
            ->join('tblpermissions', 'tbluserpermissions.permission_id = tblpermissions.id')
            ->where('tblroles.id', $userRole)
            ->get();

        // Build the permissions array based on the query results
        foreach ($query->getResult() as $row) {
            $module = $row->module;
            $function = $row->function;

            if (!isset($permissions[$module])) {
                $permissions[$module] = [];
            }

            $permissions[$module][] = $function;
        }

        return $permissions;
    }
}
