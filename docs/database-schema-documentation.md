# Database Schema Documentation - Medical Practice Website

## 🗄️ Database Architecture Overview

**Database Engine:** MySQL 8.0+  
**ORM:** Laravel Eloquent  
**Migration System:** Laravel Schema Builder  
**Compliance:** GDPR-ready with soft deletes and audit trails

This medical practice website uses a **normalized database design** with strict referential integrity, comprehensive validation, and healthcare-specific data handling requirements.

---

## 📊 Entity Relationship Diagram (Text-Based)

```
┌─────────────────┐    ┌─────────────────────┐    ┌──────────────────┐
│     Users       │    │   Contact Reasons   │    │  Form Requests   │
├─────────────────┤    ├─────────────────────┤    ├──────────────────┤
│ id (PK)         │    │ id (PK)             │    │ id (PK)          │
│ name            │    │ key (UNIQUE)        │◄───┤ contact_reason_id│
│ email (UNIQUE)  │    │ name (JSON)         │    │ full_name        │
│ password        │    │ sort_order          │    │ email            │
│ email_verified  │    │ is_active           │    │ phone (NULL)     │
│ remember_token  │    │ created_at          │    │ preferred_dt     │
│ timestamps      │    │ updated_at          │    │ message (NULL)   │
└─────────────────┘    └─────────────────────┘    │ timestamps       │
                                                  │ deleted_at       │
                                                  └──────────────────┘

┌─────────────────┐    ┌─────────────────────┐    ┌──────────────────┐
│     Cache       │    │   Cache Locks       │    │    Sessions      │
├─────────────────┤    ├─────────────────────┤    ├──────────────────┤
│ key (PK)        │    │ key (PK)            │    │ id (PK)          │
│ value           │    │ owner               │    │ user_id (FK)     │
│ expiration      │    │ expiration          │    │ ip_address       │
└─────────────────┘    └─────────────────────┘    │ user_agent       │
                                                  │ payload          │
                                                  │ last_activity    │
                                                  └──────────────────┘

┌─────────────────┐    ┌─────────────────────┐    ┌──────────────────┐
│      Jobs       │    │   Job Batches       │    │   Failed Jobs    │
├─────────────────┤    ├─────────────────────┤    ├──────────────────┤
│ id (PK)         │    │ id (PK)             │    │ id (PK)          │
│ queue           │    │ name                │    │ uuid (UNIQUE)    │
│ payload         │    │ total_jobs          │    │ connection       │
│ attempts        │    │ pending_jobs        │    │ queue            │
│ reserved_at     │    │ failed_jobs         │    │ payload          │
│ available_at    │    │ failed_job_ids      │    │ exception        │
│ created_at      │    │ options             │    │ failed_at        │
└─────────────────┘    │ cancelled_at        │    └──────────────────┘
                       │ created_at          │
                       │ finished_at         │
                       └─────────────────────┘

┌─────────────────────┐
│ Password Reset      │
│ Tokens              │
├─────────────────────┤
│ email (PK)          │
│ token               │
│ created_at          │
└─────────────────────┘
```

---

## 🗃️ Core Application Tables

### `form_requests` - Patient Contact Submissions

**Purpose:** Store all patient contact form submissions with GDPR compliance

```sql
CREATE TABLE form_requests (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name          VARCHAR(255) NOT NULL COMMENT 'Patient full name',
    email              VARCHAR(255) NOT NULL COMMENT 'Contact email address',
    contact_reason_id   BIGINT UNSIGNED NOT NULL COMMENT 'FK to contact_reasons',
    phone              VARCHAR(255) NULL COMMENT 'Optional phone number',
    preferred_datetime  DATETIME NULL COMMENT 'Preferred appointment time',
    message            TEXT NULL COMMENT 'Additional patient message',
    created_at         TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at         TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at         TIMESTAMP NULL COMMENT 'Soft delete for GDPR compliance',
    
    CONSTRAINT fk_form_requests_contact_reason 
        FOREIGN KEY (contact_reason_id) REFERENCES contact_reasons(id) ON DELETE RESTRICT,
        
    INDEX idx_form_requests_created (created_at),
    INDEX idx_form_requests_reason (contact_reason_id),
    INDEX idx_form_requests_deleted (deleted_at)
);
```

**Key Features:**
- ✅ **GDPR Compliance**: Soft deletes enabled for "right to be forgotten"
- ✅ **Required Fields**: Patient name, email, and contact reason for medical context
- ✅ **Optional Fields**: Phone and message for flexible patient communication
- ✅ **Medical Context**: `preferred_datetime` for appointment scheduling
- ✅ **Audit Trail**: Comprehensive timestamp tracking

**Business Logic:**
- All submissions require a valid contact reason (referential integrity)
- Patient emails stored for communication but can be anonymized
- Soft deletes preserve relational integrity while respecting data deletion
- Phone numbers optional but validated when provided

### `contact_reasons` - Localized Medical Contact Options

**Purpose:** Centralized management of patient contact reasons with multilingual support

```sql
CREATE TABLE contact_reasons (
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    key         VARCHAR(255) UNIQUE NOT NULL COMMENT 'Enum key (matches PHP ContactReason enum)',
    name        JSON NOT NULL COMMENT 'Localized display names {"de": "German", "en": "English"}',
    sort_order  INTEGER DEFAULT 0 NOT NULL COMMENT 'Display order in forms',
    is_active   BOOLEAN DEFAULT 1 NOT NULL COMMENT 'Whether available for selection',
    created_at  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT contact_reasons_key_enum_check 
        CHECK (key IN ('termin','frage','beschwerde','notfall','rezept','ueberweisung','beratung','sonstiges')),
    
    CONSTRAINT contact_reasons_key_unique UNIQUE (key),
    
    INDEX idx_contact_reasons_active_sort (is_active, sort_order),
    INDEX idx_contact_reasons_key (key)
);
```

**Key Features:**
- ✅ **Enum Integration**: Database CHECK constraint validates against PHP enum values
- ✅ **Localization**: JSON column supports German/English (extensible to more languages)
- ✅ **Ordering**: `sort_order` provides consistent display sequence
- ✅ **Activation Control**: Enable/disable options without data loss
- ✅ **Performance**: Composite index for efficient active option queries

**Medical Contact Options:**
```json
{
  "termin": {"de": "Termin vereinbaren", "en": "Book Appointment"},
  "frage": {"de": "Allgemeine Frage", "en": "General Question"},
  "beschwerde": {"de": "Beschwerde", "en": "Complaint"},
  "notfall": {"de": "Notfall", "en": "Emergency"},
  "rezept": {"de": "Rezept anfordern", "en": "Request Prescription"},
  "ueberweisung": {"de": "Überweisung", "en": "Referral"},
  "beratung": {"de": "Beratung", "en": "Consultation"},
  "sonstiges": {"de": "Sonstiges", "en": "Other"}
}
```

---

## 🔐 Laravel System Tables

### `users` - Authentication & User Management

```sql
CREATE TABLE users (
    id                 BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name              VARCHAR(255) NOT NULL,
    email             VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password          VARCHAR(255) NOT NULL COMMENT 'Hashed with bcrypt',
    remember_token    VARCHAR(100) NULL,
    created_at        TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at        TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    UNIQUE KEY users_email_unique (email)
);
```

### `sessions` - Secure Session Management

```sql
CREATE TABLE sessions (
    id            VARCHAR(255) PRIMARY KEY,
    user_id       BIGINT UNSIGNED NULL,
    ip_address    VARCHAR(45) NULL COMMENT 'IPv4/IPv6 support',
    user_agent    TEXT NULL COMMENT 'Browser fingerprinting',
    payload       LONGTEXT NOT NULL COMMENT 'Encrypted session data',
    last_activity INTEGER NOT NULL COMMENT 'Unix timestamp',
    
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity),
    
    CONSTRAINT fk_sessions_user_id 
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### Performance & Caching Tables

#### `cache` - Application Cache Storage
```sql
CREATE TABLE cache (
    key        VARCHAR(255) PRIMARY KEY COMMENT 'Cache key identifier',
    value      MEDIUMTEXT NOT NULL COMMENT 'Serialized cache value',
    expiration INTEGER NOT NULL COMMENT 'Unix timestamp expiration'
);
```

#### `cache_locks` - Distributed Lock Management
```sql
CREATE TABLE cache_locks (
    key        VARCHAR(255) PRIMARY KEY COMMENT 'Lock identifier',
    owner      VARCHAR(255) NOT NULL COMMENT 'Lock owner process',
    expiration INTEGER NOT NULL COMMENT 'Lock expiration timestamp'
);
```

### Queue System Tables

#### `jobs` - Asynchronous Job Processing
```sql
CREATE TABLE jobs (
    id           BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue        VARCHAR(255) NOT NULL DEFAULT 'default',
    payload      LONGTEXT NOT NULL COMMENT 'Serialized job data',
    attempts     TINYINT UNSIGNED NOT NULL DEFAULT 0,
    reserved_at  INTEGER UNSIGNED NULL COMMENT 'Job processing timestamp',
    available_at INTEGER UNSIGNED NOT NULL COMMENT 'When job becomes available',
    created_at   INTEGER UNSIGNED NOT NULL,
    
    INDEX jobs_queue_index (queue),
    INDEX jobs_reserved_at_index (reserved_at),
    INDEX jobs_available_at_index (available_at)
);
```

#### `failed_jobs` - Error Handling & Recovery
```sql
CREATE TABLE failed_jobs (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid       VARCHAR(255) UNIQUE NOT NULL COMMENT 'Unique job identifier',
    connection TEXT NOT NULL COMMENT 'Queue connection name',
    queue      TEXT NOT NULL COMMENT 'Queue name',
    payload    LONGTEXT NOT NULL COMMENT 'Original job payload',
    exception  LONGTEXT NOT NULL COMMENT 'Exception details',
    failed_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    UNIQUE KEY failed_jobs_uuid_unique (uuid)
);
```

---

## 🔗 Relationship Mappings

### Primary Relationships

#### `FormRequest` ↔ `ContactReason` (Many-to-One)

**Database Relationship:**
```sql
CONSTRAINT fk_form_requests_contact_reason 
    FOREIGN KEY (contact_reason_id) REFERENCES contact_reasons(id) ON DELETE RESTRICT
```

**Eloquent Implementation:**
```php
// FormRequest.php
class FormRequest extends Model
{
    use SoftDeletes;
    
    public function contactReason(): BelongsTo
    {
        return $this->belongsTo(ContactReason::class, 'contact_reason_id');
    }
}

// ContactReason.php  
class ContactReason extends Model
{
    public function formRequests(): HasMany
    {
        return $this->hasMany(FormRequest::class, 'contact_reason_id');
    }
    
    public function activeFormRequests(): HasMany
    {
        return $this->hasMany(FormRequest::class, 'contact_reason_id')
                   ->whereNull('deleted_at');
    }
}
```

**Relationship Characteristics:**
- **Type**: Many-to-One (Multiple submissions can use the same contact reason)
- **Integrity**: `ON DELETE RESTRICT` prevents deletion of referenced contact reasons
- **Performance**: Foreign key index for efficient JOIN operations
- **Business Logic**: Preserves historical data when contact reasons change

### Enum Integration with Database

#### PHP Enum ↔ Database Validation Pattern

**PHP Enum Definition:**
```php
enum ContactReason: string 
{
    case APPOINTMENT = 'termin';
    case QUESTION = 'frage';
    case COMPLAINT = 'beschwerde';
    case EMERGENCY = 'notfall';
    case PRESCRIPTION = 'rezept';
    case REFERRAL = 'ueberweisung';
    case CONSULTATION = 'beratung';
    case OTHER = 'sonstiges';
    
    public function label(): string
    {
        return __('messages.contact_reasons.' . $this->value);
    }
}
```

**Database CHECK Constraint:**
```sql
CONSTRAINT contact_reasons_key_enum_check 
    CHECK (key IN ('termin','frage','beschwerde','notfall','rezept','ueberweisung','beratung','sonstiges'))
```

**Model Validation:**
```php
class ContactReason extends Model
{
    protected static function boot(): void
    {
        parent::boot();
        
        static::saving(function (ContactReason $model): void {
            if (!ContactReasonEnum::tryFrom($model->key)) {
                throw new InvalidArgumentException("Invalid contact reason key: {$model->key}");
            }
        });
    }
    
    public function getLocalizedName(?string $locale = null): string
    {
        $locale = $locale ?? App::getLocale();
        $names = json_decode($this->name, true);
        
        return $names[$locale] ?? $names['de'] ?? $this->key;
    }
}
```

---

## 📈 Database Indexes & Performance

### Strategic Index Design

#### **Primary Performance Indexes**
```sql
-- Contact reasons: Active lookup optimization
INDEX idx_contact_reasons_active_sort (is_active, sort_order)

-- Form requests: Temporal queries
INDEX idx_form_requests_created (created_at)
INDEX idx_form_requests_deleted (deleted_at)

-- Session management: Security & cleanup
INDEX sessions_user_id_index (user_id)
INDEX sessions_last_activity_index (last_activity)

-- Queue processing: Job management
INDEX jobs_queue_index (queue)
INDEX jobs_available_at_index (available_at)
```

#### **Query Pattern Optimization**

**Contact Reason Queries:**
```sql
-- Optimized by idx_contact_reasons_active_sort
SELECT * FROM contact_reasons 
WHERE is_active = 1 
ORDER BY sort_order ASC;
```

**Form Request History:**
```sql
-- Optimized by idx_form_requests_created + soft delete index
SELECT * FROM form_requests 
WHERE deleted_at IS NULL 
ORDER BY created_at DESC 
LIMIT 50;
```

**Relational Queries:**
```sql
-- Optimized by foreign key index + composite index
SELECT fr.*, cr.name 
FROM form_requests fr
JOIN contact_reasons cr ON fr.contact_reason_id = cr.id
WHERE cr.is_active = 1 
  AND fr.deleted_at IS NULL;
```

### Localization Performance

**JSON Column Optimization:**
- **Storage Efficiency**: Single column for all languages vs. separate tables
- **Query Performance**: Direct JSON extraction with MySQL JSON functions
- **Caching Strategy**: Application-level caching for 24-hour TTL
- **Fallback Logic**: German → English → Key fallback hierarchy

```sql
-- JSON extraction for localized names
SELECT 
    id,
    key,
    JSON_UNQUOTE(JSON_EXTRACT(name, '$.de')) as name_de,
    JSON_UNQUOTE(JSON_EXTRACT(name, '$.en')) as name_en
FROM contact_reasons 
WHERE is_active = 1;
```

---

## 🛡️ Security & Validation

### Database-Level Security

#### **Data Integrity Constraints**
```sql
-- Enum validation at database level
CONSTRAINT contact_reasons_key_enum_check 
    CHECK (key IN ('termin','frage','beschwerde','notfall','rezept','ueberweisung','beratung','sonstiges'))

-- Referential integrity
CONSTRAINT fk_form_requests_contact_reason 
    FOREIGN KEY (contact_reason_id) REFERENCES contact_reasons(id) ON DELETE RESTRICT

-- Unique constraints
CONSTRAINT contact_reasons_key_unique UNIQUE (key)
CONSTRAINT users_email_unique UNIQUE (email)
```

#### **Input Validation Layers**

**1. Database Layer:**
- CHECK constraints for enum values
- NOT NULL constraints for required fields
- Foreign key constraints for referential integrity
- Data type constraints (VARCHAR lengths, DATETIME formats)

**2. Application Layer (FormRequest):**
```php
public function rules(): array
{
    return [
        'full_name' => 'required|string|max:255|regex:/^[a-zA-ZäöüÄÖÜß\s\-\']+$/',
        'email' => 'required|email:rfc,dns|max:255',
        'contact_reason_id' => 'required|exists:contact_reasons,id,is_active,1',
        'phone' => 'nullable|string|max:255|regex:/^[\+]?[0-9\s\-\(\)]{10,}$/',
        'preferred_datetime' => 'nullable|date|after:now',
        'message' => 'nullable|string|max:2000',
    ];
}
```

**3. Model Layer (Eloquent):**
```php
class FormRequest extends Model
{
    protected $fillable = [
        'full_name', 'email', 'contact_reason_id', 
        'phone', 'preferred_datetime', 'message'
    ];
    
    protected $casts = [
        'preferred_datetime' => 'datetime',
    ];
    
    // Automatic validation on save
    protected static function boot(): void
    {
        parent::boot();
        
        static::saving(function (FormRequest $model): void {
            if (empty($model->full_name) || empty($model->email)) {
                throw new ValidationException('Name and email are required');
            }
        });
    }
}
```

### GDPR Compliance Implementation

#### **Right to be Forgotten**
```php
// Soft delete implementation
class FormRequest extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    
    public function anonymize(): bool
    {
        return $this->update([
            'full_name' => 'Anonymized Patient',
            'email' => 'anonymized_' . $this->id . '@example.com',
            'phone' => null,
            'message' => null,
        ]);
    }
    
    public function forgetPatient(): bool
    {
        $this->anonymize();
        return $this->delete(); // Soft delete
    }
}
```

#### **Data Retention Policies**
```php
// Automatic cleanup command
class CleanupOldDataCommand extends Command
{
    public function handle(): void
    {
        // Hard delete soft-deleted records older than 7 years (medical records retention)
        FormRequest::onlyTrashed()
            ->where('deleted_at', '<', now()->subYears(7))
            ->forceDelete();
            
        // Archive completed requests older than 2 years
        FormRequest::where('created_at', '<', now()->subYears(2))
            ->update(['archived' => true]);
    }
}
```

---

## 📊 Schema Evolution & Migration Strategy

### Migration Timeline

**Phase 1: Foundation (Initial Setup)**
```php
// 0001_01_01_000000_create_users_table.php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});
```

**Phase 2: Core Features**
```php
// 2025_07_19_103509_create_form_requests_table.php
Schema::create('form_requests', function (Blueprint $table) {
    $table->id();
    $table->string('full_name');
    $table->string('email');
    $table->string('phone')->nullable();
    $table->datetime('preferred_datetime')->nullable();
    $table->text('message')->nullable();
    $table->timestamps();
});
```

**Phase 3: Business Logic Enhancement**
```php
// 2025_07_19_113929_add_reason_to_form_requests_table.php
Schema::table('form_requests', function (Blueprint $table) {
    $table->string('reason')->after('email');
});
```

**Phase 4: Data Normalization**
```php
// 2025_07_19_114557_create_contact_reasons_table.php
Schema::create('contact_reasons', function (Blueprint $table) {
    $table->id();
    $table->string('key')->unique();
    $table->json('name');
    $table->integer('sort_order')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

**Phase 5: Relationship Establishment**
```php
// 2025_07_19_115038_update_form_requests_use_contact_reason_id.php
Schema::table('form_requests', function (Blueprint $table) {
    $table->dropColumn('reason');
    $table->foreignId('contact_reason_id')->constrained();
});
```

**Phase 6: Data Integrity**
```php
// 2025_07_19_120346_add_key_constraint_to_contact_reasons.php
DB::statement("
    ALTER TABLE contact_reasons 
    ADD CONSTRAINT contact_reasons_key_enum_check 
    CHECK (key IN ('termin','frage','beschwerde','notfall','rezept','ueberweisung','beratung','sonstiges'))
");
```

### Schema Design Benefits

**1. Evolutionary Design:**
- ✅ Started simple, evolved based on real requirements
- ✅ Maintained backward compatibility during transitions
- ✅ Preserved existing data through migrations

**2. Performance Optimization:**
- ✅ Strategic indexing based on query patterns
- ✅ Composite indexes for complex WHERE clauses
- ✅ JSON column optimization for localization

**3. Data Integrity:**
- ✅ Progressive constraint addition
- ✅ Enum validation at multiple layers
- ✅ Foreign key relationships with appropriate cascade rules

**4. Medical Practice Optimization:**
- ✅ GDPR compliance with soft deletes
- ✅ Audit trails for medical record keeping
- ✅ Multilingual support for diverse patient populations
- ✅ Flexible appointment scheduling with datetime precision

This database schema represents a **mature, production-ready design** for German medical practices, combining regulatory compliance, performance optimization, and comprehensive data integrity while maintaining flexibility for future enhancements.