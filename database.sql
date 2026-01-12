-- sportnews_ci4 FULL database schema

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    full_name VARCHAR(100),
    role ENUM('admin','editor','writer') DEFAULT 'writer',
    status TINYINT(1) DEFAULT 1,
    last_login DATETIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(120) UNIQUE NOT NULL,
    parent_id INT DEFAULT 0,
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_parent (parent_id)
) ENGINE=InnoDB;

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    summary TEXT,
    content LONGTEXT,
    thumbnail VARCHAR(255),
    status ENUM('draft','published','archived') DEFAULT 'draft',
    is_featured TINYINT(1) DEFAULT 0,
    is_hot TINYINT(1) DEFAULT 0,
    view_count INT DEFAULT 0,
    published_at DATETIME NULL,
    created_by INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (created_by) REFERENCES users(id),
    INDEX idx_post_slug (slug),
    INDEX idx_cat_status (category_id, status),
    INDEX idx_published (published_at)
) ENGINE=InnoDB;

CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(120) UNIQUE NOT NULL,
    INDEX idx_tag_slug (slug)
) ENGINE=InnoDB;

CREATE TABLE post_tags (
    post_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (post_id, tag_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE leagues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(120) UNIQUE NOT NULL,
    season VARCHAR(20),
    type ENUM('league','cup','friendly') DEFAULT 'league'
) ENGINE=InnoDB;

CREATE TABLE teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(120) UNIQUE NOT NULL,
    logo VARCHAR(255),
    country VARCHAR(50)
) ENGINE=InnoDB;

CREATE TABLE matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    league_id INT NOT NULL,
    home_team_id INT NOT NULL,
    away_team_id INT NOT NULL,
    kickoff DATETIME NOT NULL,
    stadium VARCHAR(100),
    status ENUM('scheduled','live','finished') DEFAULT 'scheduled',
    home_score TINYINT DEFAULT 0,
    away_score TINYINT DEFAULT 0,
    FOREIGN KEY (league_id) REFERENCES leagues(id),
    FOREIGN KEY (home_team_id) REFERENCES teams(id),
    FOREIGN KEY (away_team_id) REFERENCES teams(id),
    INDEX idx_league_kickoff (league_id, kickoff),
    INDEX idx_status (status)
) ENGINE=InnoDB;

CREATE TABLE standings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    league_id INT NOT NULL,
    team_id INT NOT NULL,
    played INT DEFAULT 0,
    win INT DEFAULT 0,
    draw INT DEFAULT 0,
    lose INT DEFAULT 0,
    goals_for INT DEFAULT 0,
    goals_against INT DEFAULT 0,
    points INT DEFAULT 0,
    FOREIGN KEY (league_id) REFERENCES leagues(id),
    FOREIGN KEY (team_id) REFERENCES teams(id),
    UNIQUE KEY uniq_league_team (league_id, team_id)
) ENGINE=InnoDB;

CREATE TABLE ads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    position VARCHAR(50) NOT NULL,
    image VARCHAR(255) NOT NULL,
    link VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(100) UNIQUE NOT NULL,
    `value` TEXT,
    `type` VARCHAR(50) DEFAULT 'string'
) ENGINE=InnoDB;

INSERT INTO users (username,password_hash,email,full_name,role)
VALUES (
    'admin',
    '$2y$10$abcdefghijklmnopqrstuv1234567890abcdEfghijkLmnoPq', -- nhớ đổi
    'admin@example.com',
    'Administrator',
    'admin'
);


-- Advanced features: comments, medals, videos, logs

CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_name VARCHAR(100),
    user_email VARCHAR(100),
    content TEXT NOT NULL,
    status ENUM('pending','approved','spam') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    INDEX idx_post_status (post_id, status)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS countries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(10) UNIQUE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS medals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_id INT NOT NULL,
    gold INT DEFAULT 0,
    silver INT DEFAULT 0,
    bronze INT DEFAULT 0,
    total INT DEFAULT 0,
    event_name VARCHAR(100) DEFAULT 'SEA Games',
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (country_id) REFERENCES countries(id),
    INDEX idx_country (country_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS videos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    summary TEXT,
    embed_url VARCHAR(255) NOT NULL,
    thumbnail VARCHAR(255),
    status ENUM('draft','published') DEFAULT 'draft',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS admin_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    module VARCHAR(100),
    action VARCHAR(100),
    data TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    CONSTRAINT fk_log_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;



-- Extra for advanced standings / scorers

ALTER TABLE matches
    ADD COLUMN IF NOT EXISTS matchweek INT DEFAULT 1 AFTER kickoff;

CREATE TABLE IF NOT EXISTS players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    shirt_number INT DEFAULT NULL,
    position VARCHAR(50),
    photo VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (team_id) REFERENCES teams(id),
    INDEX idx_team (team_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS goals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    match_id INT NOT NULL,
    player_id INT NOT NULL,
    minute TINYINT DEFAULT NULL,
    is_own_goal TINYINT(1) DEFAULT 0,
    is_penalty TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (match_id) REFERENCES matches(id) ON DELETE CASCADE,
    FOREIGN KEY (player_id) REFERENCES players(id) ON DELETE CASCADE,
    INDEX idx_match (match_id),
    INDEX idx_player (player_id)
) ENGINE=InnoDB;



-- ==========================
-- SAMPLE DATA FOR DEMO SITE
-- ==========================

-- Categories
INSERT INTO categories (id, name, slug, parent_id, sort_order, is_active)
VALUES
(1, 'Bóng đá', 'bong-da', 0, 1, 1),
(2, 'Ngoại hạng Anh', 'ngoai-hang-anh', 1, 2, 1),
(3, 'Laliga', 'laliga', 1, 3, 1),
(4, 'SEA Games', 'sea-games', 0, 4, 1)
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Tags
INSERT INTO tags (id, name, slug) VALUES
(1, 'Manchester United', 'manchester-united'),
(2, 'Liverpool', 'liverpool'),
(3, 'Việt Nam', 'viet-nam'),
(4, 'SEA Games 2025', 'sea-games-2025')
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Sample users (admin đã có ở trên, thêm 1 editor, 1 writer)
INSERT INTO users (id, username, password_hash, email, full_name, role)
VALUES
(2, 'editor', '$2y$10$abcdefghijklmnopqrstuv1234567890abcdEfghijkLmnoPq', 'editor@example.com', 'Editor Demo', 'editor'),
(3, 'writer', '$2y$10$abcdefghijklmnopqrstuv1234567890abcdEfghijkLmnoPq', 'writer@example.com', 'Writer Demo', 'writer')
ON DUPLICATE KEY UPDATE email=VALUES(email);

-- Sample posts
INSERT INTO posts (id, category_id, title, slug, summary, content, thumbnail, status, is_featured, is_hot, view_count, published_at, created_by)
VALUES
(1, 2,
 'MU thắng kịch tính trước Liverpool',
 'mu-thang-kich-tinh-truoc-liverpool',
 'Manchester United giành chiến thắng nghẹt thở trước Liverpool trong trận cầu tâm điểm.',
 '<p>Manchester United đã có một trận đấu đầy cảm xúc trên sân nhà. Ngay từ những phút đầu...</p>',
 '/uploads/thumbnails/sample_mu_liv.jpg',
 'published', 1, 1, 1500, NOW() - INTERVAL 1 DAY, 2),
(2, 4,
 'U23 Việt Nam giành HCV SEA Games',
 'u23-viet-nam-gianh-hcv-sea-games',
 'U23 Việt Nam đánh bại đối thủ trong trận chung kết để giành HCV SEA Games.',
 '<p>U23 Việt Nam đã thể hiện bản lĩnh tuyệt vời trong trận chung kết...</p>',
 '/uploads/thumbnails/sample_u23_vn.jpg',
 'published', 1, 1, 2300, NOW() - INTERVAL 2 DAY, 3)
ON DUPLICATE KEY UPDATE summary=VALUES(summary);

-- Post tags
INSERT INTO post_tags (post_id, tag_id) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4)
ON DUPLICATE KEY UPDATE tag_id=VALUES(tag_id);

-- Leagues
INSERT INTO leagues (id, name, slug, season, type) VALUES
(1, 'Premier League', 'premier-league', '2025/26', 'league'),
(2, 'Laliga', 'laliga', '2025/26', 'league'),
(3, 'V-League 1', 'v-league-1', '2025', 'league')
ON DUPLICATE KEY UPDATE season=VALUES(season);

-- Teams
INSERT INTO teams (id, name, slug, logo, country) VALUES
(1, 'Manchester United', 'man-utd', '/uploads/logos/manutd.png', 'England'),
(2, 'Liverpool', 'liverpool', '/uploads/logos/liverpool.png', 'England'),
(3, 'Arsenal', 'arsenal', '/uploads/logos/arsenal.png', 'England'),
(4, 'Real Madrid', 'real-madrid', '/uploads/logos/realmadrid.png', 'Spain'),
(5, 'Barcelona', 'barcelona', '/uploads/logos/barcelona.png', 'Spain'),
(6, 'Hà Nội FC', 'ha-noi-fc', '/uploads/logos/hanoi.png', 'Vietnam'),
(7, 'Hoàng Anh Gia Lai', 'hoang-anh-gia-lai', '/uploads/logos/hagl.png', 'Vietnam')
ON DUPLICATE KEY UPDATE logo=VALUES(logo);

-- Matches with matchweek
INSERT INTO matches (id, league_id, home_team_id, away_team_id, kickoff, matchweek, stadium, status, home_score, away_score)
VALUES
(1, 1, 1, 2, NOW() - INTERVAL 7 DAY, 1, 'Old Trafford', 'finished', 2, 1),
(2, 1, 3, 1, NOW() - INTERVAL 3 DAY, 2, 'Emirates', 'finished', 1, 1),
(3, 2, 4, 5, NOW() - INTERVAL 5 DAY, 1, 'Santiago Bernabéu', 'finished', 3, 2),
(4, 3, 6, 7, NOW() - INTERVAL 1 DAY, 1, 'Hàng Đẫy', 'finished', 2, 0)
ON DUPLICATE KEY UPDATE stadium=VALUES(stadium);

-- Standings demo (có thể bị ghi đè bởi StandingsService khi bạn recalc, nên chỉ là seed ban đầu)
INSERT INTO standings (id, league_id, team_id, played, win, draw, lose, goals_for, goals_against, points)
VALUES
(1, 1, 1, 2, 1, 1, 0, 3, 2, 4),
(2, 1, 2, 1, 0, 0, 1, 1, 2, 0),
(3, 1, 3, 1, 0, 1, 0, 1, 1, 1),
(4, 2, 4, 1, 1, 0, 0, 3, 2, 3),
(5, 2, 5, 1, 0, 0, 1, 2, 3, 0),
(6, 3, 6, 1, 1, 0, 0, 2, 0, 3),
(7, 3, 7, 1, 0, 0, 1, 0, 2, 0)
ON DUPLICATE KEY UPDATE played=VALUES(played);

-- Players
INSERT INTO players (id, team_id, name, shirt_number, position, photo) VALUES
(1, 1, 'Bruno Fernandes', 8, 'Midfielder', '/uploads/players/bruno.png'),
(2, 1, 'Marcus Rashford', 10, 'Forward', '/uploads/players/rashford.png'),
(3, 2, 'Mohamed Salah', 11, 'Forward', '/uploads/players/salah.png'),
(4, 4, 'Vinícius Júnior', 7, 'Forward', '/uploads/players/vini.png'),
(5, 5, 'Robert Lewandowski', 9, 'Forward', '/uploads/players/lewa.png'),
(6, 6, 'Nguyễn Văn Quyết', 10, 'Forward', '/uploads/players/vanquyet.png')
ON DUPLICATE KEY UPDATE position=VALUES(position);

-- Goals (vua phá lưới demo)
INSERT INTO goals (id, match_id, player_id, minute, is_own_goal, is_penalty) VALUES
(1, 1, 2, 35, 0, 0),
(2, 1, 3, 60, 0, 1),
(3, 1, 1, 80, 0, 0),
(4, 2, 2, 55, 0, 0),
(5, 3, 4, 22, 0, 0),
(6, 3, 5, 40, 0, 1),
(7, 3, 4, 75, 0, 0),
(8, 4, 6, 20, 0, 0),
(9, 4, 6, 70, 0, 0)
ON DUPLICATE KEY UPDATE minute=VALUES(minute);

-- Countries & medals
INSERT INTO countries (id, name, code) VALUES
(1, 'Việt Nam', 'VIE'),
(2, 'Thái Lan', 'THA'),
(3, 'Indonesia', 'INA')
ON DUPLICATE KEY UPDATE code=VALUES(code);

INSERT INTO medals (id, country_id, gold, silver, bronze, total, event_name)
VALUES
(1, 1, 40, 30, 20, 90, 'SEA Games 2025'),
(2, 2, 30, 25, 25, 80, 'SEA Games 2025'),
(3, 3, 20, 25, 30, 75, 'SEA Games 2025')
ON DUPLICATE KEY UPDATE gold=VALUES(gold);

-- Videos
INSERT INTO videos (id, title, slug, summary, embed_url, thumbnail, status)
VALUES
(1,
 'Highlight MU 2-1 Liverpool',
 'highlight-mu-2-1-liverpool',
 'Video highlight trận đấu giữa Manchester United và Liverpool.',
 'https://www.youtube.com/embed/dQw4w9WgXcQ',
 '/uploads/thumbnails/video_mu_liv.jpg',
 'published'),
(2,
 'U23 Việt Nam nâng cúp SEA Games',
 'u23-viet-nam-nang-cup-sea-games',
 'Khoảnh khắc U23 Việt Nam nâng cao chiếc cúp vàng SEA Games.',
 'https://www.youtube.com/embed/oHg5SJYRHA0',
 '/uploads/thumbnails/video_u23_vn.jpg',
 'published')
ON DUPLICATE KEY UPDATE summary=VALUES(summary);

-- Ads sample
INSERT INTO ads (id, position, image, link, is_active, sort_order)
VALUES
(1, 'top_banner', '/uploads/ads/top_banner.jpg', 'https://example.com', 1, 1),
(2, 'right_sidebar', '/uploads/ads/right1.jpg', 'https://example.com', 1, 1),
(3, 'right_sidebar', '/uploads/ads/right2.jpg', 'https://example.com', 1, 2)
ON DUPLICATE KEY UPDATE image=VALUES(image);

-- Settings sample
INSERT INTO settings (`key`, `value`, `type`) VALUES
('site_name', 'SportNews CI4 Demo', 'string'),
('site_description', 'Trang tin thể thao demo CodeIgniter 4 với BXH nâng cao.', 'string'),
('homepage_title', 'Trang chủ - SportNews CI4 Demo', 'string')
ON DUPLICATE KEY UPDATE value=VALUES(value);

-- Sample comments (pending + approved)
INSERT INTO comments (id, post_id, user_name, user_email, content, status)
VALUES
(1, 1, 'Người hâm mộ 1', 'fan1@example.com', 'Trận này đá hay quá!', 'approved'),
(2, 1, 'Người hâm mộ 2', 'fan2@example.com', 'Liverpool phòng ngự hơi tệ.', 'pending'),
(3, 2, 'CĐV Việt Nam', 'cdv@example.com', 'Quá tự hào về U23 Việt Nam!', 'approved')
ON DUPLICATE KEY UPDATE content=VALUES(content);

ALTER TABLE ads
    ADD COLUMN title VARCHAR(150) NOT NULL DEFAULT '' AFTER id,
    ADD COLUMN html  TEXT NULL AFTER link,
    ADD COLUMN started_at DATETIME NULL AFTER sort_order,
    ADD COLUMN ended_at   DATETIME NULL AFTER started_at;
CREATE TABLE IF NOT EXISTS ad_stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ad_id INT NOT NULL,
    views INT DEFAULT 0,
    clicks INT DEFAULT 0,
    stat_date DATE NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_ad_date (ad_id, stat_date),
    CONSTRAINT fk_ad_stats_ad FOREIGN KEY (ad_id)
        REFERENCES ads(id) ON DELETE CASCADE
) ENGINE=InnoDB;
UPDATE ads SET
    title = 'Top banner trang chủ 980x90'
WHERE id = 1;

UPDATE ads SET
    title = 'Sidebar phải 300x600 - slot 1'
WHERE id = 2;

UPDATE ads SET
    title = 'Sidebar phải 300x250 - slot 2'
WHERE id = 3;
ALTER TABLE posts
  ADD COLUMN source_url VARCHAR(500) NULL AFTER thumbnail,
  ADD COLUMN source_name VARCHAR(50) NULL AFTER source_url,
  ADD UNIQUE KEY uniq_source_url (source_url);
