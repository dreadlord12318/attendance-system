<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['student_id', 'scanned_at'];

public function student(): BelongsTo
{
    return $this->belongsTo(Student::class);
}
}
