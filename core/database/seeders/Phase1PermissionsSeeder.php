<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Phase1PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // المبيعات
            'view quotation', 'add quotation', 'edit quotation', 'delete quotation',
            'view installment', 'add installment', 'edit installment',
            'view offer', 'add offer', 'edit offer', 'delete offer',
            'view sale return', 'add sale return', 'edit sale return',
            'view credit note', 'add credit note', 'edit credit note',
            'view recurring invoice', 'add recurring invoice', 'edit recurring invoice',
            // POS
            'view cash session', 'open cash session', 'close cash session', 'view pos receipt',
            // Targets
            'view sales target', 'add sales target', 'edit sales target',
            'view commission', 'add commission', 'approve commission', 'view performance',
            // CRM
            'view customer group', 'add customer group', 'edit customer group',
            'view appointment', 'add appointment', 'edit appointment',
            'view customer visit', 'add customer visit',
            'view membership', 'add membership', 'edit membership',
            'view customer insurance', 'add customer insurance',
            // Balances
            'view customer balance', 'edit customer balance',
            'view balance transaction', 'add balance transaction',
            'view balance settlement', 'add balance settlement',
            'view loyalty', 'edit loyalty settings',
            // Inventory
            'view stock adjustment', 'add stock adjustment',
            'view stock transfer', 'add stock transfer',
            'view stock permit', 'add stock permit',
            'view price list', 'add price list', 'edit price list',
            // Purchases
            'view purchase order', 'add purchase order', 'edit purchase order',
            'view purchase return', 'add purchase return',
            // Finance
            'view income', 'add income', 'edit income',
            'view account', 'add account', 'edit account',
            'view transfer', 'add transfer',
            'view check', 'add check', 'edit check',
            // Accounting
            'view chart of accounts', 'edit chart of accounts',
            'view journal', 'add journal', 'edit journal', 'post journal',
            'view ledger',
            'view cost center', 'add cost center',
            'view asset', 'add asset', 'edit asset',
            'view financial report',
            // Operations
            'view work order', 'add work order', 'edit work order',
            'view project', 'add project', 'edit project',
            'view workflow', 'add workflow',
            'view timesheet', 'add timesheet',
            'view rental unit', 'add rental unit',
            'view lease', 'add lease', 'edit lease',
            'view reservation', 'add reservation',
            'view manufacturing', 'add manufacturing',
            // HR
            'view employee', 'add employee', 'edit employee',
            'view attendance', 'add attendance', 'edit attendance',
            'view payroll', 'add payroll', 'process payroll',
            'view contract', 'add contract', 'edit contract',
            'view org structure', 'edit org structure',
            'view leave', 'add leave', 'approve leave',
            'view hr request', 'approve hr request',
            'view advance', 'add advance', 'approve advance',
            // Reports
            'view report', 'view sales report', 'view inventory report',
            'view accounting report', 'view employee report',
            'view customer report', 'view performance report',
            // Branches
            'view branch', 'add branch', 'edit branch',
            'manage branch permission', 'view branch report',
            // Settings
            'view tax', 'add tax', 'edit tax', 'zatca setting',
            'view currency', 'add currency',
            'view template', 'add template', 'edit template',
            'view role', 'add role', 'edit role',
            'notification setting', 'api setting',
        ];

        if (Schema::hasTable('permissions')) {
            $now = now();
            $insertData = [];
            foreach ($permissions as $perm) {
                $insertData[] = [
                    'name'       => $perm,
                    'guard_name' => 'web',
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::table('permissions')->insertOrIgnore($insertData);
            $this->command->info('✅ تمّ إضافة ' . count($permissions) . ' صلاحيّة');

            if (Schema::hasTable('roles') && Schema::hasTable('role_has_permissions')) {
                $superAdminRole = DB::table('roles')
                    ->where('name', 'super-admin')
                    ->orWhere('name', 'admin')
                    ->orWhere('name', 'owner')
                    ->first();

                if ($superAdminRole) {
                    $allNewPerms = DB::table('permissions')
                        ->whereIn('name', $permissions)
                        ->pluck('id');

                    $rolePermData = $allNewPerms->map(fn($pid) => [
                        'role_id'       => $superAdminRole->id,
                        'permission_id' => $pid,
                    ])->toArray();

                    DB::table('role_has_permissions')->insertOrIgnore($rolePermData);
                    $this->command->info("✅ تمّ ربط الصلاحيّات بدور: {$superAdminRole->name}");
                }
            }
        } else {
            $this->command->warn('⚠️ جدول permissions غير موجود — تجاهل');
        }
    }
}