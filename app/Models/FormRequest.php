<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormRequest extends Model
{
    /** @use HasFactory<\Database\Factories\FormRequestFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'contact_reason_id',
        'phone',
        'preferred_datetime',
        'message',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'preferred_datetime' => 'datetime',
        'contact_reason_id' => 'integer',
    ];

    /**
     * Get the contact reason that belongs to the form request.
     *
     * @return BelongsTo<ContactReason, $this>
     */
    public function contactReason(): BelongsTo
    {
        return $this->belongsTo(ContactReason::class);
    }
}
