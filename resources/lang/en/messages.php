<?php

return [
    // Navigation
    'nav' => [
        'home' => 'Home',
        'services' => 'Services',
        'team' => 'Team',
        'faq' => 'FAQ',
        'contact' => 'Contact',
        'book_appointment' => 'Book Appointment',
        'menu_open' => 'Open menu',
        'theme_toggle' => 'Toggle theme',
    ],

    // Home Page
    'home' => [
        'page_title' => 'Family Doctor Practice - Your trusted medical care',
        'page_meta_description' => 'Modern family doctor practice with personal attention. Book appointments online ✓ Experienced team ✓ Short waiting times ✓',
        'hero_title' => 'Your Trusted Family Doctor Practice',
        'hero_subtitle' => 'Modern medical care with personal attention',
        'hero_cta' => 'Book Appointment Now',
        'hero_services_cta' => 'Our Services',
        'about_title' => 'About Our Practice',
        'about_text' => 'For over 20 years, we have provided comprehensive family medical care. Our experienced team supports you with state-of-the-art medical technology and great empathy.',
        'benefits_title' => 'Your Benefits',
        'opening_hours_title' => 'Opening Hours',
        'experience_years' => 'Over 20 years of experience',
        'modern_technology' => 'State-of-the-art medical technology',
        'empathetic_care' => 'Empathetic care',
        'quick_appointment' => 'Quick appointment scheduling',
        'quick_appointment_text' => 'Book an appointment online now or call us.',
        'quick_appointment_cta' => 'Book Appointment Now',
        'opening_hours_text' => 'We are here for you - book an appointment or visit us during our opening hours.',
        'contact_cta' => 'Get in Touch',
        'emergency_info' => 'Outside opening hours, contact the medical emergency service:',
        'emergency_number' => '116 117',
        'final_cta_title' => 'Ready for your next doctor visit?',
        'final_cta_text' => 'Book an appointment now with your trusted family doctor practice.',
    ],

    // Benefits
    'benefits' => [
        'modern_equipment' => [
            'title' => 'Modern Equipment',
            'description' => 'Latest medical devices for precise diagnostics',
        ],
        'experienced_team' => [
            'title' => 'Experienced Team',
            'description' => 'Qualified doctors and specialists with years of experience',
        ],
        'personal_care' => [
            'title' => 'Personal Care',
            'description' => 'Individual treatment and comprehensive consultation',
        ],
        'short_waiting' => [
            'title' => 'Short Waiting Times',
            'description' => 'Appointment scheduling for efficient practice organization',
        ],
    ],

    // Contact Form
    'contact' => [
        'form_title' => 'Book Appointment',
        'form_subtitle' => 'Fill out the form and we will contact you',
        'contact_info_title' => 'Contact Information',
        'full_name' => 'Full Name',
        'email' => 'Email Address',
        'phone' => 'Phone Number',
        'preferred_datetime' => 'Preferred Appointment',
        'message' => 'Message',
        'message_placeholder' => 'Tell us how we can help you...',
        'reason' => 'Reason for Contact',
        'reason_placeholder' => 'Please select reason for contact...',
        'submit' => 'Submit Request',
        'required' => 'Required field',
        'optional' => 'Optional',
    ],

    // Contact Reasons
    'contact_reasons' => [
        'termin' => 'Book Appointment',
        'frage' => 'General Question',
        'beschwerde' => 'Complaint',
        'notfall' => 'Emergency',
        'rezept' => 'Request Prescription',
        'ueberweisung' => 'Referral',
        'beratung' => 'Consultation',
        'sonstiges' => 'Other',
    ],

    // Validation Messages
    'validation' => [
        'required' => 'The :attribute field is required.',
        'email' => 'The :attribute field must be a valid email address.',
        'in' => 'The selected :attribute is invalid.',
        'date' => 'The :attribute field must be a valid date.',
        'after' => 'The :attribute field must be a date after today.',
        'max' => [
            'string' => 'The :attribute field may not be greater than :max characters.',
        ],
        // JavaScript validation messages
        'field_required' => 'This field is required',
        'invalid_name' => 'Please enter a valid name',
        'invalid_email' => 'Please enter a valid email address',
        'invalid_phone' => 'Please enter a valid phone number',
        'invalid_date' => 'Please select a future date',
        'message_too_long' => 'Message is too long (maximum 1000 characters)',
        'select_reason' => 'Please select a reason for contact',
        'min_length' => 'At least {min} characters required',
        'email' => [
            'rfc' => 'The :attribute field must be a valid email address.',
        ],
    ],

    // Transportation Map
    'transportation' => [
        'map_title' => 'Directions & Public Transportation',
        'map_description' => 'Find the best route to our practice using public transportation or by car.',
        'loading' => 'Loading map...',
        'error_loading' => 'Error loading map. Please refresh the page.',
        'practice_popup' => 'Medical Practice - Your Destination',
        'accessibility_info' => 'This station is wheelchair accessible',
        'no_accessibility_info' => 'Limited accessibility',
        'lines_available' => 'Available lines',
        'walking_distance' => 'Walking distance to practice',
        
        // Transportation types
        'subway' => [
            'potsdamer_platz' => [
                'name' => 'Potsdamer Platz (Metro/S-Bahn)',
                'description' => 'Major transportation hub with multiple lines'
            ],
            'brandenburger_tor' => [
                'name' => 'Brandenburg Gate (S-Bahn)',
                'description' => 'Central S-Bahn station'
            ]
        ],
        'bus' => [
            'unter_den_linden' => [
                'name' => 'Unter den Linden (Bus)',
                'description' => 'Multiple bus routes to city center'
            ],
            'wilhelmstrasse' => [
                'name' => 'Wilhelmstraße (Bus)',
                'description' => 'Local bus connections'
            ]
        ],
        'tram' => [
            'friedrichstrasse' => [
                'name' => 'Friedrichstraße (Tram)',
                'description' => 'Tram stop'
            ]
        ],
        'parking' => [
            'potsdamer_platz_arkaden' => [
                'name' => 'Potsdamer Platz Arkaden Parking',
                'description' => 'Large parking garage with 800 spaces'
            ],
            'street_parking' => [
                'name' => 'Street Parking',
                'description' => 'Limited street parking available'
            ]
        ],
        'bike' => [
            'nextbike_station_1' => [
                'name' => 'Nextbike Station',
                'description' => 'Bike rental available'
            ],
            'lidl_bike_station' => [
                'name' => 'Lidl-Bike Station',
                'description' => 'E-bike rental'
            ]
        ],
        
        // Walking times
        'walking_time' => [
            '1_min' => '1 min walk',
            '2_min' => '2 min walk',
            '3_min' => '3 min walk',
            '4_min' => '4 min walk',
            '5_min' => '5 min walk',
            '6_min' => '6 min walk',
            '7_min' => '7 min walk',
        ],
        
        // Accessibility
        'accessibility_available' => 'Wheelchair accessible',
        'accessibility_limited' => 'Limited accessibility',
        
        // Map controls
        'zoom_in' => 'Zoom in',
        'zoom_out' => 'Zoom out',
        'center_map' => 'Center map',
        'toggle_fullscreen' => 'Toggle fullscreen',
        
        // Alternative text for screen readers
        'map_description_screen_reader' => 'Interactive map showing practice location and nearby public transportation',
        'marker_description' => 'Marker for {type}: {name}',
        'legend_title' => 'Legend',
    ],

    // Opening Hours
    'opening_hours' => [
        'monday_friday' => 'Mon - Fri',
        'saturday' => 'Sat',
        'sunday' => 'Sun',
        'closed' => 'Closed',
        'time_mf' => '8:00 AM - 6:00 PM',
        'time_sat' => '9:00 AM - 12:00 PM',
        'time_suffix' => '',
    ],

    // Services Page
    'services' => [
        'page_title' => 'Our Services',
        'page_subtitle' => 'Comprehensive medical care for you and your family. From prevention to treatment - we are your competent partner for your health.',
        'page_meta_description' => 'Comprehensive medical services: General medicine, prevention, vaccinations, laboratory, ECG & house calls. Your family doctor for all health questions.',
        'page_header_badge' => 'Comprehensive medical care',
        'slideshow_badge' => 'Our Practice',
        'slideshow_photos' => [
            'discussing_a_diagnosis_in_consultation_room' => [
                'title' => 'Diagnosis Discussion',
                'description' => 'Detailed explanation of your findings and treatment options'
            ],
            'doctor_s_consultation_with_mother_and_child' => [
                'title' => 'Family Medicine',
                'description' => 'Trusted care for the whole family'
            ],
            'laboratory_technician_with_centrifuge' => [
                'title' => 'Modern Laboratory Diagnostics',
                'description' => 'Precise laboratory examinations with state-of-the-art technology'
            ],
            'medical_consultation_in_bright_exam_room' => [
                'title' => 'Medical Consultation',
                'description' => 'Individual medical consultation in a pleasant atmosphere'
            ],
            'medical_examination_room_in_daylight' => [
                'title' => 'Modern Examination Rooms',
                'description' => 'Bright, friendly treatment rooms for your comfort'
            ],
            'modern_medical_office_reception' => [
                'title' => 'Reception & Service',
                'description' => 'Friendly reception and professional care'
            ],
            'modern_waiting_room_with_natural_light' => [
                'title' => 'Comfortable Waiting Room',
                'description' => 'Relaxed atmosphere with plenty of natural light'
            ],
            'vaccine_administration_in_a_bright_room' => [
                'title' => 'Preventive Medicine',
                'description' => 'Comprehensive prevention and protective vaccinations'
            ],
            'fallback' => [
                'consultation_desc' => 'Professional medical consultation',
                'examination_desc' => 'Modern examination rooms for your health',
                'reception_desc' => 'Friendly reception and service',
                'waiting_desc' => 'Comfortable waiting areas',
                'laboratory_desc' => 'Modern laboratory diagnostics',
                'vaccine_desc' => 'Preventive medicine and vaccinations',
                'default_desc' => 'Modern medical care in a pleasant atmosphere'
            ]
        ],
        'slideshow_title' => 'Insight into our practice',
        'slideshow_subtitle' => 'Experience the warm and professional atmosphere of our modern family practice',
        'grid_title' => 'Our Services Overview',
        'grid_subtitle' => 'From prevention to treatment – we guide you on your path to health',
        'availability_available' => 'Available',
        'availability_appointment' => 'By Appointment',
        'availability_consultation' => 'By Arrangement',
        'questions_title' => 'Do you have questions about our services?',
        'questions_subtitle' => 'Our team is happy to advise you personally on all medical questions and treatment options.',
        'consultation_cta' => 'Book Consultation',
        'call_now' => 'Call Now',
        'general_medicine' => [
            'title' => 'General Medicine',
            'description' => 'Comprehensive family medical care for the whole family',
        ],
        'prevention' => [
            'title' => 'Preventive Care',
            'description' => 'Health checkups and preventive medicine',
        ],
        'vaccinations' => [
            'title' => 'Vaccinations',
            'description' => 'All recommended vaccinations according to STIKO guidelines',
        ],
        'laboratory' => [
            'title' => 'Laboratory Diagnostics',
            'description' => 'Modern laboratory analyses and blood tests',
        ],
        'diagnostics' => [
            'title' => 'ECG & Ultrasound',
            'description' => 'Cardiology and imaging diagnostics',
        ],
        'house_calls' => [
            'title' => 'House Calls',
            'description' => 'Medical care in the comfort of your home',
        ],
    ],

    // Team Page
    'team' => [
        'page_title' => 'Our Team',
        'page_subtitle' => 'Meet our experienced and dedicated team. We are here for you.',
        'page_meta_description' => 'Meet our experienced medical team. Qualified specialists in general medicine and internal medicine with years of experience.',
        'header_badge' => 'Your trusted practice team',
        'meet_team_title' => 'Your trust is important to us',
        'meet_team_text' => 'Our qualified team of doctors and medical professionals ensures your optimal care.',
        'experience_years' => 'Over 20 years of experience',
        'continuing_education' => 'Continuing education',
        'personal_care' => 'Personal care',
        'qualities' => [
            'experienced' => 'Experienced',
            'empathetic' => 'Empathetic',
            'competent' => 'Competent'
        ],
        'cta_title' => 'Get to know us personally',
        'cta_description' => 'Book an appointment and experience our competent and empathetic care.',
        'services_link' => 'Our Services',
        'members' => [
            'maria' => [
                'name' => 'Dr. med. Maria Mustermann',
                'role' => 'Specialist in General Medicine',
                'bio' => 'Active in family medical care for 15 years. Specialization in preventive medicine and geriatrics.',
            ],
            'thomas' => [
                'name' => 'Dr. med. Thomas Beispiel',
                'role' => 'Specialist in Internal Medicine',
                'bio' => 'Expert in diabetes and cardiovascular diseases. 20 years of professional experience.',
            ],
            'petra' => [
                'name' => 'Petra Schmidt',
                'role' => 'Medical Assistant',
                'bio' => 'Trained medical assistant with additional qualification in wound care.',
            ],
        ],
    ],

    // Contact Page
    'contact' => [
        'page_title' => 'Contact & Directions',
        'page_subtitle' => 'Get in touch with us or book an appointment directly.',
        'page_meta_description' => 'Contact our family doctor practice. Book an appointment online or visit us. Address, phone, email and opening hours.',
        'address_title' => 'Our Address',
        'phone_title' => 'Phone',
        'email_title' => 'Email',
        'hours_title' => 'Opening Hours',
        'form_success' => 'Thank you! Your request has been successfully submitted. We will contact you soon.',
        'form_error' => 'There was an error sending your request. Please try again.',
        'form_title' => 'Book Appointment',
        'form_subtitle' => 'Fill out the form and we will get back to you',
        'contact_info_title' => 'Contact Information',
        'full_name' => 'Full Name',
        'email' => 'Email Address',
        'phone' => 'Phone Number',
        'preferred_datetime' => 'Preferred Appointment Time',
        'message' => 'Message',
        'message_placeholder' => 'Tell us how we can help you...',
        'reason' => 'Reason for Contact',
        'reason_placeholder' => 'Please select a reason for contact...',
        'submit' => 'Send Request',
        'required' => 'Required',
        'optional' => 'Optional',
    ],

    // Email Translations
    'email' => [
        'new_request_subject' => 'New Appointment Request - :name',
        'new_request_title' => 'New Appointment Request',
        'new_request_intro' => 'A new appointment request has been submitted via the website.',
        'patient_data' => 'Patient Data',
        'name_label' => 'Name',
        'email_label' => 'Email',
        'phone_label' => 'Phone',
        'preferred_time_label' => 'Preferred Appointment',
        'message_label' => 'Message',
        'reason_label' => 'Reason for Contact',
        'request_id_label' => 'Request ID',
        'submitted_at_label' => 'Submitted at',
        'button_text' => 'To Website',
        'email_signature' => 'Thank you,<br>:app_name Website',
    ],

    // Common
    'common' => [
        'practice_name' => 'Family Doctor Practice',
        'read_more' => 'Read More',
        'back' => 'Back',
        'next' => 'Next',
        'loading' => 'Loading...',
        'error' => 'An error occurred',
        'success' => 'Success',
        'emergency' => 'Emergency',
        'phone_number' => '+49 (0) 123 456 789',
        'email_address' => 'practice@doctor-example.com',
        'address' => 'Sample Street 123, 12345 Sample City',
        'all_rights_reserved' => 'All rights reserved',
        'retry' => 'Try again',
    ],

    // FAQ Page
    'faq' => [
        'page_title' => 'Frequently Asked Questions',
        'page_subtitle' => 'Find answers to the most common questions about our practice and services.',
        'page_meta_description' => 'Frequently Asked Questions (FAQ) about our family practice: insurance, appointments, services, first visits and more. All important information at a glance.',
        'header_badge' => 'Your Questions - Our Answers',
        'search_placeholder' => 'Search FAQ...',
        'no_results' => 'No matching questions found.',
        'contact_cta_title' => 'Question not answered?',
        'contact_cta_text' => 'Contact us directly – we are happy to help you.',
        'contact_cta_button' => 'Contact Us Now',
        
        'categories' => [
            'practice_info' => 'Practice Information',
            'appointments' => 'Appointments & Hours',
            'services' => 'Services',
            'first_visit' => 'First Visit',
        ],
        
        'questions' => [
            'insurance_types' => [
                'question' => 'Which types of insurance do you accept?',
                'answer' => 'We treat patients with all types of insurance: statutory health insurance (gesetzlich), private insurance (privat), and self-paying patients (Selbstzahler). Please bring your valid insurance card to your appointment.',
            ],
            'new_patients' => [
                'question' => 'Are you accepting new patients?',
                'answer' => 'Yes, we are happy to welcome new patients. Simply schedule an appointment through our contact form or call us. Please allow extra time for your first visit.',
            ],
            'appointment_speed' => [
                'question' => 'How quickly can I get an appointment?',
                'answer' => 'Routine appointments are typically available within 1-2 weeks. For acute complaints, we offer short-notice appointments or urgent care hours. Emergencies are treated immediately.',
            ],
            'same_day' => [
                'question' => 'Do you offer same-day consultations?',
                'answer' => 'Yes, we reserve appointments daily for acute illnesses and emergencies. It\'s best to call in the morning or use our urgent care hours from 8:00-9:00 AM.',
            ],
            'online_booking' => [
                'question' => 'Can I book appointments online?',
                'answer' => 'You can send appointment requests through our contact form. We will then contact you promptly for confirmation. For emergencies, please call directly.',
            ],
            'what_to_bring' => [
                'question' => 'What should I bring to my first visit?',
                'answer' => 'Please bring: your insurance card, photo ID, current medication list, previous medical reports and referrals if available. Private patients should also bring insurance documentation.',
            ],
            'insurance_card' => [
                'question' => 'What happens if I forget my insurance card?',
                'answer' => 'Without a valid insurance card, we must initially bill the treatment privately. You can later submit the costs to your health insurance. Please bring the card on your next visit.',
            ],
            'medical_certificates' => [
                'question' => 'Do you provide medical certificates?',
                'answer' => 'Yes, we issue all necessary certificates: sick leave certificates (Arbeitsunfähigkeitsbescheinigung), school/university certificates, fitness to travel certificates, and other medical reports as needed.',
            ],
            'preventive_care' => [
                'question' => 'What preventive check-ups do you offer?',
                'answer' => 'We offer all insurance-covered services: Check-up 35+, cancer screening, skin cancer screening, vaccination counseling, and other preventive services. Appointments are typically available on short notice.',
            ],
            'house_calls' => [
                'question' => 'Do you make house calls?',
                'answer' => 'Yes, we provide house calls for severely ill or immobile patients. These are only possible by appointment and with medical indication. Please call us to arrange an appointment.',
            ],
        ],
    ],

    // Legal Pages
    'legal' => [
        'nav' => [
            'privacy' => 'Privacy Policy',
            'imprint' => 'Imprint',
            'terms' => 'Terms of Service',
        ],

        // Privacy Policy (GDPR-compliant)
        'privacy' => [
            'title' => 'Privacy Policy',
            'subtitle' => 'Information on the processing of your personal data',
            'meta_description' => 'Privacy policy of the family doctor practice - Information on the processing of personal data in accordance with GDPR.',

            'controller' => [
                'title' => 'Data Controller',
                'practice_name' => 'Family Doctor Practice Dr. med. Max Mustermann',
                'phone' => 'Phone',
                'email' => 'Email',
            ],

            'processing' => [
                'title' => 'Data Processing',
                'intro' => 'We process personal data only within the framework of legal regulations. Below we inform you about the type, scope and purpose of the collection and use of your data.',

                'contact_form' => [
                    'title' => 'Contact Form',
                    'description' => 'When you use our contact form, the data you enter will be stored with us for processing your inquiry and in case of follow-up questions:',
                    'data' => [
                        'name' => 'First and last name',
                        'email' => 'Email address',
                        'phone' => 'Phone number (optional)',
                        'message' => 'Your message (optional)',
                        'appointment_time' => 'Desired appointment time (optional)',
                    ],
                    'legal_basis' => 'The legal basis for processing is Art. 6 para. 1 lit. b GDPR (contract initiation) and Art. 6 para. 1 lit. f GDPR (legitimate interest in processing your inquiry).',
                ],
            ],

            'rights' => [
                'title' => 'Your Rights as a Patient',
                'intro' => 'You have the following rights regarding your personal data:',
                'access' => [
                    'title' => 'Right of Access',
                    'description' => 'You can request information about the personal data we process.',
                ],
                'rectification' => [
                    'title' => 'Right to Rectification',
                    'description' => 'You have the right to request the correction of incorrect data.',
                ],
                'erasure' => [
                    'title' => 'Right to Erasure',
                    'description' => 'You can request the deletion of your data, provided no legal retention periods exist.',
                ],
                'portability' => [
                    'title' => 'Right to Data Portability',
                    'description' => 'You have the right to receive your data in a structured format.',
                ],
                'objection' => [
                    'title' => 'Right to Object',
                    'description' => 'You can object to the processing of your data if it is based on legitimate interests.',
                ],
            ],

            'storage' => [
                'title' => 'Storage Duration',
                'description' => 'Your data will only be stored as long as necessary for the purposes for which it was collected, or as long as legal retention periods exist. Patient data is subject to the legal retention period of 10 years after completion of treatment.',
            ],

            'confidentiality' => [
                'title' => 'Medical Confidentiality',
                'description' => 'As doctors, we are subject to special medical confidentiality under § 203 StGB (German Criminal Code). All employees of our practice are committed to data secrecy and have been trained accordingly.',
            ],

            'third_party' => [
                'title' => 'Disclosure to Third Parties',
                'description' => 'Your data is only transmitted to third parties in the following cases: with your express consent, when disclosure is necessary for treatment (e.g., to specialists or laboratories), or when there is a legal obligation.',
            ],

            'security' => [
                'title' => 'Data Security',
                'description' => 'We take technical and organizational measures to protect your data from loss, manipulation or unauthorized access. Our security measures are continuously improved in accordance with technological developments.',
            ],

            'contact' => [
                'title' => 'Contact for Data Protection Questions',
                'description' => 'If you have questions about data protection or want to assert your rights, please contact:',
                'email' => 'Email',
                'phone' => 'Phone',
            ],

            'last_updated' => 'Last updated',
            'last_updated_date' => 'January 2025',
        ],

        // Imprint (TMG-compliant)
        'imprint' => [
            'title' => 'Imprint',
            'subtitle' => 'Information according to § 5 TMG and professional regulations',
            'meta_description' => 'Imprint of the family doctor practice with all legally required information according to TMG and medical profession laws.',

            'practice_info' => [
                'title' => 'Practice Owner',
                'name' => 'Family Doctor Practice Dr. med. Max Mustermann',
                'owner' => 'Dr. med. Max Mustermann',
                'phone' => 'Phone',
                'email' => 'Email',
            ],

            'professional' => [
                'title' => 'Professional Title',
                'designation' => 'Professional designation',
                'designation_value' => 'Doctor',
                'state' => 'Awarded in',
                'state_value' => 'Germany',
                'license' => 'Medical License',
                'license_value' => 'Licensed as a physician',
            ],

            'authority' => [
                'title' => 'Competent Supervisory Authority',
                'name' => 'Regional Association of Statutory Health Insurance Physicians',
                'address' => 'Sample Street 456, 12345 Sample City',
                'website' => 'Website',
                'website_url' => 'https://www.kv-example.de',
            ],

            'regulations' => [
                'title' => 'Professional Regulations',
                'description' => 'Professional practice is subject to the following professional regulations:',
                'bo_title' => 'Professional Code for Physicians',
                'bo_url' => 'https://www.bundesaerztekammer.de',
                'gebgo_title' => 'Scale of Fees for Physicians (GOÄ)',
                'gebgo_url' => 'https://www.bundesaerztekammer.de',
                'mbo_title' => 'Model Professional Code for Physicians',
                'mbo_url' => 'https://www.bundesaerztekammer.de',
            ],

            'insurance' => [
                'title' => 'Professional Liability Insurance',
                'company' => 'Insurance Company',
                'company_value' => 'Sample Insurance AG',
                'address' => 'Insurance Address',
                'address_value' => 'Insurance Street 123, 12345 Insurance City',
                'coverage' => 'Coverage Area',
                'coverage_value' => 'Germany/Europe',
            ],

            'dispute' => [
                'title' => 'Consumer Dispute Resolution',
                'description' => 'We participate in dispute resolution procedures before a consumer arbitration board:',
                'board_name' => 'Arbitration Board for Medical Malpractice Issues at the Medical Associations',
                'board_address' => 'Sample Street 789, 12345 Arbitration City',
                'website' => 'Website',
                'website_url' => 'https://www.arbitration-example.de',
            ],

            'eu_dispute' => [
                'title' => 'EU Dispute Resolution',
                'description' => 'The European Commission provides a platform for online dispute resolution (ODR):',
                'platform_url' => 'https://ec.europa.eu/consumers/odr/',
            ],

            'copyright' => [
                'title' => 'Copyright',
                'description' => 'The content and works created by the site operators on these pages are subject to German copyright law. Duplication, processing, distribution and any kind of exploitation outside the limits of copyright require the written consent of the respective author or creator.',
            ],

            'disclaimer' => [
                'title' => 'Liability Disclaimer',
                'content' => 'The contents of our pages have been created with the greatest care. However, we cannot guarantee the accuracy, completeness and timeliness of the content.',
                'links' => 'As a service provider, we are responsible for our own content on these pages according to general laws. However, we are not obligated to monitor transmitted or stored third-party information or to investigate circumstances that indicate illegal activity.',
            ],

            'last_updated' => 'Last updated',
            'last_updated_date' => 'January 2025',
        ],

        // Terms of Service
        'terms' => [
            'title' => 'Terms of Service',
            'subtitle' => 'Treatment contract and practice regulations',
            'meta_description' => 'Terms of service of the family doctor practice for patients and treatment contracts.',

            'scope' => [
                'title' => '1. Scope',
                'description' => 'These Terms of Service apply to all treatment contracts between the practice and its patients. They regulate the rights and obligations of both contracting parties and serve to ensure proper medical care.',
            ],

            'appointments' => [
                'title' => '2. Appointment Booking',
                'booking' => [
                    'title' => 'Appointment Booking',
                    'description' => 'Appointments can be arranged in the following ways:',
                    'online' => 'Online via our website contact form',
                    'phone' => 'By phone during office hours',
                    'person' => 'In person at the practice',
                ],
                'confirmation' => [
                    'title' => 'Appointment Confirmation',
                    'description' => 'Online booked appointments are only binding after our confirmation. You will receive confirmation by email or phone.',
                ],
            ],

            'cancellation' => [
                'title' => '3. Appointment Cancellations and Changes',
                'notice' => [
                    'title' => 'Important Notice',
                    'description' => 'Please cancel appointments at least 24 hours in advance so we can help other patients.',
                ],
                'patient' => [
                    'title' => 'Cancellation by Patient',
                    'description' => 'Appointments should be cancelled at least 24 hours before the scheduled appointment. Short-notice cancellations or no-shows may incur cancellation fees if the appointment cannot be filled otherwise.',
                ],
                'practice' => [
                    'title' => 'Cancellation by Practice',
                    'description' => 'In urgent cases (emergency, doctor illness), we must cancel appointments. We strive for the fastest possible notification and offer alternative appointments.',
                ],
                'no_show' => [
                    'title' => 'No-Show',
                    'description' => 'In case of repeated no-shows without cancellation, we reserve the right to accept future appointments only with advance payment or deposit.',
                ],
            ],

            'patient_obligations' => [
                'title' => '4. Patient Obligations',
                'punctuality' => 'Punctual attendance at scheduled appointments',
                'insurance' => 'Bringing valid insurance card and referral slips if applicable',
                'information' => 'Complete and truthful information about complaints and previous illnesses',
                'medication' => 'Information about current medication and allergies',
                'respect' => 'Respectful interaction with staff and other patients',
            ],

            'practice_obligations' => [
                'title' => '5. Practice Obligations',
                'care' => 'Careful medical treatment according to current medical standards',
                'confidentiality' => 'Compliance with medical confidentiality',
                'standards' => 'Adherence to professional regulations and quality standards',
                'information' => 'Education about diagnoses and treatment options',
                'emergency' => 'Emergency care during office hours',
            ],

            'waiting_times' => [
                'title' => '6. Waiting Times',
                'description' => 'We strive to minimize waiting times. Occasional waiting times may occur due to emergencies or unforeseen treatment courses. We ask for your understanding.',
                'emergency' => [
                    'title' => 'Emergencies have priority',
                    'description' => 'Acute emergencies are always treated preferentially, even if this leads to waiting times for other patients.',
                ],
            ],

            'liability' => [
                'title' => '7. Liability',
                'practice' => [
                    'title' => 'Practice Liability',
                    'description' => 'We are liable for damages resulting from injury to life, body or health, as well as for other damages based on intentional or grossly negligent breach of duty.',
                ],
                'patient' => [
                    'title' => 'Patient Cooperation Obligation',
                    'description' => 'Treatment success also depends on patient cooperation. Follow medical instructions and therapy recommendations.',
                ],
                'limitation' => [
                    'title' => 'Limitation of Liability',
                    'description' => 'Liability for slight negligence exists only in case of violation of essential contractual obligations. Liability is limited to damage foreseeable at the time of contract conclusion.',
                ],
            ],

            'data_protection' => [
                'title' => '8. Data Protection',
                'description' => 'The processing of your personal data is carried out according to the provisions of the GDPR and BDSG. Further information can be found in our',
                'link_text' => 'Privacy Policy',
            ],

            'applicable_law' => [
                'title' => '9. Applicable Law',
                'description' => 'German law applies, excluding the UN Convention on Contracts for the International Sale of Goods.',
            ],

            'dispute_resolution' => [
                'title' => '10. Dispute Resolution',
                'description' => 'In case of disputes, we are available for out-of-court solutions. The arbitration board for medical malpractice issues at the medical association is responsible.',
            ],

            'severability' => [
                'title' => '11. Severability Clause',
                'description' => 'Should individual provisions of these Terms of Service be invalid or become invalid, the validity of the remaining provisions remains unaffected. The invalid provision will be replaced by a valid one that comes closest to the purpose of the invalid one.',
            ],

            'changes' => [
                'title' => '12. Changes to Terms of Service',
                'description' => 'Changes to these Terms of Service will be announced in due time. If you do not object within 6 weeks, the changes are deemed accepted.',
            ],

            'emergency_info' => [
                'title' => 'Emergency outside office hours',
                'description' => 'For medical emergencies outside our office hours, contact:',
                'number' => 'Medical Emergency Service',
            ],

            'last_updated' => 'Last updated',
            'last_updated_date' => 'January 2025',
        ],
    ],

    // Theme
    'theme' => [
        'light' => 'Light',
        'dark' => 'Dark',
        'toggle_label' => 'Switch between light and dark theme',
        'toggle_to' => 'Switch to :theme theme',
        'current_theme' => 'Current theme: :theme',
        'switched_to' => 'Theme switched to :theme',
        'system_preference' => 'Follow system setting',
        'auto_detect' => 'Auto-detect',
        'manual_override' => 'Manually selected',
    ],
];