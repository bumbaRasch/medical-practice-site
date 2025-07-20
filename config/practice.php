<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Practice Services
    |--------------------------------------------------------------------------
    |
    | Configuration for medical services offered by the practice.
    |
    */
    'services' => [
        [
            'title' => 'messages.services.general_medicine.title',
            'description' => 'messages.services.general_medicine.description',
            'icon' => 'stethoscope',
        ],
        [
            'title' => 'messages.services.prevention.title',
            'description' => 'messages.services.prevention.description',
            'icon' => 'shield-check',
        ],
        [
            'title' => 'messages.services.vaccinations.title',
            'description' => 'messages.services.vaccinations.description',
            'icon' => 'syringe',
        ],
        [
            'title' => 'messages.services.laboratory.title',
            'description' => 'messages.services.laboratory.description',
            'icon' => 'flask',
        ],
        [
            'title' => 'messages.services.diagnostics.title',
            'description' => 'messages.services.diagnostics.description',
            'icon' => 'heart',
        ],
        [
            'title' => 'messages.services.house_calls.title',
            'description' => 'messages.services.house_calls.description',
            'icon' => 'home',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Practice Team
    |--------------------------------------------------------------------------
    |
    | Configuration for practice team members.
    |
    */
    'team' => [
        [
            'name' => 'messages.team.members.maria.name',
            'role' => 'messages.team.members.maria.role',
            'bio' => 'messages.team.members.maria.bio',
            'image' => '/images/team/maria-mustermann.webp',
        ],
        [
            'name' => 'messages.team.members.thomas.name',
            'role' => 'messages.team.members.thomas.role',
            'bio' => 'messages.team.members.thomas.bio',
            'image' => '/images/team/thomas-beispiel.webp',
        ],
        [
            'name' => 'messages.team.members.petra.name',
            'role' => 'messages.team.members.petra.role',
            'bio' => 'messages.team.members.petra.bio',
            'image' => '/images/team/petra-schmidt.webp',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Practice FAQ
    |--------------------------------------------------------------------------
    |
    | Configuration for frequently asked questions.
    |
    */
    'faq' => [
        [
            'category' => 'messages.faq.categories.practice_info',
            'question' => 'messages.faq.questions.insurance_types.question',
            'answer' => 'messages.faq.questions.insurance_types.answer',
            'sort_order' => 1,
        ],
        [
            'category' => 'messages.faq.categories.practice_info',
            'question' => 'messages.faq.questions.new_patients.question',
            'answer' => 'messages.faq.questions.new_patients.answer',
            'sort_order' => 2,
        ],
        [
            'category' => 'messages.faq.categories.appointments',
            'question' => 'messages.faq.questions.appointment_speed.question',
            'answer' => 'messages.faq.questions.appointment_speed.answer',
            'sort_order' => 3,
        ],
        [
            'category' => 'messages.faq.categories.appointments',
            'question' => 'messages.faq.questions.same_day.question',
            'answer' => 'messages.faq.questions.same_day.answer',
            'sort_order' => 4,
        ],
        [
            'category' => 'messages.faq.categories.appointments',
            'question' => 'messages.faq.questions.online_booking.question',
            'answer' => 'messages.faq.questions.online_booking.answer',
            'sort_order' => 5,
        ],
        [
            'category' => 'messages.faq.categories.first_visit',
            'question' => 'messages.faq.questions.what_to_bring.question',
            'answer' => 'messages.faq.questions.what_to_bring.answer',
            'sort_order' => 6,
        ],
        [
            'category' => 'messages.faq.categories.first_visit',
            'question' => 'messages.faq.questions.insurance_card.question',
            'answer' => 'messages.faq.questions.insurance_card.answer',
            'sort_order' => 7,
        ],
        [
            'category' => 'messages.faq.categories.services',
            'question' => 'messages.faq.questions.medical_certificates.question',
            'answer' => 'messages.faq.questions.medical_certificates.answer',
            'sort_order' => 8,
        ],
        [
            'category' => 'messages.faq.categories.services',
            'question' => 'messages.faq.questions.preventive_care.question',
            'answer' => 'messages.faq.questions.preventive_care.answer',
            'sort_order' => 9,
        ],
        [
            'category' => 'messages.faq.categories.services',
            'question' => 'messages.faq.questions.house_calls.question',
            'answer' => 'messages.faq.questions.house_calls.answer',
            'sort_order' => 10,
        ],
    ],

];