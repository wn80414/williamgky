    <?php
    require_once __DIR__ . '/inc/db.php';
    $pdo = get_db();

    try {
        // -------------------------
        // CREATE TABLES
        // -------------------------

        // Users table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(32) NOT NULL DEFAULT 'user',
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // Products table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS products (
                id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                `desc` TEXT NOT NULL,
                img VARCHAR(1000) NOT NULL,
                price DECIMAL(10,2) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // Product visits table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS product_visits (
                product_id INT UNSIGNED NOT NULL PRIMARY KEY,
                visits INT UNSIGNED NOT NULL DEFAULT 0,
                FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // General visits table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS visits (
                product_id INT UNSIGNED NOT NULL PRIMARY KEY,
                visit_count INT UNSIGNED NOT NULL DEFAULT 0,
                FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // Reviews table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS reviews (
                id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                product_id INT UNSIGNED NOT NULL,
                username VARCHAR(100) NOT NULL,
                rating TINYINT UNSIGNED NOT NULL CHECK (rating BETWEEN 1 AND 5),
                comment TEXT,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY unique_user_product (product_id, username),
                KEY idx_product_id (product_id),
                FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
                FOREIGN KEY (username) REFERENCES users(username) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // -------------------------
        // INSERT DATA
        // -------------------------

        // Users
        $users = [
            ['admin','123','admin'],
            ['user1','123','user'],
            ['user2','123','user'],
            ['williamnguyen','123','user'],
            ['bobnguyen','123','user'],
            ['kevinnguyen','123','user'],
            ['jim','123','user'],
            ['jim2','123','user'],
            ['timkim','123','user']
        ];

        $stmt = $pdo->prepare("INSERT IGNORE INTO users (username,password,role) VALUES (?, ?, ?)");
        foreach ($users as $u) {
            $hashed = password_hash($u[1], PASSWORD_DEFAULT);
            $stmt->execute([$u[0], $hashed, $u[2]]);
        }

        // Products
        $products = [
            [0,'SJSU Gameday Jersey','Lightweight basketball jersey.','https://images.footballfanatics.com/san-jose-state-spartans/mens-gameday-greats-blue-san-jose-state-spartans-lightweight-basketball-jersey_pi4726000_ff_4726175-e6a6ade88b13a9e08009_full.jpg?_hv=2',59.99],
            [1,'SJSU Gameday Royal Jersey','Lightweight basketball jersey.','https://images.footballfanatics.com/san-jose-state-spartans/mens-gameday-greats-number-1-royal-san-jose-state-spartans-lightweight-basketball-jersey_ss5_p-200939480+u-r981abcxbwg6dbzqihcy+v-8zufjmlgvxfalrxufoig.png?_hv=2&w=400',64.99],
            [2,'Custom SJSU Gameday Jersey','Lightweight basketball jersey.','https://images.footballfanatics.com/san-jose-state-spartans/unisex-gameday-greats-white-san-jose-state-spartans-nil-pick-a-player-lightweight-soccer-jersey_ss5_p-200728453+u-1t2mkqqrxsanfey03el6+v-q0mdwdqeaixgiv93dmqr.jpg?_hv=2&w=400',79.99],
            [3,'SJSU Gameday Greats Blue Jersey','Lightweight basketball jersey.','https://images.footballfanatics.com/san-jose-state-spartans/mens-gameday-greats-blue-san-jose-state-spartans-lightweight-basketball-jersey_pi4726000_ff_4726175-e6a6ade88b13a9e08009_full.jpg?_hv=2&w=400',59.99],
            [4,'SJSU Gameday Greats White Jersey','Lightweight basketball jersey.','https://images.footballfanatics.com/san-jose-state-spartans/mens-gameday-greats-number-1-white-san-jose-state-spartans-lightweight-basketball-jersey_ss5_p-200939478+u-xvp0epcklssnbrypc8p5+v-gsbwtolktlbsbbcyvn3z.png?_hv=2&w=400',59.99],
            [5,'SJSU Gameday Greats Pink Jersey','Lightweight basketball jersey.','https://images.footballfanatics.com/san-jose-state-spartans/unisex-gameday-greats-number-1-pink-san-jose-state-spartans-lightweight-basketball-jersey_ss5_p-201141949+u-9lvr3hj9bzraapkebwzh+v-2i2m0oyavdyulpk1wg9l.jpg?_hv=2&w=400',59.99],
            [6,'SJSU Gameday Greats Royal Jersey','Lightweight basketball jersey.','https://images.footballfanatics.com/san-jose-state-spartans/unisex-gameday-greats-number-1-royal-san-jose-state-spartans-lightweight-basketball-fashion-jersey_ss5_p-202342842+u-plrdjkyflkxu3dsrfxm5+v-jgl8iwwgyt83dc62sb2i.jpg?_hv=2&w=400',59.99],
            [7,'SJSU Gameday Black Jersey','Lightweight football jersey.','https://images.footballfanatics.com/san-jose-state-spartans/mens-gameday-greats-number-1-black-san-jose-state-spartans-football-jersey_ss5_p-200588995+u-zosahcmxsdhfkgnscoik+v-igkbrgvtyt59mdn9wcor.jpg?_hv=2&w=400',69.99],
            [8,'SJSU Gameday Royal Spartan Jersey','Lightweight football jersey.','https://images.footballfanatics.com/san-jose-state-spartans/gameday-greats-number-1-royal-san-jose-state-spartans-lightweight-collegiate-football-fashion-jersey_ss5_p-202219860+u-psn6ewsmdhlwc7vm8zyk+v-acc2twbxsocxweensiwu.jpg?_hv=2&w=400',69.99],
            [9,'SJSU Gameday White Jersey','Lightweight football jersey.','https://images.footballfanatics.com/san-jose-state-spartans/mens-gameday-greats-number-1-white-san-jose-state-spartans-football-jersey_ss5_p-200588997+u-gaxepd6bkrlch3jmugnm+v-iwpwxemk6g9uwtokbwjf.jpg?_hv=2&w=400',69.99]
        ];

        $stmt = $pdo->prepare("INSERT IGNORE INTO products (id,name,`desc`,img,price) VALUES (?, ?, ?, ?, ?)");
        foreach ($products as $p) {
            $stmt->execute($p);
        }

        // Product visits
        $visits = [
            [0,7],[1,8],[2,53],[3,13],[4,1],[6,3],[8,2]
        ];
        $stmt = $pdo->prepare("INSERT IGNORE INTO product_visits (product_id,visits) VALUES (?,?)");
        foreach ($visits as $v) {
            $stmt->execute($v);
        }

        // General visits
        $general_visits = [
            [2,8]
        ];
        $stmt = $pdo->prepare("INSERT IGNORE INTO visits (product_id,visit_count) VALUES (?,?)");
        foreach ($general_visits as $v) {
            $stmt->execute($v);
        }

        // Reviews
        $reviews = [
            [1,0,'test',5,'25','2025-12-17 10:46:08'],
            [2,2,'test',5,'25','2025-12-17 10:52:50'],
            [3,2,'test2',5,'16','2025-12-17 10:53:13']
        ];
        $stmt = $pdo->prepare("INSERT IGNORE INTO reviews (id,product_id,username,rating,comment,created_at) VALUES (?,?,?,?,?,?)");
        foreach ($reviews as $r) {
            $stmt->execute($r);
        }

        echo "Database tables created and sample data inserted successfully.";

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
    ?>