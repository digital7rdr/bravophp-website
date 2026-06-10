<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Site content (ported from the Next.js build). Phase 1 serves these arrays
 * directly; Phase 2 will move them into MySQL for editing via the admin.
 */
final class SiteContent
{
    /** @return array<string,mixed> */
    public static function site(): array
    {
        $base = [
            'brandName' => 'Bravo Secure',
            'brandMark' => \App\Models\Setting::get('brand_mark', 'BRAVO'),
            'logo' => \App\Models\Setting::get('logo', ''),
            'icon' => \App\Models\Setting::get('icon', ''),
            'logoSize' => \App\Models\Setting::get('logo_size', 'Medium'),
            'menu' => [
                ['icon' => 'home', 'label' => 'Home', 'href' => '/'],
                ['icon' => 'list', 'label' => 'Request Support', 'href' => '/request-support'],
                ['icon' => 'shield', 'label' => 'Secure Services', 'href' => '/secure-services'],
                ['icon' => 'target', 'label' => 'Virtual Bodyguard', 'href' => '/virtual-bodyguard'],
                ['icon' => 'message', 'label' => 'Bravo Comms', 'href' => '/bravo-comms'],
                ['icon' => 'calendar', 'label' => 'Long-Term Bookings', 'href' => '/long-term-bookings'],
                ['icon' => 'users', 'label' => 'Agent Network', 'href' => '/agent-network'],
                ['icon' => 'building', 'label' => 'About', 'href' => '/about'],
                ['icon' => 'headset', 'label' => 'Contact', 'href' => '/contact'],
            ],
            'navCtas' => [
                ['label' => 'Manage Request', 'href' => '/manage', 'style' => 'ghost'],
                ['label' => 'Request Support', 'href' => '/request-support', 'style' => 'primary'],
            ],
            'footer' => [
                'blurb' => 'Bravo Secure is a controlled operational platform for secure mobility, communication, risk awareness, and executive support. Every request is reviewed before confirmation.',
                'columns' => [
                    ['title' => 'Services', 'links' => [
                        ['label' => 'Request Support', 'href' => '/request-support'],
                        ['label' => 'Secure Services', 'href' => '/secure-services'],
                        ['label' => 'Long-Term Bookings', 'href' => '/long-term-bookings'],
                        ['label' => 'Manage Request', 'href' => '/manage'],
                    ]],
                    ['title' => 'Platform', 'links' => [
                        ['label' => 'Bravo Comms', 'href' => '/bravo-comms'],
                        ['label' => 'Virtual Bodyguard', 'href' => '/virtual-bodyguard'],
                        ['label' => 'Agent Network', 'href' => '/agent-network'],
                    ]],
                    ['title' => 'Company', 'links' => [
                        ['label' => 'About', 'href' => '/about'],
                        ['label' => 'Contact', 'href' => '/contact'],
                        ['label' => 'Manage Request', 'href' => '/manage'],
                    ]],
                ],
                'legal' => 'Bravo Secure operates a reviewed, controlled process. Information is treated with confidentiality.',
            ],
            'contact' => [
                'email' => 'info@bravo-secure.com',
                'phone' => '+1 (555) 817-7332',
                'hours' => 'Monday – Friday 09:00 – 18:00 (Local Time)',
            ],
        ];

        $override = \App\Models\Content::get('site');
        return is_array($override) ? self::deepMerge($base, $override) : $base;
    }

    /** @return array<string,mixed> */
    public static function request(): array
    {
        return [
            'heading' => 'Request Support',
            'subheading' => 'Requests are reviewed through the Bravo Control System before confirmation.',
            'button' => 'Submit Request',
            'helper' => 'Requests are reviewed before confirmation.',
            'serviceTabs' => [
                ['key' => 'secure-transfer', 'label' => 'Secure Transfer', 'fields' => [
                    ['name' => 'from', 'label' => 'From location', 'type' => 'text'],
                    ['name' => 'to', 'label' => 'To location', 'type' => 'text'],
                    ['name' => 'date', 'label' => 'Date', 'type' => 'date'],
                    ['name' => 'time', 'label' => 'Time', 'type' => 'time'],
                    ['name' => 'passengers', 'label' => 'Passengers', 'type' => 'number'],
                    ['name' => 'vips', 'label' => 'VIPs', 'type' => 'number'],
                    ['name' => 'vehicle', 'label' => 'Vehicle', 'type' => 'select', 'options' => ['Standard', 'SUV', 'Armoured', 'Convoy']],
                ]],
                ['key' => 'executive-protection', 'label' => 'Executive Protection', 'fields' => [
                    ['name' => 'location', 'label' => 'Location', 'type' => 'text'],
                    ['name' => 'date', 'label' => 'Date', 'type' => 'date'],
                    ['name' => 'time', 'label' => 'Time', 'type' => 'time'],
                    ['name' => 'duration', 'label' => 'Duration', 'type' => 'text'],
                    ['name' => 'people', 'label' => 'People to protect', 'type' => 'number'],
                    ['name' => 'risk', 'label' => 'Risk level', 'type' => 'select', 'options' => ['Standard', 'Elevated', 'High']],
                ]],
                ['key' => 'ongoing-support', 'label' => 'Ongoing Support', 'fields' => [
                    ['name' => 'supportType', 'label' => 'Support type', 'type' => 'select', 'options' => ['Residential', 'Executive', 'Family', 'Event']],
                    ['name' => 'startDate', 'label' => 'Start date', 'type' => 'date'],
                    ['name' => 'duration', 'label' => 'Duration', 'type' => 'text'],
                    ['name' => 'locations', 'label' => 'Locations', 'type' => 'text'],
                ]],
                ['key' => 'custom-request', 'label' => 'Custom Request', 'fields' => [
                    ['name' => 'requirement', 'label' => 'Describe your requirement', 'type' => 'textarea'],
                    ['name' => 'location', 'label' => 'Location', 'type' => 'text'],
                    ['name' => 'date', 'label' => 'Preferred date', 'type' => 'date'],
                ]],
            ],
            'contactFields' => [
                ['name' => 'name', 'label' => 'Name', 'type' => 'text'],
                ['name' => 'company', 'label' => 'Company / Family Office', 'type' => 'text'],
                ['name' => 'email', 'label' => 'Email', 'type' => 'email'],
                ['name' => 'phone', 'label' => 'Phone', 'type' => 'text'],
                ['name' => 'countryCity', 'label' => 'Country / City', 'type' => 'text'],
            ],
        ];
    }

    /** @return array<string,mixed>|null */
    public static function page(string $slug): ?array
    {
        $default = self::pages()[$slug] ?? null;
        if ($default === null) {
            return null;
        }
        $override = \App\Models\Content::get($slug);
        return is_array($override) ? self::deepMerge($default, $override) : $default;
    }

    /**
     * Merge an override over a default. Associative arrays merge recursively;
     * lists (e.g. card arrays) are replaced wholesale by the override.
     * @param array<string,mixed> $base
     * @param array<string,mixed> $over
     * @return array<string,mixed>
     */
    private static function deepMerge(array $base, array $over): array
    {
        foreach ($over as $k => $v) {
            if (
                array_key_exists($k, $base) && is_array($base[$k]) && is_array($v)
                && !array_is_list($base[$k]) && !array_is_list($v)
            ) {
                $base[$k] = self::deepMerge($base[$k], $v);
            } else {
                $base[$k] = $v;
            }
        }
        return $base;
    }

    /** @return array<string,array<string,mixed>> */
    public static function pages(): array
    {
        return [
            'home' => [
                'seo' => ['title' => 'Bravo Secure — Security in the palm of your hand', 'description' => 'Secure movement, executive protection, real-time risk awareness, SOS escalation, and approved provider support through one controlled platform.'],
                'hero' => ['image' => '', 'imagePosition' => 'center', 'eyebrow' => 'Operational security platform', 'headline' => 'Security in the palm of your hand.', 'subtext' => 'Secure movement, executive protection, real-time risk awareness, SOS escalation, and approved provider support — requested through one controlled platform.', 'primaryLabel' => 'Request Support', 'primaryHref' => '#request', 'secondaryLabel' => 'Explore Services', 'secondaryHref' => '/secure-services'],
                'exploreServices' => ['heading' => 'Explore Bravo Secure services', 'intro' => 'Reviewed, controlled support across mobility, protection, communication, and escalation.', 'cards' => [
                    ['icon' => 'shield', 'title' => 'Secure Services', 'body' => 'On-demand secure transfers, executive protection, and ongoing support.', 'href' => '/secure-services'],
                    ['icon' => 'target', 'title' => 'Virtual Bodyguard', 'body' => 'Real-time risk awareness and SOS escalation from your phone.', 'href' => '/virtual-bodyguard'],
                    ['icon' => 'message', 'title' => 'Bravo Comms', 'body' => 'Protected communication and operational control for teams.', 'href' => '/bravo-comms'],
                    ['icon' => 'calendar', 'title' => 'Long-Term Bookings', 'body' => 'Custom, continuous security support for ongoing needs.', 'href' => '/long-term-bookings'],
                    ['icon' => 'users', 'title' => 'Agent Network', 'body' => 'Vetted, approved providers delivering support to standard.', 'href' => '/agent-network'],
                ]],
                'why' => ['heading' => 'One controlled process', 'cards' => [
                    ['icon' => 'shield', 'title' => 'Controlled Requests', 'body' => 'Every request is reviewed through the Bravo Control System before confirmation.'],
                    ['icon' => 'check', 'title' => 'Approved Providers', 'body' => 'Support is delivered only through vetted, approved operators and partners.'],
                    ['icon' => 'headset', 'title' => 'Live Coordination', 'body' => 'Real-time communication and updates throughout your support.'],
                ]],
                'platform' => ['heading' => 'One platform for movement, protection and escalation', 'body' => 'Request secure transfers and protection, monitor live risk, communicate securely, and escalate in real time — all through one controlled Bravo Secure platform.', 'points' => ['Request and manage support in one place', 'Real-time risk awareness and SOS escalation', 'Approved provider coordination'], 'note' => 'Available on iOS and Android.'],
                'cta' => ['headline' => 'Need secure support?', 'body' => 'Our operators are ready to help 24/7.', 'label' => 'Submit Request', 'href' => '/request-support'],
            ],

            'request-support' => [
                'seo' => ['title' => 'Request Support — Bravo Secure', 'description' => 'Submit your movement, protection or support requirement through one controlled platform.'],
                'hero' => ['image' => '', 'eyebrow' => 'Request Support', 'headline' => 'Request secure support in minutes.', 'subtext' => 'Submit your movement, protection or support requirement through one controlled platform.', 'primaryLabel' => 'Start Request', 'primaryHref' => '#request', 'secondaryLabel' => 'Speak to Bravo', 'secondaryHref' => '/contact'],
                'panel' => true,
                'assurance' => ['cards' => [
                    ['icon' => 'shield', 'title' => 'Controlled Review', 'body' => 'Every request is reviewed through the Bravo Control System before confirmation.'],
                    ['icon' => 'check', 'title' => 'Approved Providers', 'body' => 'We only activate trusted, vetted operators and partners.'],
                    ['icon' => 'headset', 'title' => 'Live Coordination', 'body' => 'Real-time communication and updates throughout your journey.'],
                ]],
                'steps' => ['heading' => 'What happens next', 'items' => [
                    ['title' => 'Submit request', 'body' => 'Provide your requirement and support details.'],
                    ['title' => 'Bravo review', 'body' => 'Your request is reviewed and assessed for suitability.'],
                    ['title' => 'Support selected', 'body' => 'The right support or provider is selected for your need.'],
                    ['title' => 'Support coordinated', 'body' => 'Approved providers are coordinated and briefed.'],
                    ['title' => 'Confirmation & updates', 'body' => 'You receive confirmation and live updates.'],
                ]],
                'related' => ['heading' => 'Related Bravo services', 'cards' => [
                    ['icon' => 'shield', 'title' => 'Secure Services', 'body' => 'Transfers, executive protection, and ongoing support.', 'href' => '/secure-services'],
                    ['icon' => 'target', 'title' => 'Virtual Bodyguard', 'body' => 'Risk awareness and SOS escalation.', 'href' => '/virtual-bodyguard'],
                    ['icon' => 'message', 'title' => 'Bravo Comms', 'body' => 'Protected communication for teams.', 'href' => '/bravo-comms'],
                    ['icon' => 'calendar', 'title' => 'Long-Term Bookings', 'body' => 'Continuous, custom security support.', 'href' => '/long-term-bookings'],
                    ['icon' => 'users', 'title' => 'Agent Network', 'body' => 'Vetted, approved providers.', 'href' => '/agent-network'],
                ]],
                'cta' => ['headline' => 'Need immediate support?', 'body' => 'Our operators are ready to help 24/7.', 'label' => 'Speak to Bravo', 'href' => '/contact'],
            ],

            'secure-services' => [
                'seo' => ['title' => 'Secure Services — Bravo Secure', 'description' => 'Secure movement and executive protection, requested through one controlled platform.'],
                'hero' => ['image' => '', 'eyebrow' => 'Secure Services', 'headline' => 'Secure movement and Executive Protection, requested through one platform.', 'subtext' => 'Bravo Secure handles client requests for secure transfers, executive protection and ongoing support through a structured, reviewed process.', 'primaryLabel' => 'Request Secure Services', 'primaryHref' => '#request', 'secondaryLabel' => 'Speak to Bravo', 'secondaryHref' => '/contact'],
                'panel' => true,
                'process' => ['heading' => 'How it works', 'steps' => [
                    ['title' => 'Request', 'body' => 'Tell us where, when, and what support is needed.'],
                    ['title' => 'Review', 'body' => 'Bravo checks timing, location, risk, and availability.'],
                    ['title' => 'Support', 'body' => 'Your transfer or time slot is confirmed and managed.'],
                ]],
                'services' => ['heading' => 'Service options', 'intro' => 'Etihad-simple to request, controlled in delivery.', 'cards' => [
                    ['icon' => 'car', 'title' => 'Transfers', 'body' => 'On-demand point-to-point secure movement between locations.', 'note' => 'Best for direct A to B movement.'],
                    ['icon' => 'clock', 'title' => 'Time Slots', 'body' => 'On-demand booking for a fixed period when movement is flexible.', 'note' => 'Best when support is needed by the hour.'],
                    ['icon' => 'shield', 'title' => 'Retainers', 'body' => "Longer-term security support arranged around a client's needs.", 'note' => 'Available on request.'],
                    ['icon' => 'briefcase', 'title' => 'Executive Support', 'body' => 'Discreet executive protection and secure travel coordination.', 'note' => 'Matched to risk profile.'],
                    ['icon' => 'layers', 'title' => 'Operational Support', 'body' => 'Risk-aware planning and coordination for organisations.', 'note' => 'Scoped per operation.'],
                ]],
                'cta' => ['headline' => 'Need Secure Services?', 'body' => 'Submit a request and Bravo Secure will review availability before confirmation.', 'label' => 'Request Secure Services', 'href' => '/request-support'],
            ],

            'virtual-bodyguard' => [
                'seo' => ['title' => 'Virtual Bodyguard — Bravo Secure', 'description' => 'Real-time risk awareness, live alerts, mitigation guidance, and escalation support.'],
                'hero' => ['image' => '', 'eyebrow' => 'Virtual Bodyguard', 'headline' => 'Real-time risk awareness and SOS escalation from your phone.', 'subtext' => 'Stay informed through live alerts, risk awareness, mitigation guidance, and escalation support for individuals and organisations.', 'primaryLabel' => 'Request Support', 'primaryHref' => '/request-support', 'secondaryLabel' => 'View Features', 'secondaryHref' => '#features'],
                'features' => ['heading' => 'What it does', 'cards' => [
                    ['icon' => 'bell', 'title' => 'Live Alerts', 'body' => 'Stay informed with relevant updates and incident alerts.'],
                    ['icon' => 'shield', 'title' => 'Risk Awareness', 'body' => 'Understand nearby risks and changing conditions.'],
                    ['icon' => 'list', 'title' => 'Mitigation Guidance', 'body' => 'Receive practical steps to reduce exposure and respond early.'],
                    ['icon' => 'headset', 'title' => 'Escalation Support', 'body' => 'Escalate concerns when support or intervention is needed.'],
                ]],
                'cta' => ['headline' => 'Need risk awareness support?', 'body' => 'Speak to Bravo about Virtual Bodyguard support for you or your organisation.', 'label' => 'Speak to Bravo', 'href' => '/contact'],
            ],

            'bravo-comms' => [
                'seo' => ['title' => 'Bravo Comms — Bravo Secure', 'description' => 'Protected communication and operational control for teams and organisations.'],
                'hero' => ['image' => '', 'eyebrow' => 'Bravo Comms', 'headline' => 'Protected communication for teams and organisations.', 'subtext' => 'Encrypted communication and secure vault storage for files, documents, and sensitive information — built for operational clarity.', 'primaryLabel' => 'Request Access', 'primaryHref' => '/contact', 'secondaryLabel' => 'View Features', 'secondaryHref' => '#features'],
                'features' => ['heading' => 'What Bravo Comms offers', 'cards' => [
                    ['icon' => 'message', 'title' => 'Individual Chats', 'body' => 'Protected one-to-one communication for direct coordination.'],
                    ['icon' => 'users', 'title' => 'Group Chats', 'body' => 'Secure communication for small teams and active operations.'],
                    ['icon' => 'building', 'title' => 'Department Channels', 'body' => 'Structured communication across departments and larger organisations.'],
                    ['icon' => 'lock', 'title' => 'Secure Vault', 'body' => 'Encrypted storage for documents, media, and sensitive files.'],
                ]],
                'cta' => ['headline' => 'Need protected communication and secure storage?', 'body' => 'Speak to Bravo about secure communication and vault storage for you and your organisation.', 'label' => 'Speak to Bravo', 'href' => '/contact'],
            ],

            'long-term-bookings' => [
                'seo' => ['title' => 'Long-Term Bookings — Bravo Secure', 'description' => 'Custom security support for clients, families, executives and organisations that need continuity.'],
                'hero' => ['image' => '', 'eyebrow' => 'Long-Term Bookings', 'headline' => 'Custom security support for clients who need continuity.', 'subtext' => 'For individuals, families and organisations that require recurring assistance, planned movement, regular protection support, or ongoing coordination over a defined period.', 'primaryLabel' => 'Request a Custom Package', 'primaryHref' => '/request-support', 'secondaryLabel' => 'Speak to Bravo', 'secondaryHref' => '/contact'],
                'intro' => ['body' => 'Long-Term Bookings provide custom security support for clients, families, executives and organisations that require recurring movement, planned protection, or ongoing coordination over a defined period. Each package is shaped around your schedule, risk profile and objectives.'],
                'columns' => [
                    ['title' => 'What Long-Term Bookings Are', 'items' => ['Custom packages built around a defined period', 'Continuity across recurring movement and protection', 'Integrated planning, coordination and review', 'A single point of accountability with Bravo']],
                    ['title' => 'Who It Is For', 'items' => ['Executives and business leaders', 'Families requiring ongoing safety support', 'Organisations with recurring requirements', 'Anyone requiring ongoing, reliable security support']],
                    ['title' => 'Types of Support', 'items' => ['Executive protection (ongoing)', 'Secure transport (long-term)', 'Residential and site security support', 'Event and recurring movement support', 'Risk monitoring and coordination']],
                ],
                'process' => ['heading' => 'Custom package process', 'steps' => [
                    ['title' => 'Consultation', 'body' => 'We understand your needs, objectives, schedule and risk profile.'],
                    ['title' => 'Plan & design', 'body' => 'We design a structured plan, resourcing and coverage.'],
                    ['title' => 'Proposal & alignment', 'body' => 'We confirm the proposal, scope and logistics with you.'],
                    ['title' => 'Onboarding', 'body' => 'Approved providers are briefed and prepared.'],
                    ['title' => 'Execution & review', 'body' => 'Support is delivered and reviewed for ongoing effectiveness.'],
                ]],
                'benefits' => ['heading' => 'Benefits of continuity', 'cards' => [
                    ['icon' => 'shield', 'title' => 'Consistent Coordination', 'body' => 'One accountable team across recurring support.'],
                    ['icon' => 'check', 'title' => 'Better Preparedness', 'body' => 'Planning ahead reduces risk and friction.'],
                    ['icon' => 'message', 'title' => 'Seamless Communication', 'body' => 'Aligned communication across every movement.'],
                    ['icon' => 'clock', 'title' => 'Time Efficiency', 'body' => 'Less repeated set-up; faster activation.'],
                    ['icon' => 'target', 'title' => 'Proactive Risk Management', 'body' => 'Continuous monitoring and early response.'],
                    ['icon' => 'lock', 'title' => 'Discreet & Reliable', 'body' => 'Professional, confidential support you can rely on.'],
                ]],
                'cta' => ['headline' => 'Request a custom package', 'body' => "Let's build the right security solution for you. Speak to our team to get started.", 'label' => 'Request a Custom Package', 'href' => '/request-support'],
            ],

            'agent-network' => [
                'seo' => ['title' => 'Agent Network — Bravo Secure', 'description' => 'Controlled onboarding for the Bravo Secure approved provider network.'],
                'hero' => ['image' => '', 'eyebrow' => 'Agent Network', 'headline' => 'Join the approved provider network.', 'subtext' => "Bravo Secure works with selected professionals and partner companies to support client requirements through a controlled platform.", 'primaryLabel' => 'Apply for Review', 'primaryHref' => '/contact', 'secondaryLabel' => 'Our Approach', 'secondaryHref' => '#approach'],
                'approach' => ['heading' => 'Our approach', 'intro' => 'This is not an open marketplace. The network is built through controlled selection, verification, and professional standards.', 'cards' => [
                    ['icon' => 'shield', 'title' => 'Controlled Selection', 'body' => 'By design, not default.'],
                    ['icon' => 'search', 'title' => 'Verification', 'body' => 'Check. Confirm. Validate.'],
                    ['icon' => 'star', 'title' => 'Professional Standards', 'body' => 'Experience. Conduct. Reliability.'],
                    ['icon' => 'users', 'title' => 'Trusted Network', 'body' => 'Quality over quantity.'],
                ]],
                'cta' => ['headline' => 'Built through control, not open access.', 'body' => 'Bravo Secure does not operate as an open marketplace. The network is built through controlled selection, verification, and professional standards.', 'label' => 'Speak to Bravo', 'href' => '/contact'],
            ],

            'about' => [
                'seo' => ['title' => 'About — Bravo Secure', 'description' => 'Controlled security support built on discretion, planning, and operational professionalism.'],
                'hero' => ['image' => '', 'eyebrow' => 'About Bravo Secure', 'headline' => 'Built to bring control to modern security support.', 'subtext' => 'Bravo Secure is an on-demand security ecosystem designed to make security support easier to request, monitor and coordinate.', 'primaryLabel' => 'Speak to Bravo', 'primaryHref' => '/contact', 'secondaryLabel' => 'Explore Services', 'secondaryHref' => '/secure-services'],
                'values' => ['heading' => 'How we operate', 'cards' => [
                    ['icon' => 'shield', 'title' => 'Our Purpose', 'body' => 'To deliver controlled security support that protects people, information, and operations.'],
                    ['icon' => 'target', 'title' => 'Our Approach', 'body' => 'Risk-aware planning, vetted resources, and professional execution.'],
                    ['icon' => 'lock', 'title' => 'Our Commitment', 'body' => 'Discretion, integrity, and accountability in everything we do.'],
                    ['icon' => 'users', 'title' => 'Our Network', 'body' => 'Trusted professionals and partners, selected to our standards.'],
                ]],
                'support' => ['heading' => 'Who we support', 'intro' => 'We support individuals, executives, families, and organisations with secure movement, protected communication, risk awareness, and operational support.', 'cards' => [
                    ['icon' => 'users', 'title' => 'Individuals & Families', 'body' => 'Personal security and controlled movement.'],
                    ['icon' => 'briefcase', 'title' => 'Executives', 'body' => 'Executive protection and secure travel support.'],
                    ['icon' => 'building', 'title' => 'Organisations', 'body' => 'Risk-aware operational and communication support.'],
                    ['icon' => 'globe', 'title' => 'Partners', 'body' => 'Trusted companies extending our service reach.'],
                ]],
                'cta' => ['headline' => 'Need to speak with Bravo?', 'body' => "We're here to understand your needs and provide the right support.", 'label' => 'Speak to Bravo', 'href' => '/contact'],
            ],

            'contact' => [
                'seo' => ['title' => 'Contact — Bravo Secure', 'description' => 'Contact Bravo Secure for controlled security support. We review every request before confirmation.'],
                'hero' => ['image' => '', 'eyebrow' => 'Contact us', 'headline' => 'Get in touch with Bravo.', 'subtext' => "We're here to understand your needs and provide the right controlled support.", 'primaryLabel' => 'Send a Message', 'primaryHref' => '#contact-form', 'secondaryLabel' => '', 'secondaryHref' => ''],
                'methods' => ['heading' => 'Other ways to reach us', 'cards' => [
                    ['icon' => 'mail', 'title' => 'Email', 'body' => 'info@bravo-secure.com', 'note' => 'We aim to respond within 24 hours.'],
                    ['icon' => 'phone', 'title' => 'Secure Line', 'body' => '+1 (555) 817-7332', 'note' => 'Available during operational hours.'],
                    ['icon' => 'clock', 'title' => 'Operational Hours', 'body' => 'Monday – Friday 09:00 – 18:00 (Local Time)', 'note' => 'By appointment only.'],
                    ['icon' => 'target', 'title' => 'Global Support', 'body' => 'Bravo Secure supports clients worldwide with trusted partners.', 'note' => ''],
                ]],
                'checklist' => ['heading' => 'Before you reach out', 'intro' => 'To help us review your request efficiently, please be ready to provide:', 'items' => ['Your location and time zone', 'Preferred dates or time slots', 'Type of support or service needed', 'Any relevant details or documents']],
                'cta' => ['headline' => 'Need immediate assistance?', 'body' => 'For urgent operational matters, call our secure line.', 'label' => 'Speak to Bravo', 'href' => 'tel:+15558177332'],
            ],

            'manage' => [
                'seo' => ['title' => 'Manage a Request — Bravo Secure', 'description' => 'Look up an existing request or check its status using your reference.'],
                'hero' => ['image' => '', 'eyebrow' => 'Manage', 'headline' => 'Manage an existing request.', 'subtext' => 'Look up your request or check its status using your reference.', 'primaryLabel' => '', 'primaryHref' => '', 'secondaryLabel' => '', 'secondaryHref' => ''],
            ],
        ];
    }
}
