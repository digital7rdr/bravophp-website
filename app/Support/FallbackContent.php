<?php

declare(strict_types=1);

namespace App\Support;

final class FallbackContent
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function pages(): array
    {
        return [
            [
                'id' => 1,
                'slug' => 'home',
                'menu_label' => 'Home',
                'title' => 'Controlled Security Support',
                'meta_description' => 'Controlled movement, protected communication, real-time risk awareness, and vetted operational support.',
                'eyebrow' => '',
                'headline' => 'Controlled Security Support.',
                'body' => 'Bravo Secure provides secure movement, protected communication, real-time risk awareness, and vetted operational support for individuals and organisations.',
                'hero_image' => 'hero-home.jpg',
                'hero_media_type' => 'image',
                'primary_label' => 'Request Support',
                'primary_url' => '/contact',
                'secondary_label' => 'View Services',
                'secondary_url' => '/services',
                'cta_headline' => 'Need controlled support?',
                'cta_body' => '',
                'cta_label' => 'Contact Bravo Secure',
                'cta_url' => '/contact',
                'sort_order' => 10,
                'is_published' => 1,
            ],
            [
                'id' => 2,
                'slug' => 'services',
                'menu_label' => 'Services',
                'title' => 'On-Demand Transfers and Time Slots',
                'meta_description' => 'Secure transfers and scheduled time-slot services for individuals and organisations.',
                'eyebrow' => 'Bravo Secure Services',
                'headline' => 'On-Demand Transfers and Time Slots.',
                'body' => 'Bravo Secure provides controlled movement support through secure transfers and scheduled time-slot services for individuals and organisations.',
                'hero_image' => 'hero-services.jpg',
                'hero_media_type' => 'image',
                'primary_label' => 'Request Support',
                'primary_url' => '/contact',
                'secondary_label' => 'Contact Bravo',
                'secondary_url' => '/contact',
                'cta_headline' => 'Need movement support?',
                'cta_body' => '',
                'cta_label' => 'Contact Bravo',
                'cta_url' => '/contact',
                'sort_order' => 20,
                'is_published' => 1,
            ],
            [
                'id' => 3,
                'slug' => 'bravo-comms',
                'menu_label' => 'Bravo Comms',
                'title' => 'Bravo Comms',
                'meta_description' => 'Protected communication and secure vault storage for sensitive information.',
                'eyebrow' => 'Bravo Comms',
                'headline' => 'Bravo Comms.',
                'body' => 'Protected communication for individuals, teams, and organisations. Secure vault storage for files, documents, and sensitive information.',
                'hero_image' => 'hero-comms.jpg',
                'hero_media_type' => 'image',
                'primary_label' => 'Learn More',
                'primary_url' => '#features',
                'secondary_label' => 'View Features',
                'secondary_url' => '#features',
                'cta_headline' => 'Need protected communication and secure storage?',
                'cta_body' => 'Speak to Bravo about secure communication and vault storage for you and your organisation.',
                'cta_label' => 'Contact Bravo',
                'cta_url' => '/contact',
                'sort_order' => 30,
                'is_published' => 1,
            ],
            [
                'id' => 4,
                'slug' => 'virtual-bodyguard',
                'menu_label' => 'Virtual Bodyguard',
                'title' => 'Real-Time Risk Awareness',
                'meta_description' => 'Live alerts, risk awareness, mitigation guidance, and escalation support.',
                'eyebrow' => 'Virtual Bodyguard',
                'headline' => 'Real-Time Risk Awareness.',
                'body' => 'Virtual Bodyguard helps individuals and organisations stay informed through live alerts, risk awareness, mitigation guidance, and escalation support.',
                'hero_image' => 'hero-virtual-bodyguard.jpg',
                'hero_media_type' => 'image',
                'primary_label' => 'Contact Bravo',
                'primary_url' => '/contact',
                'secondary_label' => 'Learn More',
                'secondary_url' => '#features',
                'cta_headline' => 'Need risk awareness support?',
                'cta_body' => 'Speak to Bravo about Virtual Bodyguard support for you or your organisation.',
                'cta_label' => 'Contact Bravo',
                'cta_url' => '/contact',
                'sort_order' => 40,
                'is_published' => 1,
            ],
            [
                'id' => 5,
                'slug' => 'agent-network',
                'menu_label' => 'Agent Network',
                'title' => 'Agent Onboarding',
                'meta_description' => 'Controlled onboarding for a trusted operational network.',
                'eyebrow' => 'Agent Onboarding',
                'headline' => 'Agent Onboarding.',
                'body' => 'Bravo Secure uses a controlled onboarding process to build a trusted operational network. Every applicant is reviewed before being accepted into the system.',
                'hero_image' => 'hero-agent-network.jpg',
                'hero_media_type' => 'image',
                'primary_label' => 'Contact Bravo',
                'primary_url' => '/contact',
                'secondary_label' => 'Learn More',
                'secondary_url' => '#features',
                'cta_headline' => 'Built through control, not open access.',
                'cta_body' => 'Bravo Secure does not operate as an open marketplace. The network is built through controlled selection, verification, and professional standards.',
                'cta_label' => 'Contact Bravo',
                'cta_url' => '/contact',
                'sort_order' => 50,
                'is_published' => 1,
            ],
            [
                'id' => 6,
                'slug' => 'about',
                'menu_label' => 'About',
                'title' => 'About Bravo Secure',
                'meta_description' => 'Controlled security support built on discretion, planning, and operational professionalism.',
                'eyebrow' => '',
                'headline' => 'About Bravo Secure.',
                'body' => "We provide controlled security support for individuals and organisations.\n\nOur approach is built on discretion, planning, and operational professionalism.",
                'hero_image' => 'hero-about.jpg',
                'hero_media_type' => 'image',
                'primary_label' => '',
                'primary_url' => '',
                'secondary_label' => '',
                'secondary_url' => '',
                'cta_headline' => 'Need to speak with Bravo?',
                'cta_body' => "We're here to understand your needs and provide the right support.",
                'cta_label' => 'Speak to Bravo',
                'cta_url' => '/contact',
                'sort_order' => 60,
                'is_published' => 1,
            ],
            [
                'id' => 7,
                'slug' => 'contact',
                'menu_label' => 'Contact',
                'title' => 'Get in touch with Bravo',
                'meta_description' => 'Contact Bravo Secure for controlled security support.',
                'eyebrow' => 'Contact Us',
                'headline' => 'Get in touch with Bravo.',
                'body' => "We're here to understand your needs and provide the right controlled support.",
                'hero_image' => 'hero-contact.jpg',
                'hero_media_type' => 'image',
                'primary_label' => 'Send Message',
                'primary_url' => '#contact-form',
                'secondary_label' => '',
                'secondary_url' => '',
                'cta_headline' => 'Need immediate assistance?',
                'cta_body' => 'For urgent operational matters, call our secure line.',
                'cta_label' => 'Speak to Bravo',
                'cta_url' => '/contact',
                'sort_order' => 70,
                'is_published' => 1,
            ],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function groupsFor(string $slug): array
    {
        $groups = [
            'home' => [
                ['title' => 'What We Do', 'layout' => 'icon-grid', 'items' => [
                    ['icon' => 'shield', 'title' => 'Secure Services', 'body' => 'Transfers, time slots, and operational support.'],
                    ['icon' => 'message', 'title' => 'Bravo Comms', 'body' => 'Protected communication for teams and organisations.'],
                    ['icon' => 'target', 'title' => 'Virtual Bodyguard', 'body' => 'Risk awareness, alerts, and escalation support.'],
                    ['icon' => 'users', 'title' => 'Agent Network', 'body' => 'Vetted professionals and company partners.'],
                ]],
            ],
            'services' => [
                ['title' => 'How It Works', 'layout' => 'steps', 'items' => [
                    ['icon' => 'check', 'title' => '1. Request', 'body' => 'Tell us where, when, and what support is needed.'],
                    ['icon' => 'check', 'title' => '2. Review', 'body' => 'Bravo checks timing, location, risk, and availability.'],
                    ['icon' => 'check', 'title' => '3. Support', 'body' => 'Your transfer or time slot is confirmed and managed.'],
                ]],
                ['title' => 'Service Options', 'layout' => 'cards', 'items' => [
                    ['icon' => 'car', 'title' => 'Transfers', 'body' => 'On-demand point-to-point secure movement between locations. Ideal for airport transfers, meetings, and direct routes.', 'note' => 'Best for direct A to B movement.'],
                    ['icon' => 'clock', 'title' => 'Time Slots', 'body' => 'On-demand booking for a fixed period when movement is flexible or includes multiple stops.', 'note' => 'Best when support is needed by the hour.'],
                    ['icon' => 'shield', 'title' => 'Retainers', 'body' => "Longer-term security support arranged around a client's specific needs.", 'note' => 'Available on request and tailored to the client.'],
                ]],
            ],
            'bravo-comms' => [
                ['title' => 'What Bravo Comms Offers', 'layout' => 'cards', 'items' => [
                    ['icon' => 'message', 'title' => 'Individual Chats', 'body' => 'Protected one-to-one communication for direct coordination.'],
                    ['icon' => 'users', 'title' => 'Group Chats', 'body' => 'Secure communication for small teams and active operations.'],
                    ['icon' => 'building', 'title' => 'Department Channels', 'body' => 'Structured communication across departments and larger organisations.'],
                    ['icon' => 'lock', 'title' => 'Secure Vault', 'body' => 'Encrypted storage for documents, media, and sensitive files.'],
                ]],
                ['title' => 'Why Bravo Comms', 'layout' => 'inline', 'items' => [
                    ['icon' => 'shield', 'title' => 'Secure', 'body' => 'End-to-end encryption and secure storage for protected communication and data.'],
                    ['icon' => 'layers', 'title' => 'Structured', 'body' => 'Organised communication and information, built for operational clarity.'],
                    ['icon' => 'check', 'title' => 'Reliable', 'body' => 'Built for real-world use with high availability and secure performance.'],
                    ['icon' => 'chart', 'title' => 'Scalable', 'body' => 'For individuals, teams, and organisations of any size.'],
                ]],
            ],
            'virtual-bodyguard' => [
                ['title' => 'What It Does', 'layout' => 'cards', 'items' => [
                    ['icon' => 'bell', 'title' => 'Live Alerts', 'body' => 'Stay informed with relevant updates and incident alerts.'],
                    ['icon' => 'shield', 'title' => 'Risk Awareness', 'body' => 'Understand nearby risks and changing conditions.'],
                    ['icon' => 'list', 'title' => 'Mitigation Guidance', 'body' => 'Receive practical steps to reduce exposure and respond early.'],
                    ['icon' => 'headset', 'title' => 'Escalation Support', 'body' => 'Escalate concerns when support or intervention is needed.'],
                ]],
                ['title' => 'Why Virtual Bodyguard', 'layout' => 'inline', 'items' => [
                    ['icon' => 'clock', 'title' => 'Proactive', 'body' => 'Helps you stay ahead of developing issues.'],
                    ['icon' => 'list', 'title' => 'Clear', 'body' => 'Simple information with practical next steps.'],
                    ['icon' => 'shield', 'title' => 'Reliable', 'body' => 'Built for real-world movement and operations.'],
                    ['icon' => 'users', 'title' => 'Supportive', 'body' => 'Designed for individuals, teams, and organisations.'],
                ]],
            ],
            'agent-network' => [
                ['title' => 'Onboarding Paths', 'layout' => 'wide-cards', 'items' => [
                    ['icon' => 'users', 'title' => 'Individual Onboarding', 'body' => 'Individual onboarding is for qualified and certified personnel seeking employment opportunities within the Bravo Secure network. Applicants must provide relevant experience, certifications, identification, and supporting documents for review.'],
                    ['icon' => 'building', 'title' => 'Corporate Onboarding', 'body' => "Corporate onboarding is for vetted security companies that can extend Bravo Secure's service reach. Companies must show their licensing, operational capability, service standards, and ability to support clients professionally."],
                ]],
                ['title' => 'Our Approach', 'layout' => 'inline', 'items' => [
                    ['icon' => 'shield', 'title' => 'Controlled Selection', 'body' => 'By design, not default.'],
                    ['icon' => 'search', 'title' => 'Verification', 'body' => 'Check. Confirm. Validate.'],
                    ['icon' => 'star', 'title' => 'Professional Standards', 'body' => 'Experience. Conduct. Reliability.'],
                    ['icon' => 'users', 'title' => 'Trusted Network', 'body' => 'Quality over quantity.'],
                ]],
            ],
            'about' => [
                ['title' => '', 'layout' => 'icon-grid', 'items' => [
                    ['icon' => 'shield', 'title' => 'Our Purpose', 'body' => 'To deliver controlled security support that protects people, information, and operations.'],
                    ['icon' => 'target', 'title' => 'Our Approach', 'body' => 'Risk-aware planning, vetted resources, and professional execution.'],
                    ['icon' => 'lock', 'title' => 'Our Commitment', 'body' => 'Discretion, integrity, and accountability in everything we do.'],
                    ['icon' => 'users', 'title' => 'Our Network', 'body' => 'Trusted professionals and partners, selected to our standards.'],
                ]],
                ['title' => 'Who We Support', 'layout' => 'split-list', 'intro' => 'We support individuals, executives, families, and organisations with secure movement, protected communication, risk awareness, and operational support.', 'items' => [
                    ['icon' => 'users', 'title' => 'Individuals & Families', 'body' => 'Personal security and controlled movement.'],
                    ['icon' => 'briefcase', 'title' => 'Executives', 'body' => 'Executive protection and secure travel support.'],
                    ['icon' => 'building', 'title' => 'Organisations', 'body' => 'Risk-aware operational and communication support.'],
                    ['icon' => 'globe', 'title' => 'Partners', 'body' => 'Trusted companies extending our service reach.'],
                ]],
            ],
            'contact' => [
                ['title' => 'Other ways to reach us', 'layout' => 'cards', 'items' => [
                    ['icon' => 'mail', 'title' => 'Email', 'body' => 'info@bravo-secure.com', 'note' => 'We aim to respond within 24 hours.'],
                    ['icon' => 'phone', 'title' => 'Secure Line', 'body' => '+1 (555) 817-7332', 'note' => 'Available during operational hours.'],
                    ['icon' => 'clock', 'title' => 'Operational Hours', 'body' => 'Monday - Friday 09:00 - 18:00 (Local Time)', 'note' => 'By appointment only.'],
                    ['icon' => 'target', 'title' => 'Global Support', 'body' => 'Bravo Secure supports clients worldwide with trusted partners.'],
                ]],
                ['title' => 'Before you reach out', 'layout' => 'checklist', 'intro' => 'To help us review your request efficiently, please be ready to provide:', 'items' => [
                    ['icon' => 'check', 'title' => 'Your location and time zone', 'body' => ''],
                    ['icon' => 'check', 'title' => 'Preferred dates or time slots', 'body' => ''],
                    ['icon' => 'check', 'title' => 'Type of support or service needed', 'body' => ''],
                    ['icon' => 'check', 'title' => 'Any relevant details or documents', 'body' => ''],
                ]],
            ],
        ];

        return $groups[$slug] ?? [];
    }
}
