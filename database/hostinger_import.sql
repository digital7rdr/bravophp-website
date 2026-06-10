-- Bravo Secure Hostinger import
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS pages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    parent_id INT UNSIGNED NULL,
    slug VARCHAR(120) NOT NULL UNIQUE,
    menu_label VARCHAR(120) NOT NULL,
    title VARCHAR(190) NOT NULL,
    meta_description VARCHAR(255) NULL,
    eyebrow VARCHAR(140) NULL,
    headline VARCHAR(190) NOT NULL,
    body TEXT NULL,
    hero_image VARCHAR(190) NULL,
    hero_media_type VARCHAR(20) NOT NULL DEFAULT 'image',
    primary_label VARCHAR(120) NULL,
    primary_url VARCHAR(190) NULL,
    secondary_label VARCHAR(120) NULL,
    secondary_url VARCHAR(190) NULL,
    cta_headline VARCHAR(190) NULL,
    cta_body TEXT NULL,
    cta_label VARCHAR(120) NULL,
    cta_url VARCHAR(190) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT pages_parent_id_foreign FOREIGN KEY (parent_id) REFERENCES pages(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS feature_groups (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    page_id INT UNSIGNED NOT NULL,
    group_key VARCHAR(120) NOT NULL,
    title VARCHAR(190) NULL,
    intro TEXT NULL,
    layout VARCHAR(60) NOT NULL DEFAULT 'cards',
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT feature_groups_page_id_foreign FOREIGN KEY (page_id) REFERENCES pages(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS feature_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    group_id INT UNSIGNED NOT NULL,
    icon VARCHAR(60) NOT NULL DEFAULT 'shield',
    title VARCHAR(190) NOT NULL,
    body TEXT NULL,
    note TEXT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT feature_items_group_id_foreign FOREIGN KEY (group_id) REFERENCES feature_groups(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contact_messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL,
    subject VARCHAR(190) NOT NULL,
    message TEXT NOT NULL,
    status VARCHAR(40) NOT NULL DEFAULT 'new',
    ip_address VARCHAR(64) NULL,
    user_agent VARCHAR(255) NULL,
    created_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(120) NOT NULL UNIQUE,
    setting_value TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO pages
(id, parent_id, slug, menu_label, title, meta_description, eyebrow, headline, body, hero_image, hero_media_type, primary_label, primary_url, secondary_label, secondary_url, cta_headline, cta_body, cta_label, cta_url, sort_order, is_published, created_at, updated_at)
VALUES
(1, NULL, 'home', 'Home', 'Controlled Security Support', 'Controlled movement, protected communication, real-time risk awareness, and vetted operational support.', '', 'Controlled Security Support.', 'Bravo Secure provides secure movement, protected communication, real-time risk awareness, and vetted operational support for individuals and organisations.', 'hero-home.jpg', 'image', 'Request Support', '/contact', 'View Services', '/services', 'Need controlled support?', '', 'Contact Bravo Secure', '/contact', 10, 1, NOW(), NOW()),
(2, NULL, 'services', 'Services', 'On-Demand Transfers and Time Slots', 'Secure transfers and scheduled time-slot services for individuals and organisations.', 'Bravo Secure Services', 'On-Demand Transfers and Time Slots.', 'Bravo Secure provides controlled movement support through secure transfers and scheduled time-slot services for individuals and organisations.', 'hero-services.jpg', 'image', 'Request Support', '/contact', 'Contact Bravo', '/contact', 'Need movement support?', '', 'Contact Bravo', '/contact', 20, 1, NOW(), NOW()),
(3, NULL, 'bravo-comms', 'Bravo Comms', 'Bravo Comms', 'Protected communication and secure vault storage for sensitive information.', 'Bravo Comms', 'Bravo Comms.', 'Protected communication for individuals, teams, and organisations. Secure vault storage for files, documents, and sensitive information.', 'hero-comms.jpg', 'image', 'Learn More', '#features', 'View Features', '#features', 'Need protected communication and secure storage?', 'Speak to Bravo about secure communication and vault storage for you and your organisation.', 'Contact Bravo', '/contact', 30, 1, NOW(), NOW()),
(4, NULL, 'virtual-bodyguard', 'Virtual Bodyguard', 'Real-Time Risk Awareness', 'Live alerts, risk awareness, mitigation guidance, and escalation support.', 'Virtual Bodyguard', 'Real-Time Risk Awareness.', 'Virtual Bodyguard helps individuals and organisations stay informed through live alerts, risk awareness, mitigation guidance, and escalation support.', 'hero-virtual-bodyguard.jpg', 'image', 'Contact Bravo', '/contact', 'Learn More', '#features', 'Need risk awareness support?', 'Speak to Bravo about Virtual Bodyguard support for you or your organisation.', 'Contact Bravo', '/contact', 40, 1, NOW(), NOW()),
(5, NULL, 'agent-network', 'Agent Network', 'Agent Onboarding', 'Controlled onboarding for a trusted operational network.', 'Agent Onboarding', 'Agent Onboarding.', 'Bravo Secure uses a controlled onboarding process to build a trusted operational network. Every applicant is reviewed before being accepted into the system.', 'hero-agent-network.jpg', 'image', 'Contact Bravo', '/contact', 'Learn More', '#features', 'Built through control, not open access.', 'Bravo Secure does not operate as an open marketplace. The network is built through controlled selection, verification, and professional standards.', 'Contact Bravo', '/contact', 50, 1, NOW(), NOW()),
(6, NULL, 'about', 'About', 'About Bravo Secure', 'Controlled security support built on discretion, planning, and operational professionalism.', '', 'About Bravo Secure.', 'We provide controlled security support for individuals and organisations.\n\nOur approach is built on discretion, planning, and operational professionalism.', 'hero-about.jpg', 'image', '', '', '', '', 'Need to speak with Bravo?', 'We''re here to understand your needs and provide the right support.', 'Speak to Bravo', '/contact', 60, 1, NOW(), NOW()),
(7, NULL, 'contact', 'Contact', 'Get in touch with Bravo', 'Contact Bravo Secure for controlled security support.', 'Contact Us', 'Get in touch with Bravo.', 'We''re here to understand your needs and provide the right controlled support.', 'hero-contact.jpg', 'image', 'Send Message', '#contact-form', '', '', 'Need immediate assistance?', 'For urgent operational matters, call our secure line.', 'Speak to Bravo', '/contact', 70, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE
menu_label = VALUES(menu_label),
parent_id = VALUES(parent_id),
title = VALUES(title),
meta_description = VALUES(meta_description),
eyebrow = VALUES(eyebrow),
headline = VALUES(headline),
body = VALUES(body),
hero_image = VALUES(hero_image),
hero_media_type = VALUES(hero_media_type),
primary_label = VALUES(primary_label),
primary_url = VALUES(primary_url),
secondary_label = VALUES(secondary_label),
secondary_url = VALUES(secondary_url),
cta_headline = VALUES(cta_headline),
cta_body = VALUES(cta_body),
cta_label = VALUES(cta_label),
cta_url = VALUES(cta_url),
sort_order = VALUES(sort_order),
is_published = VALUES(is_published),
updated_at = NOW();

INSERT INTO feature_groups (id, page_id, group_key, title, intro, layout, sort_order, created_at, updated_at) VALUES
(1, 1, 'what-we-do', 'What We Do', '', 'icon-grid', 10, NOW(), NOW()),
(2, 2, 'how-it-works', 'How It Works', '', 'steps', 10, NOW(), NOW()),
(3, 2, 'service-options', 'Service Options', '', 'cards', 20, NOW(), NOW()),
(4, 3, 'offers', 'What Bravo Comms Offers', '', 'cards', 10, NOW(), NOW()),
(5, 3, 'why', 'Why Bravo Comms', '', 'inline', 20, NOW(), NOW()),
(6, 4, 'what-it-does', 'What It Does', '', 'cards', 10, NOW(), NOW()),
(7, 4, 'why', 'Why Virtual Bodyguard', '', 'inline', 20, NOW(), NOW()),
(8, 5, 'paths', 'Onboarding Paths', '', 'wide-cards', 10, NOW(), NOW()),
(9, 5, 'approach', 'Our Approach', '', 'inline', 20, NOW(), NOW()),
(10, 6, 'principles', '', '', 'icon-grid', 10, NOW(), NOW()),
(11, 6, 'support', 'Who We Support', 'We support individuals, executives, families, and organisations with secure movement, protected communication, risk awareness, and operational support.', 'split-list', 20, NOW(), NOW()),
(12, 7, 'reach', 'Other ways to reach us', '', 'cards', 10, NOW(), NOW()),
(13, 7, 'before', 'Before you reach out', 'To help us review your request efficiently, please be ready to provide:', 'checklist', 20, NOW(), NOW())
ON DUPLICATE KEY UPDATE title = VALUES(title), intro = VALUES(intro), layout = VALUES(layout), sort_order = VALUES(sort_order), updated_at = NOW();

INSERT INTO feature_items (id, group_id, icon, title, body, note, sort_order, created_at, updated_at) VALUES
(1, 1, 'shield', 'Secure Services', 'Transfers, time slots, and operational support.', '', 10, NOW(), NOW()),
(2, 1, 'message', 'Bravo Comms', 'Protected communication for teams and organisations.', '', 20, NOW(), NOW()),
(3, 1, 'target', 'Virtual Bodyguard', 'Risk awareness, alerts, and escalation support.', '', 30, NOW(), NOW()),
(4, 1, 'users', 'Agent Network', 'Vetted professionals and company partners.', '', 40, NOW(), NOW()),
(5, 2, 'check', '1. Request', 'Tell us where, when, and what support is needed.', '', 10, NOW(), NOW()),
(6, 2, 'check', '2. Review', 'Bravo checks timing, location, risk, and availability.', '', 20, NOW(), NOW()),
(7, 2, 'check', '3. Support', 'Your transfer or time slot is confirmed and managed.', '', 30, NOW(), NOW()),
(8, 3, 'car', 'Transfers', 'On-demand point-to-point secure movement between locations. Ideal for airport transfers, meetings, and direct routes.', 'Best for direct A to B movement.', 10, NOW(), NOW()),
(9, 3, 'clock', 'Time Slots', 'On-demand booking for a fixed period when movement is flexible or includes multiple stops. Ideal for meetings, events, site visits, and standby support.', 'Best when support is needed by the hour.', 20, NOW(), NOW()),
(10, 3, 'shield', 'Retainers', 'Longer-term security support arranged around a client''s specific needs. Suitable for clients who require regular or ongoing movement support.', 'Available on request and tailored to the client.', 30, NOW(), NOW()),
(11, 4, 'message', 'Individual Chats', 'Protected one-to-one communication for direct coordination.', '', 10, NOW(), NOW()),
(12, 4, 'users', 'Group Chats', 'Secure communication for small teams and active operations.', '', 20, NOW(), NOW()),
(13, 4, 'building', 'Department Channels', 'Structured communication across departments and larger organisations.', '', 30, NOW(), NOW()),
(14, 4, 'lock', 'Secure Vault', 'Encrypted storage for documents, media, and sensitive files, available to both users and enterprises.', '', 40, NOW(), NOW()),
(15, 5, 'shield', 'Secure', 'End-to-end encryption and secure storage for protected communication and data.', '', 10, NOW(), NOW()),
(16, 5, 'layers', 'Structured', 'Organised communication and information, built for operational clarity.', '', 20, NOW(), NOW()),
(17, 5, 'check', 'Reliable', 'Built for real-world use with high availability and secure performance.', '', 30, NOW(), NOW()),
(18, 5, 'chart', 'Scalable', 'For individuals, teams, and organisations of any size.', '', 40, NOW(), NOW()),
(19, 6, 'bell', 'Live Alerts', 'Stay informed with relevant updates and incident alerts.', '', 10, NOW(), NOW()),
(20, 6, 'shield', 'Risk Awareness', 'Understand nearby risks and changing conditions.', '', 20, NOW(), NOW()),
(21, 6, 'list', 'Mitigation Guidance', 'Receive practical steps to reduce exposure and respond early.', '', 30, NOW(), NOW()),
(22, 6, 'headset', 'Escalation Support', 'Escalate concerns when support or intervention is needed.', '', 40, NOW(), NOW()),
(23, 7, 'clock', 'Proactive', 'Helps you stay ahead of developing issues.', '', 10, NOW(), NOW()),
(24, 7, 'list', 'Clear', 'Simple information with practical next steps.', '', 20, NOW(), NOW()),
(25, 7, 'shield', 'Reliable', 'Built for real-world movement and operations.', '', 30, NOW(), NOW()),
(26, 7, 'users', 'Supportive', 'Designed for individuals, teams, and organisations.', '', 40, NOW(), NOW()),
(27, 8, 'users', 'Individual Onboarding', 'Individual onboarding is for qualified and certified personnel seeking employment opportunities within the Bravo Secure network. Applicants must provide relevant experience, certifications, identification, and supporting documents for review.', '', 10, NOW(), NOW()),
(28, 8, 'building', 'Corporate Onboarding', 'Corporate onboarding is for vetted security companies that can extend Bravo Secure''s service reach. Companies must show their licensing, operational capability, service standards, and ability to support clients professionally.', '', 20, NOW(), NOW()),
(29, 9, 'shield', 'Controlled Selection', 'By design, not default.', '', 10, NOW(), NOW()),
(30, 9, 'search', 'Verification', 'Check. Confirm. Validate.', '', 20, NOW(), NOW()),
(31, 9, 'star', 'Professional Standards', 'Experience. Conduct. Reliability.', '', 30, NOW(), NOW()),
(32, 9, 'users', 'Trusted Network', 'Quality over quantity.', '', 40, NOW(), NOW()),
(33, 10, 'shield', 'Our Purpose', 'To deliver controlled security support that protects people, information, and operations.', '', 10, NOW(), NOW()),
(34, 10, 'target', 'Our Approach', 'Risk-aware planning, vetted resources, and professional execution.', '', 20, NOW(), NOW()),
(35, 10, 'lock', 'Our Commitment', 'Discretion, integrity, and accountability in everything we do.', '', 30, NOW(), NOW()),
(36, 10, 'users', 'Our Network', 'Trusted professionals and partners, selected to our standards.', '', 40, NOW(), NOW()),
(37, 11, 'users', 'Individuals & Families', 'Personal security and controlled movement.', '', 10, NOW(), NOW()),
(38, 11, 'briefcase', 'Executives', 'Executive protection and secure travel support.', '', 20, NOW(), NOW()),
(39, 11, 'building', 'Organisations', 'Risk-aware operational and communication support.', '', 30, NOW(), NOW()),
(40, 11, 'globe', 'Partners', 'Trusted companies extending our service reach.', '', 40, NOW(), NOW()),
(41, 12, 'mail', 'Email', 'info@bravo-secure.com', 'We aim to respond within 24 hours.', 10, NOW(), NOW()),
(42, 12, 'phone', 'Secure Line', '+1 (555) 817-7332', 'Available during operational hours.', 20, NOW(), NOW()),
(43, 12, 'clock', 'Operational Hours', 'Monday - Friday 09:00 - 18:00 (Local Time)', 'By appointment only.', 30, NOW(), NOW()),
(44, 12, 'target', 'Global Support', 'Bravo Secure supports clients worldwide with trusted partners.', '', 40, NOW(), NOW()),
(45, 13, 'check', 'Your location and time zone', '', '', 10, NOW(), NOW()),
(46, 13, 'check', 'Preferred dates or time slots', '', '', 20, NOW(), NOW()),
(47, 13, 'check', 'Type of support or service needed', '', '', 30, NOW(), NOW()),
(48, 13, 'check', 'Any relevant details or documents', '', '', 40, NOW(), NOW())
ON DUPLICATE KEY UPDATE icon = VALUES(icon), title = VALUES(title), body = VALUES(body), note = VALUES(note), sort_order = VALUES(sort_order), updated_at = NOW();

SET @column_exists := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'pages'
      AND COLUMN_NAME = 'hero_media_type'
);

SET @statement := IF(
    @column_exists = 0,
    'ALTER TABLE pages ADD COLUMN hero_media_type VARCHAR(20) NOT NULL DEFAULT ''image'' AFTER hero_image',
    'SELECT 1'
);

PREPARE add_hero_media_type FROM @statement;
EXECUTE add_hero_media_type;
DEALLOCATE PREPARE add_hero_media_type;

INSERT INTO settings (setting_key, setting_value, created_at, updated_at) VALUES
('logo_path', 'images/logo.svg', NOW(), NOW()),
('logo_text', 'Bravo Secure', NOW(), NOW())
ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_at = NOW();

SET @column_exists := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'pages'
      AND COLUMN_NAME = 'parent_id'
);

SET @statement := IF(
    @column_exists = 0,
    'ALTER TABLE pages ADD COLUMN parent_id INT UNSIGNED NULL AFTER id',
    'SELECT 1'
);

PREPARE add_parent_id FROM @statement;
EXECUTE add_parent_id;
DEALLOCATE PREPARE add_parent_id;

SET @fk_exists := (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = 'pages'
      AND CONSTRAINT_NAME = 'pages_parent_id_foreign'
);

SET @statement := IF(
    @fk_exists = 0,
    'ALTER TABLE pages ADD CONSTRAINT pages_parent_id_foreign FOREIGN KEY (parent_id) REFERENCES pages(id) ON DELETE SET NULL',
    'SELECT 1'
);

PREPARE add_parent_fk FROM @statement;
EXECUTE add_parent_fk;
DEALLOCATE PREPARE add_parent_fk;

SET FOREIGN_KEY_CHECKS=1;
