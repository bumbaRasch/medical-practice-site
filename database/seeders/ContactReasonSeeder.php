<?php

namespace Database\Seeders;

use App\Enums\ContactReason as ContactReasonEnum;
use App\Models\ContactReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reasons = [
            [
                'enum' => ContactReasonEnum::APPOINTMENT,
                'labels' => [
                    'de' => 'Termin vereinbaren',
                    'en' => 'Book Appointment',
                ]
            ],
            [
                'enum' => ContactReasonEnum::QUESTION,
                'labels' => [
                    'de' => 'Allgemeine Frage',
                    'en' => 'General Question',
                ]
            ],
            [
                'enum' => ContactReasonEnum::COMPLAINT,
                'labels' => [
                    'de' => 'Beschwerde',
                    'en' => 'Complaint',
                ]
            ],
            [
                'enum' => ContactReasonEnum::EMERGENCY,
                'labels' => [
                    'de' => 'Notfall',
                    'en' => 'Emergency',
                ]
            ],
            [
                'enum' => ContactReasonEnum::PRESCRIPTION,
                'labels' => [
                    'de' => 'Rezept anfordern',
                    'en' => 'Request Prescription',
                ]
            ],
            [
                'enum' => ContactReasonEnum::REFERRAL,
                'labels' => [
                    'de' => 'Überweisung',
                    'en' => 'Referral',
                ]
            ],
            [
                'enum' => ContactReasonEnum::CONSULTATION,
                'labels' => [
                    'de' => 'Beratung',
                    'en' => 'Consultation',
                ]
            ],
            [
                'enum' => ContactReasonEnum::OTHER,
                'labels' => [
                    'de' => 'Sonstiges',
                    'en' => 'Other',
                ]
            ],
        ];

        $sortOrder = 1;
        foreach ($reasons as $reason) {
            ContactReason::create([
                'key' => $reason['enum']->value,
                'name' => $reason['labels'],
                'sort_order' => $sortOrder++,
                'is_active' => true,
            ]);
        }
    }
}
