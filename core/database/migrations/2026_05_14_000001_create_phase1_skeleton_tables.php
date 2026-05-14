<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
|  Migration: Phase 1 — Skeleton tables for all 16 menus
|--------------------------------------------------------------------------
| 
| هذا الـmigration ينشئ هيكل أساسي لكل الجداول الجديدة المطلوبة للـ16 منيو.
| كل جدول فيه فقط الأعمدة الأساسيّة (id, user_id, name, status, timestamps).
| 
| في كل مرحلة قادمة (دردشة لكل منيو) سنضيف الأعمدة المخصّصة عبر migrations منفصلة.
| 
| اسم الملف الموصى به:
|   YYYY_MM_DD_HHMMSS_create_phase1_skeleton_tables.php
|   مثال: 2026_05_14_000001_create_phase1_skeleton_tables.php
| 
| ضعه في: core/database/migrations/
| ثم: php artisan migrate
|
*/

return new class extends Migration {

    public function up(): void
    {
        // ═══════════════════════════════════════════════════════
        // SALES (المبيعات) — جداول جديدة
        // ═══════════════════════════════════════════════════════
        $this->createBasic('quotations', function (Blueprint $t) {
            $t->string('quotation_no')->nullable();
            $t->unsignedBigInteger('customer_id')->nullable();
            $t->date('quotation_date')->nullable();
            $t->date('valid_until')->nullable();
            $t->decimal('subtotal', 15, 2)->default(0);
            $t->decimal('tax', 15, 2)->default(0);
            $t->decimal('discount', 15, 2)->default(0);
            $t->decimal('total', 15, 2)->default(0);
            $t->tinyInteger('quotation_status')->default(0)->comment('0=draft, 1=sent, 2=accepted, 3=rejected, 4=expired');
            $t->text('notes')->nullable();
        });

        $this->createBasic('installments', function (Blueprint $t) {
            $t->unsignedBigInteger('sale_id')->nullable();
            $t->unsignedBigInteger('customer_id')->nullable();
            $t->integer('total_installments')->default(0);
            $t->integer('paid_installments')->default(0);
            $t->decimal('installment_amount', 15, 2)->default(0);
            $t->decimal('total_amount', 15, 2)->default(0);
            $t->date('start_date')->nullable();
            $t->string('frequency')->default('monthly')->comment('weekly, monthly, quarterly');
            $t->tinyInteger('installment_status')->default(0)->comment('0=active, 1=completed, 2=defaulted');
        });

        Schema::create('installment_schedule', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('installment_id');
            $t->integer('installment_number');
            $t->date('due_date');
            $t->decimal('amount', 15, 2);
            $t->decimal('paid_amount', 15, 2)->default(0);
            $t->date('paid_date')->nullable();
            $t->tinyInteger('status')->default(0)->comment('0=pending, 1=paid, 2=overdue');
            $t->timestamps();
        });

        $this->createBasic('offers', function (Blueprint $t) {
            $t->string('code')->nullable();
            $t->text('description')->nullable();
            $t->string('discount_type')->default('percentage')->comment('percentage, fixed');
            $t->decimal('discount_value', 15, 2)->default(0);
            $t->decimal('min_purchase', 15, 2)->default(0);
            $t->date('start_date')->nullable();
            $t->date('end_date')->nullable();
            $t->integer('usage_limit')->nullable();
            $t->integer('used_count')->default(0);
        });

        $this->createBasic('sale_returns', function (Blueprint $t) {
            $t->string('return_no')->nullable();
            $t->unsignedBigInteger('sale_id')->nullable();
            $t->unsignedBigInteger('customer_id')->nullable();
            $t->date('return_date')->nullable();
            $t->decimal('total', 15, 2)->default(0);
            $t->text('reason')->nullable();
            $t->tinyInteger('return_status')->default(0);
        });

        $this->createBasic('credit_notes', function (Blueprint $t) {
            $t->string('credit_note_no')->nullable();
            $t->unsignedBigInteger('customer_id')->nullable();
            $t->unsignedBigInteger('sale_id')->nullable();
            $t->date('issue_date')->nullable();
            $t->decimal('amount', 15, 2)->default(0);
            $t->text('reason')->nullable();
        });

        $this->createBasic('recurring_invoices', function (Blueprint $t) {
            $t->unsignedBigInteger('customer_id')->nullable();
            $t->decimal('amount', 15, 2)->default(0);
            $t->string('frequency')->default('monthly');
            $t->date('start_date')->nullable();
            $t->date('end_date')->nullable();
            $t->date('next_run_date')->nullable();
            $t->json('items')->nullable();
        });

        // ═══════════════════════════════════════════════════════
        // POS (نقاط البيع) — جداول جديدة
        // ═══════════════════════════════════════════════════════
        $this->createBasic('cash_sessions', function (Blueprint $t) {
            $t->unsignedBigInteger('cashier_id')->nullable();
            $t->unsignedBigInteger('warehouse_id')->nullable();
            $t->dateTime('opened_at')->nullable();
            $t->dateTime('closed_at')->nullable();
            $t->decimal('opening_balance', 15, 2)->default(0);
            $t->decimal('closing_balance', 15, 2)->default(0);
            $t->decimal('expected_balance', 15, 2)->default(0);
            $t->decimal('difference', 15, 2)->default(0);
            $t->tinyInteger('session_status')->default(0)->comment('0=open, 1=closed');
            $t->text('notes')->nullable();
        });

        // ═══════════════════════════════════════════════════════
        // TARGETS & COMMISSIONS (الأهداف والعمولات)
        // ═══════════════════════════════════════════════════════
        $this->createBasic('sales_targets', function (Blueprint $t) {
            $t->unsignedBigInteger('employee_id')->nullable();
            $t->string('target_type')->default('monthly');
            $t->decimal('target_amount', 15, 2)->default(0);
            $t->decimal('achieved_amount', 15, 2)->default(0);
            $t->date('period_start')->nullable();
            $t->date('period_end')->nullable();
        });

        $this->createBasic('commissions', function (Blueprint $t) {
            $t->unsignedBigInteger('employee_id')->nullable();
            $t->unsignedBigInteger('sale_id')->nullable();
            $t->string('commission_type')->default('percentage');
            $t->decimal('commission_rate', 8, 2)->default(0);
            $t->decimal('commission_amount', 15, 2)->default(0);
            $t->date('commission_date')->nullable();
            $t->tinyInteger('commission_status')->default(0)->comment('0=pending, 1=approved, 2=paid');
        });

        // ═══════════════════════════════════════════════════════
        // CRM EXTENSIONS (العملاء)
        // ═══════════════════════════════════════════════════════
        $this->createBasic('customer_groups', function (Blueprint $t) {
            $t->text('description')->nullable();
            $t->decimal('discount_percentage', 8, 2)->default(0);
            $t->string('color')->nullable();
        });

        $this->createBasic('appointments', function (Blueprint $t) {
            $t->unsignedBigInteger('customer_id')->nullable();
            $t->unsignedBigInteger('employee_id')->nullable();
            $t->string('title')->nullable();
            $t->text('description')->nullable();
            $t->dateTime('appointment_date')->nullable();
            $t->integer('duration_minutes')->default(60);
            $t->tinyInteger('appointment_status')->default(0)->comment('0=scheduled, 1=confirmed, 2=completed, 3=cancelled');
        });

        $this->createBasic('customer_visits', function (Blueprint $t) {
            $t->unsignedBigInteger('customer_id')->nullable();
            $t->dateTime('check_in')->nullable();
            $t->dateTime('check_out')->nullable();
            $t->text('notes')->nullable();
        });

        $this->createBasic('memberships', function (Blueprint $t) {
            $t->unsignedBigInteger('customer_id')->nullable();
            $t->string('membership_type')->nullable();
            $t->decimal('subscription_fee', 15, 2)->default(0);
            $t->date('start_date')->nullable();
            $t->date('end_date')->nullable();
            $t->tinyInteger('is_active')->default(1);
        });

        $this->createBasic('customer_insurances', function (Blueprint $t) {
            $t->unsignedBigInteger('customer_id')->nullable();
            $t->string('insurance_company')->nullable();
            $t->string('policy_number')->nullable();
            $t->decimal('coverage_amount', 15, 2)->default(0);
            $t->date('valid_from')->nullable();
            $t->date('valid_until')->nullable();
        });

        // ═══════════════════════════════════════════════════════
        // POINTS & BALANCES (النقاط والأرصدة)
        // ═══════════════════════════════════════════════════════
        $this->createBasic('customer_balances', function (Blueprint $t) {
            $t->unsignedBigInteger('customer_id')->nullable();
            $t->decimal('balance', 15, 2)->default(0);
            $t->decimal('credit_limit', 15, 2)->default(0);
        });

        $this->createBasic('balance_transactions', function (Blueprint $t) {
            $t->unsignedBigInteger('customer_id')->nullable();
            $t->string('trx_type')->comment('credit, debit');
            $t->decimal('amount', 15, 2)->default(0);
            $t->decimal('balance_after', 15, 2)->default(0);
            $t->text('description')->nullable();
            $t->string('reference')->nullable();
        });

        // ═══════════════════════════════════════════════════════
        // LOYALTY (نقاط الولاء)
        // ═══════════════════════════════════════════════════════
        $this->createBasic('loyalty_settings', function (Blueprint $t) {
            $t->decimal('points_per_currency', 8, 2)->default(1);
            $t->decimal('currency_per_point', 8, 4)->default(0.01);
            $t->decimal('min_redemption', 15, 2)->default(0);
            $t->integer('points_expiry_months')->nullable();
        });

        $this->createBasic('loyalty_transactions', function (Blueprint $t) {
            $t->unsignedBigInteger('customer_id')->nullable();
            $t->string('trx_type')->comment('earned, redeemed, expired, adjusted');
            $t->integer('points')->default(0);
            $t->integer('points_balance')->default(0);
            $t->unsignedBigInteger('sale_id')->nullable();
            $t->text('description')->nullable();
            $t->date('expires_at')->nullable();
        });

        // ═══════════════════════════════════════════════════════
        // INVENTORY EXTENSIONS (المخزون)
        // ═══════════════════════════════════════════════════════
        $this->createBasic('stock_adjustments', function (Blueprint $t) {
            $t->string('adjustment_no')->nullable();
            $t->unsignedBigInteger('warehouse_id')->nullable();
            $t->date('adjustment_date')->nullable();
            $t->string('adjustment_type')->comment('addition, subtraction, recount');
            $t->text('reason')->nullable();
        });

        $this->createBasic('stock_transfers', function (Blueprint $t) {
            $t->string('transfer_no')->nullable();
            $t->unsignedBigInteger('from_warehouse_id')->nullable();
            $t->unsignedBigInteger('to_warehouse_id')->nullable();
            $t->date('transfer_date')->nullable();
            $t->tinyInteger('transfer_status')->default(0)->comment('0=draft, 1=in_transit, 2=received');
            $t->text('notes')->nullable();
        });

        $this->createBasic('stock_permits', function (Blueprint $t) {
            $t->string('permit_no')->nullable();
            $t->string('permit_type')->comment('issue, receive');
            $t->unsignedBigInteger('warehouse_id')->nullable();
            $t->date('permit_date')->nullable();
            $t->string('reference_type')->nullable()->comment('sale, purchase, transfer, adjustment');
            $t->unsignedBigInteger('reference_id')->nullable();
        });

        $this->createBasic('price_lists', function (Blueprint $t) {
            $t->text('description')->nullable();
            $t->string('currency')->default('SAR');
            $t->date('valid_from')->nullable();
            $t->date('valid_until')->nullable();
            $t->tinyInteger('is_default')->default(0);
        });

        // ═══════════════════════════════════════════════════════
        // PURCHASES (المشتريات)
        // ═══════════════════════════════════════════════════════
        $this->createBasic('purchase_orders', function (Blueprint $t) {
            $t->string('po_number')->nullable();
            $t->unsignedBigInteger('supplier_id')->nullable();
            $t->date('po_date')->nullable();
            $t->date('expected_date')->nullable();
            $t->decimal('total', 15, 2)->default(0);
            $t->tinyInteger('po_status')->default(0)->comment('0=draft, 1=sent, 2=partial, 3=received');
        });

        $this->createBasic('purchase_returns', function (Blueprint $t) {
            $t->string('return_no')->nullable();
            $t->unsignedBigInteger('purchase_id')->nullable();
            $t->unsignedBigInteger('supplier_id')->nullable();
            $t->date('return_date')->nullable();
            $t->decimal('total', 15, 2)->default(0);
            $t->text('reason')->nullable();
        });

        // ═══════════════════════════════════════════════════════
        // FINANCE (المالية)
        // ═══════════════════════════════════════════════════════
        $this->createBasic('incomes', function (Blueprint $t) {
            $t->string('income_no')->nullable();
            $t->string('category')->nullable();
            $t->date('income_date')->nullable();
            $t->decimal('amount', 15, 2)->default(0);
            $t->unsignedBigInteger('account_id')->nullable();
            $t->text('notes')->nullable();
        });

        $this->createBasic('bank_accounts', function (Blueprint $t) {
            $t->string('account_number')->nullable();
            $t->string('bank_name')->nullable();
            $t->decimal('opening_balance', 15, 2)->default(0);
            $t->decimal('current_balance', 15, 2)->default(0);
            $t->string('currency')->default('SAR');
        });

        $this->createBasic('money_transfers', function (Blueprint $t) {
            $t->string('transfer_no')->nullable();
            $t->unsignedBigInteger('from_account_id')->nullable();
            $t->unsignedBigInteger('to_account_id')->nullable();
            $t->decimal('amount', 15, 2)->default(0);
            $t->decimal('fee', 15, 2)->default(0);
            $t->date('transfer_date')->nullable();
            $t->text('notes')->nullable();
        });

        $this->createBasic('checks', function (Blueprint $t) {
            $t->string('check_number')->nullable();
            $t->string('check_type')->comment('issued, received');
            $t->string('payee')->nullable();
            $t->string('bank_name')->nullable();
            $t->decimal('amount', 15, 2)->default(0);
            $t->date('check_date')->nullable();
            $t->date('due_date')->nullable();
            $t->tinyInteger('check_status')->default(0)->comment('0=pending, 1=cleared, 2=bounced, 3=cancelled');
        });

        // ═══════════════════════════════════════════════════════
        // GENERAL ACCOUNTING (المحاسبة العامّة)
        // ═══════════════════════════════════════════════════════
        $this->createBasic('chart_of_accounts', function (Blueprint $t) {
            $t->string('account_code')->nullable();
            $t->string('account_type')->comment('asset, liability, equity, revenue, expense');
            $t->unsignedBigInteger('parent_id')->nullable();
            $t->integer('level')->default(0);
            $t->decimal('opening_balance', 15, 2)->default(0);
            $t->decimal('current_balance', 15, 2)->default(0);
            $t->tinyInteger('is_leaf')->default(1);
        });

        $this->createBasic('journal_entries', function (Blueprint $t) {
            $t->string('entry_number')->nullable();
            $t->date('entry_date')->nullable();
            $t->text('description')->nullable();
            $t->decimal('total_debit', 15, 2)->default(0);
            $t->decimal('total_credit', 15, 2)->default(0);
            $t->string('reference_type')->nullable();
            $t->unsignedBigInteger('reference_id')->nullable();
            $t->tinyInteger('entry_status')->default(0)->comment('0=draft, 1=posted');
        });

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

        $this->createBasic('cost_centers', function (Blueprint $t) {
            $t->string('code')->nullable();
            $t->unsignedBigInteger('parent_id')->nullable();
            $t->text('description')->nullable();
        });

        $this->createBasic('fixed_assets', function (Blueprint $t) {
            $t->string('asset_code')->nullable();
            $t->string('category')->nullable();
            $t->date('purchase_date')->nullable();
            $t->decimal('purchase_cost', 15, 2)->default(0);
            $t->decimal('depreciation_rate', 8, 2)->default(0);
            $t->string('depreciation_method')->default('straight_line');
            $t->decimal('current_value', 15, 2)->default(0);
            $t->date('disposal_date')->nullable();
        });

        // ═══════════════════════════════════════════════════════
        // OPERATIONS (إدارة العمليات)
        // ═══════════════════════════════════════════════════════
        $this->createBasic('work_orders', function (Blueprint $t) {
            $t->string('wo_number')->nullable();
            $t->unsignedBigInteger('customer_id')->nullable();
            $t->unsignedBigInteger('assigned_to')->nullable();
            $t->date('start_date')->nullable();
            $t->date('due_date')->nullable();
            $t->string('priority')->default('medium');
            $t->tinyInteger('wo_status')->default(0)->comment('0=pending, 1=in_progress, 2=completed, 3=cancelled');
            $t->text('description')->nullable();
        });

        $this->createBasic('projects', function (Blueprint $t) {
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

        $this->createBasic('workflows', function (Blueprint $t) {
            $t->text('description')->nullable();
            $t->json('stages')->nullable();
        });

        $this->createBasic('timesheets', function (Blueprint $t) {
            $t->unsignedBigInteger('employee_id')->nullable();
            $t->unsignedBigInteger('project_id')->nullable();
            $t->unsignedBigInteger('work_order_id')->nullable();
            $t->date('work_date')->nullable();
            $t->time('start_time')->nullable();
            $t->time('end_time')->nullable();
            $t->decimal('hours', 8, 2)->default(0);
            $t->text('description')->nullable();
        });

        $this->createBasic('rental_units', function (Blueprint $t) {
            $t->string('unit_code')->nullable();
            $t->string('unit_type')->nullable();
            $t->text('description')->nullable();
            $t->decimal('daily_rate', 15, 2)->default(0);
            $t->decimal('monthly_rate', 15, 2)->default(0);
            $t->tinyInteger('availability')->default(1);
        });

        $this->createBasic('lease_contracts', function (Blueprint $t) {
            $t->string('contract_number')->nullable();
            $t->unsignedBigInteger('customer_id')->nullable();
            $t->unsignedBigInteger('rental_unit_id')->nullable();
            $t->date('start_date')->nullable();
            $t->date('end_date')->nullable();
            $t->decimal('monthly_rent', 15, 2)->default(0);
            $t->decimal('deposit', 15, 2)->default(0);
            $t->tinyInteger('contract_status')->default(1);
        });

        $this->createBasic('reservations', function (Blueprint $t) {
            $t->string('reservation_no')->nullable();
            $t->unsignedBigInteger('customer_id')->nullable();
            $t->unsignedBigInteger('rental_unit_id')->nullable();
            $t->dateTime('reservation_start')->nullable();
            $t->dateTime('reservation_end')->nullable();
            $t->decimal('deposit', 15, 2)->default(0);
            $t->tinyInteger('reservation_status')->default(0);
        });

        $this->createBasic('manufacturing_orders', function (Blueprint $t) {
            $t->string('mo_number')->nullable();
            $t->unsignedBigInteger('product_id')->nullable();
            $t->decimal('quantity', 15, 2)->default(0);
            $t->date('start_date')->nullable();
            $t->date('completion_date')->nullable();
            $t->tinyInteger('mo_status')->default(0);
        });

        // ═══════════════════════════════════════════════════════
        // HR (الموارد البشرية)
        // ═══════════════════════════════════════════════════════
        $this->createBasic('employees', function (Blueprint $t) {
            $t->string('employee_code')->nullable();
            $t->string('email')->nullable();
            $t->string('phone')->nullable();
            $t->string('national_id')->nullable();
            $t->string('position')->nullable();
            $t->string('department')->nullable();
            $t->date('hire_date')->nullable();
            $t->decimal('basic_salary', 15, 2)->default(0);
            $t->unsignedBigInteger('manager_id')->nullable();
            $t->unsignedBigInteger('branch_id')->nullable();
        });

        $this->createBasic('attendances', function (Blueprint $t) {
            $t->unsignedBigInteger('employee_id')->nullable();
            $t->date('attendance_date')->nullable();
            $t->time('check_in')->nullable();
            $t->time('check_out')->nullable();
            $t->decimal('worked_hours', 8, 2)->default(0);
            $t->decimal('overtime_hours', 8, 2)->default(0);
            $t->string('attendance_status')->default('present');
        });

        $this->createBasic('payrolls', function (Blueprint $t) {
            $t->unsignedBigInteger('employee_id')->nullable();
            $t->date('pay_period_start')->nullable();
            $t->date('pay_period_end')->nullable();
            $t->decimal('basic_salary', 15, 2)->default(0);
            $t->decimal('allowances', 15, 2)->default(0);
            $t->decimal('overtime', 15, 2)->default(0);
            $t->decimal('bonuses', 15, 2)->default(0);
            $t->decimal('deductions', 15, 2)->default(0);
            $t->decimal('advance_deducted', 15, 2)->default(0);
            $t->decimal('net_salary', 15, 2)->default(0);
            $t->date('payment_date')->nullable();
            $t->tinyInteger('payroll_status')->default(0);
        });

        $this->createBasic('contracts', function (Blueprint $t) {
            $t->unsignedBigInteger('employee_id')->nullable();
            $t->string('contract_type')->nullable();
            $t->date('start_date')->nullable();
            $t->date('end_date')->nullable();
            $t->decimal('salary', 15, 2)->default(0);
            $t->text('terms')->nullable();
        });

        $this->createBasic('org_departments', function (Blueprint $t) {
            $t->unsignedBigInteger('parent_id')->nullable();
            $t->unsignedBigInteger('manager_id')->nullable();
            $t->text('description')->nullable();
        });

        $this->createBasic('leaves', function (Blueprint $t) {
            $t->unsignedBigInteger('employee_id')->nullable();
            $t->string('leave_type')->nullable();
            $t->date('start_date')->nullable();
            $t->date('end_date')->nullable();
            $t->integer('days_count')->default(0);
            $t->text('reason')->nullable();
            $t->tinyInteger('leave_status')->default(0)->comment('0=pending, 1=approved, 2=rejected');
            $t->unsignedBigInteger('approved_by')->nullable();
        });

        $this->createBasic('hr_requests', function (Blueprint $t) {
            $t->unsignedBigInteger('employee_id')->nullable();
            $t->string('request_type')->nullable();
            $t->text('description')->nullable();
            $t->date('request_date')->nullable();
            $t->tinyInteger('request_status')->default(0);
            $t->unsignedBigInteger('approved_by')->nullable();
        });

        $this->createBasic('advances', function (Blueprint $t) {
            $t->unsignedBigInteger('employee_id')->nullable();
            $t->decimal('amount', 15, 2)->default(0);
            $t->decimal('paid_amount', 15, 2)->default(0);
            $t->integer('installments_count')->default(1);
            $t->date('request_date')->nullable();
            $t->date('approval_date')->nullable();
            $t->tinyInteger('advance_status')->default(0);
        });

        // ═══════════════════════════════════════════════════════
        // BRANCHES (الفروع)
        // ═══════════════════════════════════════════════════════
        $this->createBasic('branches', function (Blueprint $t) {
            $t->string('branch_code')->nullable();
            $t->text('address')->nullable();
            $t->string('phone')->nullable();
            $t->string('email')->nullable();
            $t->unsignedBigInteger('manager_id')->nullable();
        });

        // ═══════════════════════════════════════════════════════
        // SETTINGS EXTENSIONS (الإعدادات)
        // ═══════════════════════════════════════════════════════
        $this->createBasic('taxes', function (Blueprint $t) {
            $t->decimal('rate', 8, 2)->default(0);
            $t->string('tax_type')->default('percentage');
            $t->tinyInteger('is_compound')->default(0);
        });

        $this->createBasic('currencies', function (Blueprint $t) {
            $t->string('code')->nullable();
            $t->string('symbol')->nullable();
            $t->decimal('exchange_rate', 15, 6)->default(1);
            $t->tinyInteger('is_default')->default(0);
        });

        $this->createBasic('print_templates', function (Blueprint $t) {
            $t->string('template_type')->nullable()->comment('invoice, receipt, quotation, etc');
            $t->text('content')->nullable();
            $t->json('settings')->nullable();
            $t->tinyInteger('is_default')->default(0);
        });
    }

    /**
     * Helper: create a basic table with standard columns + extra columns from callback
     */
    private function createBasic(string $tableName, ?\Closure $extraColumns = null): void
    {
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
            // settings
            'print_templates', 'currencies', 'taxes',
            // branches
            'branches',
            // hr
            'advances', 'hr_requests', 'leaves', 'org_departments', 'contracts',
            'payrolls', 'attendances', 'employees',
            // operations
            'manufacturing_orders', 'reservations', 'lease_contracts', 'rental_units',
            'timesheets', 'workflows', 'projects', 'work_orders',
            // accounting
            'fixed_assets', 'cost_centers', 'journal_entry_lines', 'journal_entries', 'chart_of_accounts',
            // finance
            'checks', 'money_transfers', 'bank_accounts', 'incomes',
            // purchases
            'purchase_returns', 'purchase_orders',
            // inventory
            'price_lists', 'stock_permits', 'stock_transfers', 'stock_adjustments',
            // loyalty
            'loyalty_transactions', 'loyalty_settings',
            // points & balances
            'balance_transactions', 'customer_balances',
            // crm
            'customer_insurances', 'memberships', 'customer_visits', 'appointments', 'customer_groups',
            // targets
            'commissions', 'sales_targets',
            // pos
            'cash_sessions',
            // sales
            'recurring_invoices', 'credit_notes', 'sale_returns', 'offers',
            'installment_schedule', 'installments', 'quotations',
        ];

        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
};
