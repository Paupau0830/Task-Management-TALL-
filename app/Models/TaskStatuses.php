<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatuses extends Model
{
    use HasFactory;

    // Define the table name explicitly (optional if Laravel naming conventions are followed)
    protected $table = 'task_statuses';

    // Define mass assignable fields
    protected $fillable = ['title', 'created_by', 'deleted_by', 'deleted'];

    // If timestamps are enabled (default is true), no need to set anything
    public $timestamps = true;

    // Relationships

    /**
     * Get the user who created the task category.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who deleted the task category.
     */
    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // Scope to filter only active task categories
    public function scopeActive($query)
    {
        return $query->where('deleted', false);
    }
}
