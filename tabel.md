

-- 2. EVENTS
CREATE TABLE events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description LONGTEXT NULL,
    thumbnail VARCHAR(255) NULL,
    start_date DATE NULL,
    end_date DATE NULL,
    time TIME NULL;
    location VARCHAR(255) NULL,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    meta_title VARCHAR(255) NULL,
    meta_description TEXT NULL,
    meta_keywords TEXT NULL,
    canonical_url VARCHAR(255) NULL,
    created_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_events_users FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- 3. EVENT CATEGORIES
CREATE TABLE event_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- 4. EVENT ↔ CATEGORY (Pivot)
CREATE TABLE event_event_category (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_event_category_event FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    CONSTRAINT fk_event_category_category FOREIGN KEY (category_id) REFERENCES event_categories(id) ON DELETE CASCADE
);

-- 5. PAGES
CREATE TABLE pages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content LONGTEXT NULL,
    status ENUM('draft', 'published') DEFAULT 'draft',
    meta_title VARCHAR(255) NULL,
    meta_description TEXT NULL,
    meta_keywords TEXT NULL,
    canonical_url VARCHAR(255) NULL,
    created_by BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_pages_users FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- 6. SETTINGS
CREATE TABLE settings (
    `key` VARCHAR(191) PRIMARY KEY,
    `value` TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- 7. MENUS (gabungan menu dan item)
CREATE TABLE menus (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    parent_id BIGINT UNSIGNED NULL,
    title VARCHAR(255) NOT NULL,
    url VARCHAR(255) NULL,
    position VARCHAR(100) NULL,
    `order` INT DEFAULT 0,
    target VARCHAR(50) DEFAULT '_self',
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_menus_parent FOREIGN KEY (parent_id) REFERENCES menus(id) ON DELETE SET NULL
);

-- 8. HIGHLIGHT EVENTS
CREATE TABLE highlight_events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    content TEXT NULL,
    icon VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- 9. EVENT ↔ HIGHLIGHT (Pivot)
CREATE TABLE event_highlight_event (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    highlight_event_id BIGINT UNSIGNED NOT NULL,
    event_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_highlight_event FOREIGN KEY (highlight_event_id) REFERENCES highlight_events(id) ON DELETE CASCADE,
    CONSTRAINT fk_event_highlight FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

-- 10. GALLERIES (many-to-one with events)
CREATE TABLE galleries (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id BIGINT UNSIGNED NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    caption VARCHAR(255) NULL,
    is_featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_gallery_event FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

-- 11. PARTNERS
CREATE TABLE partners (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    logo VARCHAR(255) NULL,
    website VARCHAR(255) NULL,
    description TEXT NULL,
    order_number INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
