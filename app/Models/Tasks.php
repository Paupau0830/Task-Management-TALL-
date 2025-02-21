<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    // Define the table name explicitly (optional if Laravel naming conventions are followed)
    protected $table = 'tasks';

    // Define mass assignable fields
    protected $fillable = ['title', 'category', 'description', 'status', 'assigned_to', 'created_by', 'deleted_by', 'deleted'];

    // If timestamps are enabled (default is true), no need to set anything
    public $timestamps = true;

    // Relationships

    /**
     * Get the user who created the task.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who deleted the task.
     */
    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Get the user assigned for the task.
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the category assigned for the task.
     */
    public function categories()
    {
        return $this->belongsTo(TaskCategory::class, 'category');
    }

    public function taskStatus()
    {
        return $this->belongsTo(TaskStatuses::class, 'status');
    }

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }

    // Scope to filter only active tasks
    public function scopeActive($query)
    {
        return $query->where('deleted', false);
    }
}
