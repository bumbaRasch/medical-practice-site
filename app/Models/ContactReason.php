<?php

namespace App\Models;

use App\Enums\ContactReason as ContactReasonEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;

/**
 * Contact reason model with localized names.
 * 
 * @property int $id
 * @property string $key
 * @property array<string, string> $name
 * @property int $sort_order
 * @property bool $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ContactReason extends Model
{
    /** @use HasFactory<\Database\Factories\ContactReasonFactory> */
    use HasFactory;

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (ContactReason $model): void {
            // Ensure the key is a valid enum value
            if (!ContactReasonEnum::tryFrom($model->key)) {
                throw new \InvalidArgumentException("Invalid contact reason key: {$model->key}");
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'name',
        'sort_order',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the enum instance for this contact reason.
     */
    public function getEnum(): ContactReasonEnum
    {
        $enum = ContactReasonEnum::tryFrom($this->key);
        
        if (!$enum) {
            throw new \RuntimeException("Invalid contact reason key: {$this->key}");
        }
        
        return $enum;
    }

    /**
     * Get the localized name for the current locale.
     */
    public function getLocalizedName(?string $locale = null): string
    {
        $locale = $locale ?? App::getLocale();
        return $this->name[$locale] ?? $this->name['de'] ?? $this->getEnum()->value;
    }

    /**
     * Find a ContactReason by its enum value.
     */
    public static function findByEnum(ContactReasonEnum $enum): ?ContactReason
    {
        return static::where('key', $enum->value)->first();
    }

    /**
     * Get all valid enum keys that are allowed in the database.
     *
     * @return array<string>
     */
    public static function getValidKeys(): array
    {
        return array_map(fn(ContactReasonEnum $case) => $case->value, ContactReasonEnum::cases());
    }

    /**
     * Scope to only include active contact reasons.
     *
     * @param \Illuminate\Database\Eloquent\Builder<ContactReason> $query
     * @return \Illuminate\Database\Eloquent\Builder<ContactReason>
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by sort order.
     *
     * @param \Illuminate\Database\Eloquent\Builder<ContactReason> $query
     * @return \Illuminate\Database\Eloquent\Builder<ContactReason>
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Get all active contact reasons ordered by sort_order.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, ContactReason>
     */
    public static function getActiveReasons(): \Illuminate\Database\Eloquent\Collection
    {
        return static::active()->ordered()->get();
    }

    /**
     * Get all contact reasons as options for forms.
     *
     * @return array<int, string>
     */
    public static function getOptionsArray(?string $locale = null): array
    {
        /** @var array<int, string> */
        return static::getActiveReasons()
            ->mapWithKeys(fn(ContactReason $reason) => [
                $reason->id => $reason->getLocalizedName($locale)
            ])
            ->toArray();
    }

    /**
     * Form requests that use this contact reason.
     *
     * @return HasMany<FormRequest, $this>
     */
    public function formRequests(): HasMany
    {
        return $this->hasMany(FormRequest::class, 'contact_reason_id');
    }
}
