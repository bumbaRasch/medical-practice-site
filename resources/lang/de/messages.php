<?php

return [
    // Navigation
    'nav' => [
        'home' => 'Startseite',
        'services' => 'Leistungen',
        'team' => 'Team',
        'faq' => 'FAQ',
        'contact' => 'Kontakt',
        'book_appointment' => 'Termin vereinbaren',
        'menu_open' => 'Menü öffnen',
    ],

    // Home Page
    'home' => [
        'page_title' => 'Hausarztpraxis - Ihre vertrauensvolle medizinische Versorgung',
        'page_meta_description' => 'Moderne Hausarztpraxis mit persönlicher Betreuung. Online Termine vereinbaren ✓ Erfahrenes Team ✓ Kurze Wartezeiten ✓',
        'hero_title' => 'Ihre vertrauensvolle Hausarztpraxis',
        'hero_subtitle' => 'Moderne medizinische Versorgung mit persönlicher Betreuung',
        'hero_cta' => 'Jetzt Termin vereinbaren',
        'hero_services_cta' => 'Unsere Leistungen',
        'about_title' => 'Über unsere Praxis',
        'about_text' => 'Seit über 20 Jahren bieten wir Ihnen eine umfassende hausärztliche Versorgung. Unser erfahrenes Team steht Ihnen mit modernster Medizintechnik und viel Einfühlungsvermögen zur Seite.',
        'benefits_title' => 'Ihre Vorteile',
        'opening_hours_title' => 'Sprechzeiten',
        'experience_years' => 'Über 20 Jahre Erfahrung',
        'modern_technology' => 'Modernste Medizintechnik',
        'empathetic_care' => 'Einfühlsame Betreuung',
        'quick_appointment' => 'Schnelle Terminvergabe',
        'quick_appointment_text' => 'Vereinbaren Sie jetzt online einen Termin oder rufen Sie uns an.',
        'quick_appointment_cta' => 'Jetzt Termin vereinbaren',
        'opening_hours_text' => 'Wir sind für Sie da - vereinbaren Sie gerne einen Termin oder besuchen Sie uns während unserer Sprechzeiten.',
        'contact_cta' => 'Kontakt aufnehmen',
        'emergency_info' => 'Außerhalb der Sprechzeiten wenden Sie sich an den ärztlichen Bereitschaftsdienst:',
        'emergency_number' => '116 117',
        'final_cta_title' => 'Bereit für Ihren nächsten Arztbesuch?',
        'final_cta_text' => 'Vereinbaren Sie jetzt einen Termin bei Ihrer vertrauensvollen Hausarztpraxis.',
    ],

    // Benefits
    'benefits' => [
        'modern_equipment' => [
            'title' => 'Moderne Ausstattung',
            'description' => 'Neueste medizinische Geräte für präzise Diagnostik',
        ],
        'experienced_team' => [
            'title' => 'Erfahrenes Team',
            'description' => 'Qualifizierte Ärzte und Fachkräfte mit langjähriger Erfahrung',
        ],
        'personal_care' => [
            'title' => 'Persönliche Betreuung',
            'description' => 'Individuelle Behandlung und ausführliche Beratung',
        ],
        'short_waiting' => [
            'title' => 'Kurze Wartezeiten',
            'description' => 'Terminvergabe für eine effiziente Praxisorganisation',
        ],
    ],


    // Contact Reasons
    'contact_reasons' => [
        'termin' => 'Termin vereinbaren',
        'frage' => 'Allgemeine Frage',
        'beschwerde' => 'Beschwerde',
        'notfall' => 'Notfall',
        'rezept' => 'Rezept anfordern',
        'ueberweisung' => 'Überweisung',
        'beratung' => 'Beratung',
        'sonstiges' => 'Sonstiges',
    ],

    // Validation Messages
    'validation' => [
        'required' => 'Das Feld :attribute ist erforderlich.',
        'email' => 'Das Feld :attribute muss eine gültige E-Mail-Adresse sein.',
        'in' => 'Das ausgewählte :attribute ist ungültig.',
        'date' => 'Das Feld :attribute muss ein gültiges Datum sein.',
        'after' => 'Das Feld :attribute muss ein Datum nach heute sein.',
        'max' => [
            'string' => 'Das Feld :attribute darf nicht länger als :max Zeichen sein.',
        ],
        'email' => [
            'rfc' => 'Das Feld :attribute muss eine gültige E-Mail-Adresse sein.',
        ],
        // JavaScript validation messages
        'field_required' => 'Dieses Feld ist erforderlich',
        'invalid_name' => 'Bitte geben Sie einen gültigen Namen ein',
        'invalid_email' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein',
        'invalid_phone' => 'Bitte geben Sie eine gültige Telefonnummer ein',
        'invalid_date' => 'Bitte wählen Sie einen Termin in der Zukunft',
        'message_too_long' => 'Die Nachricht ist zu lang (maximal 1000 Zeichen)',
        'select_reason' => 'Bitte wählen Sie einen Grund für Ihre Kontaktaufnahme',
        'min_length' => 'Mindestens {min} Zeichen erforderlich',
    ],

    // Transportation Map
    'transportation' => [
        'map_title' => 'Anfahrt & Öffentliche Verkehrsmittel',
        'map_description' => 'Finden Sie den besten Weg zu unserer Praxis mit öffentlichen Verkehrsmitteln oder dem Auto.',
        'loading' => 'Karte wird geladen...',
        'error_loading' => 'Fehler beim Laden der Karte. Bitte aktualisieren Sie die Seite.',
        'practice_popup' => 'Hausarztpraxis - Ihr Ziel',
        'accessibility_info' => 'Diese Station ist barrierefrei zugänglich',
        'no_accessibility_info' => 'Barrierefreiheit nicht gewährleistet',
        'lines_available' => 'Verfügbare Linien',
        'walking_distance' => 'Fußweg zur Praxis',
        
        // Transportation types
        'subway' => [
            'potsdamer_platz' => [
                'name' => 'Potsdamer Platz (U-Bahn/S-Bahn)',
                'description' => 'Hauptverkehrsknotenpunkt mit mehreren Linien'
            ],
            'brandenburger_tor' => [
                'name' => 'Brandenburger Tor (S-Bahn)',
                'description' => 'Zentrale S-Bahn-Station'
            ]
        ],
        'bus' => [
            'unter_den_linden' => [
                'name' => 'Unter den Linden (Bus)',
                'description' => 'Mehrere Buslinien Richtung Zentrum'
            ],
            'wilhelmstrasse' => [
                'name' => 'Wilhelmstraße (Bus)',
                'description' => 'Lokale Busverbindungen'
            ]
        ],
        'tram' => [
            'friedrichstrasse' => [
                'name' => 'Friedrichstraße (Tram)',
                'description' => 'Straßenbahnhaltestelle'
            ]
        ],
        'parking' => [
            'potsdamer_platz_arkaden' => [
                'name' => 'Parkhaus Potsdamer Platz Arkaden',
                'description' => 'Großes Parkhaus mit 800 Stellplätzen'
            ],
            'street_parking' => [
                'name' => 'Straßenparkplätze',
                'description' => 'Begrenzte Parkplätze im Straßenraum'
            ]
        ],
        'bike' => [
            'nextbike_station_1' => [
                'name' => 'Nextbike Station',
                'description' => 'Leihfahrräder verfügbar'
            ],
            'lidl_bike_station' => [
                'name' => 'Lidl-Bike Station',
                'description' => 'E-Bike Verleih'
            ]
        ],
        
        // Walking times
        'walking_time' => [
            '1_min' => '1 Min. Fußweg',
            '2_min' => '2 Min. Fußweg',
            '3_min' => '3 Min. Fußweg',
            '4_min' => '4 Min. Fußweg',
            '5_min' => '5 Min. Fußweg',
            '6_min' => '6 Min. Fußweg',
            '7_min' => '7 Min. Fußweg',
        ],
        
        // Accessibility
        'accessibility_available' => 'Barrierefrei zugänglich',
        'accessibility_limited' => 'Eingeschränkte Barrierefreiheit',
        
        // Map controls
        'zoom_in' => 'Vergrößern',
        'zoom_out' => 'Verkleinern',
        'center_map' => 'Karte zentrieren',
        'toggle_fullscreen' => 'Vollbild umschalten',
        
        // Alternative text for screen readers
        'map_description_screen_reader' => 'Interaktive Karte mit der Lage der Praxis und nahegelegenen öffentlichen Verkehrsmitteln',
        'marker_description' => 'Markierung für {type}: {name}',
        'legend_title' => 'Legende',
    ],

    // Opening Hours
    'opening_hours' => [
        'monday_friday' => 'Mo - Fr',
        'saturday' => 'Sa',
        'sunday' => 'So',
        'closed' => 'Geschlossen',
        'time_mf' => '8:00 - 18:00',
        'time_sat' => '9:00 - 12:00',
        'time_suffix' => 'Uhr',
    ],

    // Services Page
    'services' => [
        'page_title' => 'Unsere Leistungen',
        'page_subtitle' => 'Umfassende medizinische Versorgung für Sie und Ihre Familie. Von der Vorsorge bis zur Behandlung - wir sind Ihr kompetenter Partner für Ihre Gesundheit.',
        'page_meta_description' => 'Umfassende medizinische Leistungen: Allgemeinmedizin, Vorsorge, Impfungen, Labor, EKG & Hausbesuche. Ihr Hausarzt für alle Gesundheitsfragen.',
        'page_header_badge' => 'Umfassende medizinische Versorgung',
        'slideshow_badge' => 'Unsere Praxis',
        'slideshow_photos' => [
            'discussing_a_diagnosis_in_consultation_room' => [
                'title' => 'Diagnosebesprechung',
                'description' => 'Ausführliche Erklärung Ihrer Befunde und Behandlungsoptionen'
            ],
            'doctor_s_consultation_with_mother_and_child' => [
                'title' => 'Familienmedizin',
                'description' => 'Vertrauensvolle Betreuung für die ganze Familie'
            ],
            'laboratory_technician_with_centrifuge' => [
                'title' => 'Moderne Labordiagnostik',
                'description' => 'Präzise Laboruntersuchungen mit modernster Technik'
            ],
            'medical_consultation_in_bright_exam_room' => [
                'title' => 'Medizinische Beratung',
                'description' => 'Individuelle medizinische Beratung in angenehmer Atmosphäre'
            ],
            'medical_examination_room_in_daylight' => [
                'title' => 'Moderne Untersuchungsräume',
                'description' => 'Helle, freundliche Behandlungsräume für Ihr Wohlbefinden'
            ],
            'modern_medical_office_reception' => [
                'title' => 'Empfang & Service',
                'description' => 'Freundlicher Empfang und professionelle Betreuung'
            ],
            'modern_waiting_room_with_natural_light' => [
                'title' => 'Komfortables Wartezimmer',
                'description' => 'Entspannte Atmosphäre mit viel natürlichem Licht'
            ],
            'vaccine_administration_in_a_bright_room' => [
                'title' => 'Präventionsmedizin',
                'description' => 'Umfassende Vorsorge und Schutzimpfungen'
            ],
            'fallback' => [
                'consultation_desc' => 'Professionelle medizinische Beratung',
                'examination_desc' => 'Moderne Untersuchungsräume für Ihre Gesundheit',
                'reception_desc' => 'Freundlicher Empfang und Service',
                'waiting_desc' => 'Komfortable Wartebereiche',
                'laboratory_desc' => 'Moderne Labordiagnostik',
                'vaccine_desc' => 'Präventionsmedizin und Impfungen',
                'default_desc' => 'Moderne medizinische Versorgung in angenehmer Atmosphäre'
            ]
        ],
        'slideshow_title' => 'Einblick in unsere Praxis',
        'slideshow_subtitle' => 'Erleben Sie die warme und professionelle Atmosphäre unserer modernen Hausarztpraxis',
        'grid_title' => 'Unsere Leistungen im Überblick',
        'grid_subtitle' => 'Von der Vorsorge bis zur Behandlung – wir begleiten Sie auf Ihrem Weg zur Gesundheit',
        'availability_available' => 'Verfügbar',
        'availability_appointment' => 'Nach Termin',
        'availability_consultation' => 'Nach Absprache',
        'questions_title' => 'Haben Sie Fragen zu unseren Leistungen?',
        'questions_subtitle' => 'Unser Team berät Sie gerne persönlich zu allen medizinischen Fragen und Behandlungsmöglichkeiten.',
        'consultation_cta' => 'Beratungstermin vereinbaren',
        'call_now' => 'Jetzt anrufen',
        'general_medicine' => [
            'title' => 'Allgemeinmedizin',
            'description' => 'Umfassende hausärztliche Versorgung für die ganze Familie',
        ],
        'prevention' => [
            'title' => 'Vorsorgeuntersuchungen',
            'description' => 'Gesundheitscheck und Präventionsmedizin',
        ],
        'vaccinations' => [
            'title' => 'Impfungen',
            'description' => 'Alle empfohlenen Schutzimpfungen nach STIKO',
        ],
        'laboratory' => [
            'title' => 'Labordiagnostik',
            'description' => 'Moderne Laboranalysen und Blutuntersuchungen',
        ],
        'diagnostics' => [
            'title' => 'EKG & Ultraschall',
            'description' => 'Kardiologie und bildgebende Diagnostik',
        ],
        'house_calls' => [
            'title' => 'Hausbesuche',
            'description' => 'Medizinische Versorgung bei Ihnen zu Hause',
        ],
    ],

    // Team Page
    'team' => [
        'page_title' => 'Unser Team',
        'page_subtitle' => 'Lernen Sie unser erfahrenes und engagiertes Team kennen. Wir sind für Sie da.',
        'page_meta_description' => 'Lernen Sie unser erfahrenes Ärzteteam kennen. Qualifizierte Fachärzte für Allgemeinmedizin und Innere Medizin mit langjähriger Erfahrung.',
        'header_badge' => 'Ihr vertrautes Praxisteam',
        'meet_team_title' => 'Ihr Vertrauen ist uns wichtig',
        'meet_team_text' => 'Unser qualifiziertes Team aus Ärzten und medizinischen Fachkräften sorgt für Ihre optimale Betreuung.',
        'experience_years' => 'Über 20 Jahre Erfahrung',
        'continuing_education' => 'Fortlaufende Weiterbildung',
        'personal_care' => 'Persönliche Betreuung',
        'qualities' => [
            'experienced' => 'Erfahren',
            'empathetic' => 'Einfühlsam',
            'competent' => 'Kompetent'
        ],
        'cta_title' => 'Lernen Sie uns persönlich kennen',
        'cta_description' => 'Vereinbaren Sie einen Termin und überzeugen Sie sich von unserer kompetenten und einfühlsamen Betreuung.',
        'services_link' => 'Unsere Leistungen',
        'members' => [
            'maria' => [
                'name' => 'Dr. med. Maria Mustermann',
                'role' => 'Fachärztin für Allgemeinmedizin',
                'bio' => 'Seit 15 Jahren in der hausärztlichen Versorgung tätig. Spezialisierung auf Präventivmedizin und Geriatrie.',
            ],
            'thomas' => [
                'name' => 'Dr. med. Thomas Beispiel',
                'role' => 'Facharzt für Innere Medizin',
                'bio' => 'Experte für Diabetes und Herz-Kreislauf-Erkrankungen. 20 Jahre Berufserfahrung.',
            ],
            'petra' => [
                'name' => 'Petra Schmidt',
                'role' => 'Medizinische Fachangestellte',
                'bio' => 'Ausgebildete MFA mit Zusatzqualifikation in der Wundversorgung.',
            ],
        ],
    ],

    // Contact Page
    'contact' => [
        'page_title' => 'Kontakt & Anfahrt',
        'page_subtitle' => 'Nehmen Sie Kontakt mit uns auf oder vereinbaren Sie direkt einen Termin.',
        'page_meta_description' => 'Kontaktieren Sie unsere Hausarztpraxis. Vereinbaren Sie online einen Termin oder besuchen Sie uns. Adresse, Telefon, E-Mail und Sprechzeiten.',
        'address_title' => 'Unsere Adresse',
        'phone_title' => 'Telefon',
        'email_title' => 'E-Mail',
        'hours_title' => 'Sprechzeiten',
        'form_success' => 'Vielen Dank! Ihre Anfrage wurde erfolgreich übermittelt. Wir melden uns zeitnah bei Ihnen.',
        'form_error' => 'Es gab einen Fehler beim Senden Ihrer Anfrage. Bitte versuchen Sie es erneut.',
        'form_title' => 'Termin vereinbaren',
        'form_subtitle' => 'Füllen Sie das Formular aus und wir melden uns bei Ihnen',
        'contact_info_title' => 'Kontaktinformationen',
        'full_name' => 'Vollständiger Name',
        'email' => 'E-Mail-Adresse',
        'phone' => 'Telefonnummer',
        'preferred_datetime' => 'Wunschtermin',
        'message' => 'Nachricht',
        'message_placeholder' => 'Teilen Sie uns mit, was wir für Sie tun können...',
        'reason' => 'Grund der Kontaktaufnahme',
        'reason_placeholder' => 'Bitte Grund der Kontaktaufnahme auswählen...',
        'submit' => 'Anfrage senden',
        'required' => 'Pflichtfeld',
        'optional' => 'Optional',
    ],

    // Email Translations
    'email' => [
        'new_request_subject' => 'Neue Terminanfrage - :name',
        'new_request_title' => 'Neue Terminanfrage',
        'new_request_intro' => 'Eine neue Terminanfrage wurde über die Website eingereicht.',
        'patient_data' => 'Patientendaten',
        'name_label' => 'Name',
        'email_label' => 'E-Mail',
        'phone_label' => 'Telefon',
        'preferred_time_label' => 'Wunschtermin',
        'message_label' => 'Nachricht',
        'reason_label' => 'Grund der Kontaktaufnahme',
        'request_id_label' => 'Anfrage-ID',
        'submitted_at_label' => 'Eingegangen am',
        'button_text' => 'Zur Website',
        'email_signature' => 'Vielen Dank,<br>:app_name Website',
    ],

    // Common
    'common' => [
        'practice_name' => 'Hausarztpraxis',
        'read_more' => 'Mehr lesen',
        'back' => 'Zurück',
        'next' => 'Weiter',
        'loading' => 'Wird geladen...',
        'error' => 'Ein Fehler ist aufgetreten',
        'success' => 'Erfolgreich',
        'emergency' => 'Notfall',
        'phone_number' => '+49 (0) 123 456 789',
        'email_address' => 'praxis@hausarzt-beispiel.de',
        'address' => 'Musterstraße 123, 12345 Musterstadt',
        'all_rights_reserved' => 'Alle Rechte vorbehalten',
        'retry' => 'Erneut versuchen',
    ],

    // FAQ Page
    'faq' => [
        'page_title' => 'Häufige Fragen',
        'page_subtitle' => 'Hier finden Sie Antworten auf die häufigsten Fragen zu unserer Praxis und unseren Leistungen.',
        'page_meta_description' => 'Häufige Fragen (FAQ) zur Hausarztpraxis: Versicherung, Termine, Leistungen, Erstbesuche und mehr. Alle wichtigen Informationen auf einen Blick.',
        'header_badge' => 'Ihre Fragen - Unsere Antworten',
        'search_placeholder' => 'FAQ durchsuchen...',
        'no_results' => 'Keine passenden Fragen gefunden.',
        'contact_cta_title' => 'Ihre Frage nicht dabei?',
        'contact_cta_text' => 'Kontaktieren Sie uns gerne direkt – wir helfen Ihnen weiter.',
        'contact_cta_button' => 'Jetzt kontaktieren',
        
        'categories' => [
            'practice_info' => 'Praxisinformationen',
            'appointments' => 'Termine & Sprechzeiten',
            'services' => 'Leistungen',
            'first_visit' => 'Erster Besuch',
        ],
        
        'questions' => [
            'insurance_types' => [
                'question' => 'Welche Versicherungen akzeptieren Sie?',
                'answer' => 'Wir behandeln Patienten aller Krankenkassen: gesetzlich Versicherte, Privatpatienten und Selbstzahler. Bringen Sie bitte Ihre gültige Versichertenkarte zum Termin mit.',
            ],
            'new_patients' => [
                'question' => 'Nehmen Sie neue Patienten auf?',
                'answer' => 'Ja, wir nehmen gerne neue Patienten auf. Vereinbaren Sie einfach einen Termin über unser Kontaktformular oder rufen Sie uns an. Für Ihren ersten Besuch planen Sie bitte etwas mehr Zeit ein.',
            ],
            'appointment_speed' => [
                'question' => 'Wie schnell bekomme ich einen Termin?',
                'answer' => 'Routinetermine erhalten Sie in der Regel innerhalb von 1-2 Wochen. Für akute Beschwerden bieten wir kurzfristige Termine oder eine Akutsprechstunde an. Notfälle werden sofort behandelt.',
            ],
            'same_day' => [
                'question' => 'Bieten Sie Termine am selben Tag an?',
                'answer' => 'Ja, für akute Erkrankungen und Notfälle haben wir täglich Termine reserviert. Rufen Sie am besten morgens an oder nutzen Sie unsere Akutsprechstunde von 8:00-9:00 Uhr.',
            ],
            'online_booking' => [
                'question' => 'Kann ich Termine online buchen?',
                'answer' => 'Sie können Terminwünsche über unser Kontaktformular senden. Wir melden uns dann zeitnah bei Ihnen zur Bestätigung. Für Notfälle rufen Sie bitte direkt an.',
            ],
            'what_to_bring' => [
                'question' => 'Was sollte ich zum ersten Besuch mitbringen?',
                'answer' => 'Bringen Sie bitte mit: Ihre Versichertenkarte, einen Lichtbildausweis, aktuelle Medikamentenliste, Vorbefunde und Überweisungen falls vorhanden. Bei Privatpatienten auch die Versicherungsunterlagen.',
            ],
            'insurance_card' => [
                'question' => 'Was passiert, wenn ich meine Versichertenkarte vergessen habe?',
                'answer' => 'Ohne gültige Versichertenkarte müssen wir die Behandlung zunächst privat abrechnen. Sie können die Kosten später bei Ihrer Krankenkasse einreichen. Bringen Sie die Karte bitte beim nächsten Besuch mit.',
            ],
            'medical_certificates' => [
                'question' => 'Stellen Sie Arbeitsunfähigkeitsbescheinigungen aus?',
                'answer' => 'Ja, wir stellen alle notwendigen Bescheinigungen aus: Arbeitsunfähigkeitsbescheinigungen, Atteste für Schule/Studium, Reisefähigkeitsbescheinigungen und weitere medizinische Gutachten nach Bedarf.',
            ],
            'preventive_care' => [
                'question' => 'Welche Vorsorgeuntersuchungen bieten Sie an?',
                'answer' => 'Wir bieten alle Kassenleistungen: Check-up 35+, Krebsvorsorge, Hautkrebsscreening, Impfberatung und weitere Präventionsleistungen. Termine dafür erhalten Sie in der Regel kurzfristig.',
            ],
            'house_calls' => [
                'question' => 'Machen Sie auch Hausbesuche?',
                'answer' => 'Ja, bei schwer erkrankten oder immobilen Patienten führen wir Hausbesuche durch. Diese sind nur nach Anmeldung und medizinischer Indikation möglich. Rufen Sie uns für die Terminabsprache an.',
            ],
        ],
    ],

    // Legal Pages
    'legal' => [
        'nav' => [
            'privacy' => 'Datenschutz',
            'imprint' => 'Impressum',
            'terms' => 'AGB',
        ],

        // Privacy Policy (Datenschutzerklärung)
        'privacy' => [
            'title' => 'Datenschutzerklärung',
            'subtitle' => 'Informationen zur Verarbeitung Ihrer personenbezogenen Daten',
            'meta_description' => 'Datenschutzerklärung der Hausarztpraxis - Informationen zur Verarbeitung personenbezogener Daten gemäß DSGVO.',

            'controller' => [
                'title' => 'Verantwortlicher für die Datenverarbeitung',
                'practice_name' => 'Hausarztpraxis Dr. med. Max Mustermann',
                'phone' => 'Telefon',
                'email' => 'E-Mail',
            ],

            'processing' => [
                'title' => 'Datenverarbeitung',
                'intro' => 'Wir verarbeiten personenbezogene Daten nur im Rahmen der gesetzlichen Bestimmungen. Nachfolgend informieren wir Sie über Art, Umfang und Zweck der Erhebung und Verwendung Ihrer Daten.',

                'contact_form' => [
                    'title' => 'Kontaktformular',
                    'description' => 'Wenn Sie unser Kontaktformular nutzen, werden die von Ihnen eingegebenen Daten zur Bearbeitung Ihrer Anfrage und für den Fall von Anschlussfragen bei uns gespeichert:',
                    'data' => [
                        'name' => 'Vor- und Nachname',
                        'email' => 'E-Mail-Adresse',
                        'phone' => 'Telefonnummer (optional)',
                        'message' => 'Ihre Nachricht (optional)',
                        'appointment_time' => 'Gewünschter Terminzeitpunkt (optional)',
                    ],
                    'legal_basis' => 'Rechtsgrundlage für die Verarbeitung ist Art. 6 Abs. 1 lit. b DSGVO (Vertragsanbahnung) sowie Art. 6 Abs. 1 lit. f DSGVO (berechtigtes Interesse an der Bearbeitung Ihrer Anfrage).',
                ],
            ],

            'rights' => [
                'title' => 'Ihre Rechte als Patient',
                'intro' => 'Sie haben folgende Rechte bezüglich Ihrer personenbezogenen Daten:',
                'access' => [
                    'title' => 'Auskunftsrecht',
                    'description' => 'Sie können Auskunft über die von uns verarbeiteten personenbezogenen Daten verlangen.',
                ],
                'rectification' => [
                    'title' => 'Recht auf Berichtigung',
                    'description' => 'Sie haben das Recht, die Berichtigung unrichtiger Daten zu verlangen.',
                ],
                'erasure' => [
                    'title' => 'Recht auf Löschung',
                    'description' => 'Sie können die Löschung Ihrer Daten verlangen, soweit keine gesetzlichen Aufbewahrungsfristen bestehen.',
                ],
                'portability' => [
                    'title' => 'Recht auf Datenübertragbarkeit',
                    'description' => 'Sie haben das Recht, Ihre Daten in einem strukturierten Format zu erhalten.',
                ],
                'objection' => [
                    'title' => 'Widerspruchsrecht',
                    'description' => 'Sie können der Verarbeitung Ihrer Daten widersprechen, soweit diese auf berechtigten Interessen beruht.',
                ],
            ],

            'storage' => [
                'title' => 'Speicherdauer',
                'description' => 'Ihre Daten werden nur so lange gespeichert, wie dies für die Zwecke erforderlich ist, für die sie erhoben wurden, oder soweit gesetzliche Aufbewahrungsfristen bestehen. Patientendaten unterliegen der gesetzlichen Aufbewahrungsfrist von 10 Jahren nach Abschluss der Behandlung.',
            ],

            'confidentiality' => [
                'title' => 'Ärztliche Schweigepflicht',
                'description' => 'Als Ärzte unterliegen wir der besonderen ärztlichen Schweigepflicht nach § 203 StGB. Alle Mitarbeiter unserer Praxis sind auf das Datengeheimnis verpflichtet und wurden entsprechend geschult.',
            ],

            'third_party' => [
                'title' => 'Weitergabe an Dritte',
                'description' => 'Eine Übermittlung Ihrer Daten an Dritte erfolgt nur in folgenden Fällen: bei Ihrer ausdrücklichen Einwilligung, wenn die Weitergabe zur Behandlung erforderlich ist (z.B. an Fachärzte oder Labore), oder wenn eine gesetzliche Verpflichtung besteht.',
            ],

            'security' => [
                'title' => 'Datensicherheit',
                'description' => 'Wir treffen technische und organisatorische Maßnahmen, um Ihre Daten vor Verlust, Manipulation oder unberechtigtem Zugriff zu schützen. Unsere Sicherheitsmaßnahmen werden entsprechend der technologischen Entwicklung fortlaufend verbessert.',
            ],

            'contact' => [
                'title' => 'Kontakt bei Datenschutzfragen',
                'description' => 'Bei Fragen zum Datenschutz oder zur Geltendmachung Ihrer Rechte wenden Sie sich bitte an:',
                'email' => 'E-Mail',
                'phone' => 'Telefon',
            ],

            'last_updated' => 'Letzte Aktualisierung',
            'last_updated_date' => 'Januar 2025',
        ],

        // Imprint (Impressum)
        'imprint' => [
            'title' => 'Impressum',
            'subtitle' => 'Angaben gemäß § 5 TMG und berufsrechtlichen Vorschriften',
            'meta_description' => 'Impressum der Hausarztpraxis mit allen gesetzlich vorgeschriebenen Angaben gemäß TMG und Heilberufsgesetzen.',

            'practice_info' => [
                'title' => 'Praxisinhaber',
                'name' => 'Hausarztpraxis Dr. med. Max Mustermann',
                'owner' => 'Dr. med. Max Mustermann',
                'phone' => 'Telefon',
                'email' => 'E-Mail',
            ],

            'professional' => [
                'title' => 'Berufsbezeichnung',
                'designation' => 'Berufsbezeichnung',
                'designation_value' => 'Arzt',
                'state' => 'Verliehen in',
                'state_value' => 'Deutschland',
                'license' => 'Approbation',
                'license_value' => 'Erteilte Approbation als Arzt',
            ],

            'authority' => [
                'title' => 'Zuständige Aufsichtsbehörde',
                'name' => 'Kassenärztliche Vereinigung',
                'address' => 'Musterstraße 456, 12345 Musterstadt',
                'website' => 'Website',
                'website_url' => 'https://www.kv-example.de',
            ],

            'regulations' => [
                'title' => 'Berufsrechtliche Regelungen',
                'description' => 'Die Berufsausübung unterliegt folgenden berufsrechtlichen Regelungen:',
                'bo_title' => 'Berufsordnung für Ärzte',
                'bo_url' => 'https://www.bundesaerztekammer.de',
                'gebgo_title' => 'Gebührenordnung für Ärzte (GOÄ)',
                'gebgo_url' => 'https://www.bundesaerztekammer.de',
                'mbo_title' => 'Musterberufsordnung für Ärzte',
                'mbo_url' => 'https://www.bundesaerztekammer.de',
            ],

            'insurance' => [
                'title' => 'Berufshaftpflichtversicherung',
                'company' => 'Versicherungsgesellschaft',
                'company_value' => 'Muster Versicherung AG',
                'address' => 'Anschrift der Versicherung',
                'address_value' => 'Versicherungsstraße 123, 12345 Versicherungsstadt',
                'coverage' => 'Geltungsbereich',
                'coverage_value' => 'Deutschland/Europa',
            ],

            'dispute' => [
                'title' => 'Verbraucherschlichtung',
                'description' => 'Wir nehmen an Streitbeilegungsverfahren vor einer Verbraucherschlichtungsstelle teil:',
                'board_name' => 'Schlichtungsstelle für Arzthaftpflichtfragen bei den Ärztekammern',
                'board_address' => 'Musterstraße 789, 12345 Schlichtungsstadt',
                'website' => 'Website',
                'website_url' => 'https://www.schlichtungsstelle-example.de',
            ],

            'eu_dispute' => [
                'title' => 'EU-Streitschlichtung',
                'description' => 'Die Europäische Kommission stellt eine Plattform zur Online-Streitbeilegung (OS) bereit:',
                'platform_url' => 'https://ec.europa.eu/consumers/odr/',
            ],

            'copyright' => [
                'title' => 'Urheberrecht',
                'description' => 'Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht. Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechtes bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers.',
            ],

            'disclaimer' => [
                'title' => 'Haftungsausschluss',
                'content' => 'Die Inhalte unserer Seiten wurden mit größter Sorgfalt erstellt. Für die Richtigkeit, Vollständigkeit und Aktualität der Inhalte können wir jedoch keine Gewähr übernehmen.',
                'links' => 'Als Diensteanbieter sind wir für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich. Wir sind jedoch nicht verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen.',
            ],

            'last_updated' => 'Letzte Aktualisierung',
            'last_updated_date' => 'Januar 2025',
        ],

        // Terms of Service (AGB)
        'terms' => [
            'title' => 'Allgemeine Geschäftsbedingungen',
            'subtitle' => 'Behandlungsvertrag und Praxisordnung',
            'meta_description' => 'Allgemeine Geschäftsbedingungen der Hausarztpraxis für Patienten und Behandlungsverträge.',

            'scope' => [
                'title' => '1. Geltungsbereich',
                'description' => 'Diese Allgemeinen Geschäftsbedingungen gelten für alle Behandlungsverträge zwischen der Praxis und ihren Patienten. Sie regeln die Rechte und Pflichten beider Vertragsparteien und dienen der Sicherstellung einer ordnungsgemäßen medizinischen Versorgung.',
            ],

            'appointments' => [
                'title' => '2. Terminvereinbarung',
                'booking' => [
                    'title' => 'Terminbuchung',
                    'description' => 'Termine können auf folgenden Wegen vereinbart werden:',
                    'online' => 'Online über das Kontaktformular unserer Website',
                    'phone' => 'Telefonisch während der Sprechzeiten',
                    'person' => 'Persönlich in der Praxis',
                ],
                'confirmation' => [
                    'title' => 'Terminbestätigung',
                    'description' => 'Online gebuchte Termine sind erst nach unserer Bestätigung verbindlich. Sie erhalten eine Bestätigung per E-Mail oder Telefon.',
                ],
            ],

            'cancellation' => [
                'title' => '3. Terminabsagen und -änderungen',
                'notice' => [
                    'title' => 'Wichtiger Hinweis',
                    'description' => 'Bitte sagen Sie Termine mindestens 24 Stunden vorher ab, damit wir anderen Patienten helfen können.',
                ],
                'patient' => [
                    'title' => 'Absage durch den Patienten',
                    'description' => 'Termine sollten mindestens 24 Stunden vor dem vereinbarten Termin abgesagt werden. Bei kurzfristigen Absagen oder Nichterscheinen können Ausfallgebühren erhoben werden, sofern der Termin nicht anderweitig besetzt werden kann.',
                ],
                'practice' => [
                    'title' => 'Absage durch die Praxis',
                    'description' => 'In dringenden Fällen (Notfall, Krankheit des Arztes) müssen wir Termine absagen. Wir bemühen uns um schnellstmögliche Benachrichtigung und bieten Ersatztermine an.',
                ],
                'no_show' => [
                    'title' => 'Nichterscheinen',
                    'description' => 'Bei wiederholtem Nichterscheinen ohne Absage behalten wir uns vor, zukünftige Termine nur noch gegen Vorauszahlung oder Kaution zu vergeben.',
                ],
            ],

            'patient_obligations' => [
                'title' => '4. Pflichten des Patienten',
                'punctuality' => 'Pünktliches Erscheinen zu vereinbarten Terminen',
                'insurance' => 'Mitbringen der gültigen Versichertenkarte und ggf. Überweisungsscheine',
                'information' => 'Vollständige und wahrheitsgemäße Angaben zu Beschwerden und Vorerkrankungen',
                'medication' => 'Information über aktuelle Medikamenteneinnahme und Allergien',
                'respect' => 'Respektvoller Umgang mit Personal und anderen Patienten',
            ],

            'practice_obligations' => [
                'title' => '5. Pflichten der Praxis',
                'care' => 'Sorgfältige medizinische Behandlung nach dem aktuellen Stand der Medizin',
                'confidentiality' => 'Einhaltung der ärztlichen Schweigepflicht',
                'standards' => 'Beachtung der Berufsordnung und Qualitätsstandards',
                'information' => 'Aufklärung über Diagnosen und Behandlungsmöglichkeiten',
                'emergency' => 'Notfallversorgung während der Sprechzeiten',
            ],

            'waiting_times' => [
                'title' => '6. Wartezeiten',
                'description' => 'Wir bemühen uns, Wartezeiten zu minimieren. Gelegentliche Wartezeiten können durch Notfälle oder unvorhergesehene Behandlungsverläufe entstehen. Wir bitten um Ihr Verständnis.',
                'emergency' => [
                    'title' => 'Notfälle haben Vorrang',
                    'description' => 'Akute Notfälle werden immer bevorzugt behandelt, auch wenn dies zu Wartezeiten für andere Patienten führt.',
                ],
            ],

            'liability' => [
                'title' => '7. Haftung',
                'practice' => [
                    'title' => 'Haftung der Praxis',
                    'description' => 'Wir haften für Schäden aus der Verletzung des Lebens, des Körpers oder der Gesundheit sowie für sonstige Schäden, die auf einer vorsätzlichen oder grob fahrlässigen Pflichtverletzung beruhen.',
                ],
                'patient' => [
                    'title' => 'Mitwirkungspflicht des Patienten',
                    'description' => 'Der Behandlungserfolg hängt auch von der Mitarbeit des Patienten ab. Befolgen Sie die ärztlichen Anweisungen und Therapieempfehlungen.',
                ],
                'limitation' => [
                    'title' => 'Haftungsbeschränkung',
                    'description' => 'Eine Haftung für leichte Fahrlässigkeit besteht nur bei der Verletzung wesentlicher Vertragspflichten. Die Haftung ist auf den bei Vertragsschluss vorhersehbaren Schaden begrenzt.',
                ],
            ],

            'data_protection' => [
                'title' => '8. Datenschutz',
                'description' => 'Die Verarbeitung Ihrer personenbezogenen Daten erfolgt nach den Bestimmungen der DSGVO und des BDSG. Weitere Informationen finden Sie in unserer',
                'link_text' => 'Datenschutzerklärung',
            ],

            'applicable_law' => [
                'title' => '9. Anwendbares Recht',
                'description' => 'Es gilt deutsches Recht unter Ausschluss des UN-Kaufrechts.',
            ],

            'dispute_resolution' => [
                'title' => '10. Streitbeilegung',
                'description' => 'Bei Streitigkeiten stehen wir für außergerichtliche Lösungen zur Verfügung. Zuständig ist die Schlichtungsstelle für Arzthaftpflichtfragen bei der Ärztekammer.',
            ],

            'severability' => [
                'title' => '11. Salvatorische Klausel',
                'description' => 'Sollten einzelne Bestimmungen dieser AGB unwirksam sein oder werden, bleibt die Wirksamkeit der übrigen Bestimmungen unberührt. Die unwirksame Bestimmung wird durch eine wirksame ersetzt, die dem Zweck der unwirksamen am nächsten kommt.',
            ],

            'changes' => [
                'title' => '12. Änderungen der AGB',
                'description' => 'Änderungen dieser AGB werden rechtzeitig bekannt gegeben. Widersprechen Sie nicht innerhalb von 6 Wochen, gelten die Änderungen als angenommen.',
            ],

            'emergency_info' => [
                'title' => 'Notfall außerhalb der Sprechzeiten',
                'description' => 'Bei medizinischen Notfällen außerhalb unserer Sprechzeiten wenden Sie sich an:',
                'number' => 'Ärztlicher Bereitschaftsdienst',
            ],

            'last_updated' => 'Letzte Aktualisierung',
            'last_updated_date' => 'Januar 2025',
        ],
    ],

    // Theme
    'theme' => [
        'light' => 'Hell',
        'dark' => 'Dunkel',
        'toggle_label' => 'Zwischen hellem und dunklem Design wechseln',
        'toggle_to' => 'Zu :theme Design wechseln',
        'current_theme' => 'Aktuelles Design: :theme',
        'switched_to' => 'Design gewechselt zu :theme',
        'system_preference' => 'Systemeinstellung folgen',
        'auto_detect' => 'Automatisch erkennen',
        'manual_override' => 'Manuell ausgewählt',
    ],
];