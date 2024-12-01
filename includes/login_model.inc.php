<?php

declare(strict_types=1);

function get_user(object $pdo, string $username) {
    $query = "SELECT tbl_username.username_id, tbl_username.`username`, tbl_users.`pword`, tbl_users.depart_no, tbl_users.img_filename
              FROM tbl_username
              JOIN tbl_users ON tbl_users.`username_no` = tbl_username.`username_id`
              WHERE BINARY tbl_username.`username` = :username LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        throw new Exception("Username or Password is Incorrect!");
    }

    return $result;
}

function mark_as_active(object $pdo, int $user_id, int $whatop) {
    if ($whatop === 1 || $whatop === 0) {
        $query = "UPDATE tbl_users SET isactive = :isactive WHERE user_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':isactive' => $whatop, ':user_id' => $user_id]);

        $query = "UPDATE `tbl_users_audit_trail` SET last_login = CURRENT_TIMESTAMP WHERE user_at_id = :user_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':user_id' => $user_id]);
        return true;
    }

    return false;
}

function is_locked_out(object $pdo, string $ipadd, string $username): array {
    $stmt = $pdo->prepare("SELECT failed_attempts, lockout_until FROM login_attempts WHERE ip_add = ? AND username = ? LIMIT 1");
    $stmt->execute([$ipadd, $username]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $is_locked = $result['lockout_until'] && strtotime($result['lockout_until']) > time();
        return [
            'locked' => $is_locked,
            'failed_attempts' => (int)$result['failed_attempts'],
            'lockout_until' => $result['lockout_until']
        ];
    }

    return ['locked' => false, 'failed_attempts' => 0, 'lockout_until' => null];
}

function log_failed_attempt(object $pdo, string $ipadd, string $username): void {
    $data = is_locked_out($pdo, $ipadd, $username);
    $failed_attempts = $data['failed_attempts'] + 1;

    $lockout_duration = 0;
    if ($failed_attempts == 3) {
        $lockout_duration = 15;
    } elseif ($failed_attempts == 6) {
        $lockout_duration = 30;
    } elseif ($failed_attempts == 9) {
        $lockout_duration = 60;
    }

    $lockout_until = $lockout_duration > 0 ? date('Y-m-d H:i:s', time() + ($lockout_duration * 60)) : null;

    try {
        if ($data['failed_attempts'] > 0) {
            $stmt = $pdo->prepare("UPDATE login_attempts SET failed_attempts = ?, lockout_until = ?, last_attempt = NOW() WHERE ip_add = ? AND username = ?");
            $stmt->execute([$failed_attempts, $lockout_until, $ipadd, $username]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO login_attempts (ip_add, username, failed_attempts, lockout_until) VALUES (?, ?, ?, ?)");
            $stmt->execute([$ipadd, $username, $failed_attempts, $lockout_until]);
        }
    } catch (PDOException $e) {
        throw new Exception("Database Error: " . $e->getMessage());
    }
}


function reset_lockout(object $pdo, string $ip_address, $username) {
    try {

        $stmt = $pdo->prepare("DELETE FROM login_attempts WHERE ip_add = ? AND username = ?");
        $stmt->execute([$ip_address, $username]);

        return true;
        
    } catch (PDOException $e) {
        throw new Exception("Database Error: " . $e->getMessage());
    }
}
