<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        // ─── INVENTORY (الباقي) ───
        $this->safeCreate('stock_permits', function (Blueprint $t) {
            $t->string('permit_no')->nullable();
            $t->string('permit_type');
            $t->unsignedBigInteger('warehouse_id')->nullable();
            $t->date('permit_date')->nullable();
            $t->string('reference_type')->nullable();
            $t->unsignedBigInteger('reference_id')->nullable();
        });

        $this->safeCreate('price_lists', function (Blueprint $t) {
            $t->text('description')->nullable();
            $t->string('currency')->default('SAR');
            $t->date('valid_from')->nullable();
            $t->date('valid_until')->nullable();
            $t->tinyInteger('is_default')->default(0);
        });

        // ─── PURCHASES ───
        $this->safeCreate('purchase_orders', function (Blueprint $t) {
            $t->string('po_number')->nullable();
            $t->unsignedBigInteger('supplier_id')->nullable();
            $t->date('po_date')->nullable();
            $t->date('expected_date')->nullable();
            $t->decimal('total', 15, 2)->default(0);
            $t->tinyInteger('po_status')->default(0);
        });

        $this->safeCreate('purchase_returns', function (Blueprint $t) {
            $t->string('return_no')->nullable();
            $t->unsignedBigInteger('purchase_id')->nullable();
            $t->unsignedBigInteger('supplier_id')->nullable();
            $t->date('return_date')->nullable();
            $t->decimal('total', 15, 2)->default(0);
            $t->text('reason')->nullable();
        });

        // ─── FINANCE ───
        $this->safeCreate('incomes', function (Blueprint $t) {
            $t->string('income_no')->nullable();
            $t->string('category')->nullable();
            $t->date('income_date')->nullable();
            $t->decimal('amount', 15, 2)->default(0);
            $t->unsignedBigInteger('account_id')->nullable();
            $t->text('notes')->nullable();
        });

        $this->safeCreate('bank_accounts', function (Blueprint $t) {
            $t->string('account_number')->nullable();
            $t->string('bank_name')->nullable();
            $t->decimal('opening_balance', 15, 2)->default(0);
            $t->decimal('current_balance', 15, 2)->default(0);
            $t->string('currency')->default('SAR');
        });

        $this->safeCreate('money_transfers', function (Blueprint $t) {
            $t->string('transfer_no')->nullable();
            $t->unsignedBigInteger('from_account_id')->nullable();
            $t->unsignedBigInteger('to_account_id')->nullable();
            $t->decimal('amount', 15, 2)->default(0);
            $t->decimal('fee', 15, 2)->default(0);
            $t->date('transfer_date')->nullable();
            $t->text('notes')->nullable();
        });

        $this->safeCreate('checks', function (Blueprint $t) {
            $t->string('check_number')->nullable();
            $t->string('check_type');
            $t->string('payee')->nullable();
            $t->string('bank_name')->nullable();
            $t->decimal('amount', 15, 2)->default(0);
            $t->date('check_date')->nullable();
            $t->date('due_date')->nullable();
            $t->tinyInteger('check_status')->default(0);
        });

        // ─── ACCOUNTING ───
        $this->safeCreate('chart_of_accounts', function (Blueprint $t) {
            $t->string('account_code')->nullable();
            $t->string('account_type');
            $t->unsignedBigInteger('parent_id')->nullable();
            $t->integer('level')->default(0);
            $t->decimal('opening_balance', 15, 2)->default(0);
            $t->decimal('current_balance', 15, 2)->default(0);
            $t->tinyInteger('is_leaf')->default(1);
        });

        $this->safeCreate('journal_entries', function (Blueprint $t) {
            $t->string('entry_number')->nullable();
            $t->date('entry_date')->nullable();
            $t->text('description')->nullable();
            $t->decimal('total_debit', 15, 2)->default(0);
            $t->decimal('total_credit', 15, 2)->default(0);
            $t->string('reference_type')->nullable();
            $t->unsignedBigInteger('reference_id')->nullable();
            $t->tinyInteger('entry_status')->default(0);
        });

        if (!Schema::hasTable('journal_entry_lines')) {
            Schema::create('journal_entry_lines', function (Blueprint $t) {
                $t->id();
                $t->unsignedBigInteger('journal_entry_id');
                $t->unsignedBigInteger('account_id');
                $t->decimal('debit', 15, 2)->default(0);
                $t->decimal('credit', 15, 2)->default(0);
                $t->text('description')->nullable();
                $t->unsignedBigInteger('cost_center_id')->nullable();
                $t->timestamps();
            });
        }

        $this->safeCreate('cost_centers', function (Blueprint $t) {
            $t->string('code')->nullable();
            $t->unsignedBigInteger('parent_id')->nullable();
            $t->text('description')->nullable();
        });

        $this->safeCreate('fixed_assets', function (Blueprint $t) {
            $t->string('asset_code')->nullable();
            $t->string('category')->nullable();
            $t->date('purchase_date')->nullable();
            $t->decimal('purchase_cost', 15, 2)->default(0);
            $t->decimal('depreciation_rate', 8, 2)->default(0);
            $t->string('depreciation_method')->default('straight_line');
            $t->decimal('current_value', 15, 2)->default(0);
            $t->date('disposal_date')->nullable();
        });

        // ─── OPERATIONS ───
        $this->safeCreate('work_orders', function (Blueprint $t) {
            $t->string('wo_number')->nullable();
            $t->unsignedBigInteger('customer_id')->nullable();
            $t->unsignedBigInteger('assigned_to')->nullable();
            $t->date('start_date')->nullable();
            $t->date('due_date')->nullable();
            $t->string('priority')->default('medium');
            $t->tinyInteger('wo_status')->default(0);
            $t->text('description')->nullable();
        });

        $this->safeCreate('projects', function (Blueprint $t) {
            $t->string('project_code')->nullable();
            $t->unsignedBigInteger('customer_id')->nullable();
            $t->unsignedBigInteger('manager_id')->nullable();
            $t->date('start_date')->nullable();
            $t->date('end_date')->nullable();
            $t->decimal('budget', 15, 2)->default(0);
            $t->decimal('actual_cost', 15, 2)->default(0);
            $t->integer('progress_percentage')->default(0);
            $t->tinyInteger('project_status')->default(0);
        });

        $this->safeCreate('workflows', function (Blueprint $t) {
            $t->text('description')->nullable();
            $t->json('stages')->nullable();
        });

        $this->safeCreate('timesheets', function (Blueprint $t) {
            $t->unsignedBigInteger('employee_id')->nullable();
            $t->unsignedBigInteger('project_id')->nullable();
            $t->unsignedBigInteger('work_order_id')->nullable();
            $t->date('work_date')->nullable();
            $t->time('start_time')->nullable();
            $t->time('end_time')->nullable();
            $t->decimal('hours', 8, 2)->default(0);
            $t->text('description')->nullable();
        });

        $this->safeCreate('rental_units', function (Blueprint $t) {
            $t->string('unit_code')->nullable();
            $t->string('unit_type')->nullable();
            $t->text('description')->nullable();
            $t->decimal('daily_rate', 15, 2)->default(0);
            $t->decimal('monthly_rate', 15, 2)->default(0);
            $t->tinyInteger('availability')->default(1);
        });

        $this->safeCreate('lease_contracts', function (Blueprint $t) {
            $t->string('contract_number')->nullable();
            $t->unsignedBigInteger('customer_id')->nullable();
            $t->unsignedBigInteger('rental_unit_id')->nullable();
            $t->date('start_date')->nullable();
            $t->date('end_date')->nullable();
            $t->decimal('monthly_rent', 15, 2)->default(0);
            $t->decimal('deposit', 15, 2)->default(0);
            $t->tinyInteger('contract_status')->default(1);
        });

        $this->safeCreate('reservations', function (Blueprint $t) {
            $t->string('reservation_no')->nullable();
            $t->unsignedBigInteger('customer_id')->nullable();
            $t->unsignedBigInteger('rental_unit_id')->nullable();
            $t->dateTime('reservation_start')->nullable();
            $t->dateTime('reservation_end')->nullable();
            $t->decimal('deposit', 15, 2)->default(0);
            $t->tinyInteger('reservation_status')->default(0);
        });

        $this->safeCreate('manufacturing_orders', function (Blueprint $t) {
            $t->string('mo_number')->nullable();
            $t->unsignedBigInteger('product_id')->nullable();
            $t->decimal('quantity', 15, 2)->default(0);
            $t->date('start_date')->nullable();
            $t->date('completion_date')->nullable();
            $t->tinyInteger('mo_status')->default(0);
        });

        // ─── HR (الباقي) ───
        $this->safeCreate('contracts', function (Blueprint $t) {
            $t->unsignedBigInteger('employee_id')->nullable();
            $t->string('contract_type')->nullable();
            $t->date('start_date')->nullable();
            $t->date('end_date')->nullable();
            $t->decimal('salary', 15, 2)->default(0);
            $t->text('terms')->nullable();
        });

        $this->safeCreate('org_departments', function (Blueprint $t) {
            $t->unsignedBigInteger('parent_id')->nullable();
            $t->unsignedBigInteger('manager_id')->nullable();
            $t->text('description')->nullable();
        });

        $this->safeCreate('leaves', function (Blueprint $t) {
            $t->unsignedBigInteger('employee_id')->nullable();
            $t->string('leave_type')->nullable();
            $t->date('start_date')->nullable();
            $t->date('end_date')->nullable();
            $t->integer('days_count')->default(0);
            $t->text('reason')->nullable();
            $t->tinyInteger('leave_status')->default(0);
            $t->unsignedBigInteger('approved_by')->nullable();
        });

        $this->safeCreate('hr_requests', function (Blueprint $t) {
            $t->unsignedBigInteger('employee_id')->nullable();
            $t->string('request_type')->nullable();
            $t->text('description')->nullable();
            $t->date('request_date')->nullable();
            $t->tinyInteger('request_status')->default(0);
            $t->unsignedBigInteger('approved_by')->nullable();
        });

        $this->safeCreate('advances', function (Blueprint $t) {
            $t->unsignedBigInteger('employee_id')->nullable();
            $t->decimal('amount', 15, 2)->default(0);
            $t->decimal('paid_amount', 15, 2)->default(0);
            $t->integer('installments_count')->default(1);
            $t->date('request_date')->nullable();
            $t->date('approval_date')->nullable();
            $t->tinyInteger('advance_status')->default(0);
        });

        // ─── BRANCHES & SETTINGS ───
        $this->safeCreate('branches', function (Blueprint $t) {
            $t->string('branch_code')->nullable();
            $t->text('address')->nullable();
            $t->string('phone')->nullable();
            $t->string('email')->nullable();
            $t->unsignedBigInteger('manager_id')->nullable();
        });

        $this->safeCreate('currencies', function (Blueprint $t) {
            $t->string('code')->nullable();
            $t->string('symbol')->nullable();
            $t->decimal('exchange_rate', 15, 6)->default(1);
            $t->tinyInteger('is_default')->default(0);
        });

        $this->safeCreate('print_templates', function (Blueprint $t) {
            $t->string('template_type')->nullable();
            $t->text('content')->nullable();
            $t->json('settings')->nullable();
            $t->tinyInteger('is_default')->default(0);
        });
    }

    /**
     * Helper: ينشئ الجدول فقط لو غير موجود
     */
    private function safeCreate(string $tableName, ?\Closure $extraColumns = null): void
    {
        if (Schema::hasTable($tableName)) {
            return; // الجدول موجود — تخطّى
        }
        Schema::create($tableName, function (Blueprint $table) use ($extraColumns) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('name')->nullable();
            if ($extraColumns) {
                $extraColumns($table);
            }
            $table->tinyInteger('status')->default(1)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $tables = [
            'print_templates','currencies','branches','advances','hr_requests','leaves',
            'org_departments','contracts','manufacturing_orders','reservations','lease_contracts',
            'rental_units','timesheets','workflows','projects','work_orders','fixed_assets',
            'cost_centers','journal_entry_lines','journal_entries','chart_of_accounts',
            'checks','money_transfers','bank_accounts','incomes','purchase_returns',
            'purchase_orders','price_lists','stock_permits',
        ];
        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
};