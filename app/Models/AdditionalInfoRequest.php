<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalInfoRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'application_id',
        'requested_by',
        'message',
        'status',
        'response',
        'response_file_path',
    ];

    /**
     * Default attributes.
     */
    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * Relationships
     */

    // Each info request belongs to an application
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    // The admin (user) who requested the info
    public function admin()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    /**
     * Accessors & Helpers
     */

    // Get a full URL for the uploaded response file
    public function getResponseFileUrlAttribute()
    {
        return $this->response_file_path
            ? asset('storage/' . $this->response_file_path)
            : null;
    }

    // Check if the request has been responded to
    public function isResponded(): bool
    {
        return $this->status === 'responded';
    }

    // Check if the request is still pending
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    // Check if the request is closed
    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }
    public function requestedBy()
{
    return $this->belongsTo(User::class, 'requested_by');
}

}
