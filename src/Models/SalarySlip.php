<?php

namespace Kumarrahul\salaryslipuploader\Models;

use Illuminate\Database\Eloquent\Model;

class SalarySlip extends Model
{
    protected $guarded = [];
    protected $table = 'salaryslips';

    protected $fillable = [
        'emp_id',
        'file_name',
    ];
}
