<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use GlobalStatus, SoftDeletes;

    protected $guarded  = ['id'];

    protected $casts = [
        'company_id'  => 'integer',
        'user_id'     => 'integer',
        'employee_id' => 'integer',
        'shift_id'    => 'integer',

        'date'        => 'date',
        'check_in'    => 'datetime',
        'check_out'   => 'datetime',

        'deleted_at'  => 'datetime'
    ];

    public function exportColumns(): array
    {
        return  [
            'company_id' => [
                'name' => "company",
                'callback' => function ($item) {
                    return @$item->company->name;
                }
            ],
            'shift_id' => [
                'name' => "shift",
                'callback' => function ($item) {
                    return @$item->shift->name;
                }
            ],
            'employee_id' => [
                'name' => "employee",
                'callback' => function ($item) {
                    return @$item->employee->name;
                }
            ],
            'date' => [
                'name' => "date",
                'callback' => function ($item) {
                    return showDateTime($item->date);
                }
            ],
            'check_in' => [
                'name' => "check_in",
                'callback' => function ($item) {
                    return showDateTime($item->check_in, 'H:i A');
                }
            ],
            'check_out' => [
                'name' => "check_out",
                'callback' => function ($item) {
                    return showDateTime($item->check_out, 'H:i A');
                }
            ],
            'duration',
        ];
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
