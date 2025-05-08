<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'refrence_number',
        'category_id',
        'status_id',
        'source_department',
        'destination_department',
        'issue_date',
        'received_date',
        'description',
        'priority',
        //'isPublic',
        'created_by',
    ];

    /**
     * Get the category that owns the Document
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the status that owns the Document
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    /**
     * Get the departments that owns the Document
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'source_department');
    }

    /**
     * Get the department that owns the Document
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function destination_department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'destination_department');
    }

    /**
     * Get the user that owns the Document
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all of the activities for the Document
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'document_id');
    }
}
