<?php

declare(strict_types=1);

final class AdminUserModel extends BaseModel
{
    protected string $table = 'admin_users';

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM ' . $this->table . ' WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row !== false ? $row : null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM ' . $this->table . ' WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row !== false ? $row : null;
    }

    public function updateLastLogin(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE ' . $this->table . ' SET last_login = CURRENT_TIMESTAMP WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function incrementLoginAttempts(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE ' . $this->table . ' SET login_attempts = COALESCE(login_attempts, 0) + 1 WHERE id = ?');
        $stmt->execute([$id]);
    }

    /** After five failed attempts, lock the account for 15 minutes. */
    public function recordFailedLogin(int $id): void
    {
        $this->incrementLoginAttempts($id);
        $row = $this->findById($id);
        if ($row === null) {
            return;
        }
        if ((int) ($row['login_attempts'] ?? 0) >= 5) {
            $this->lockAccount($id, 15);
        }
    }

    public function resetLoginAttempts(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE ' . $this->table . ' SET login_attempts = 0, locked_until = NULL WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function lockAccount(int $id, int $minutes = 15): void
    {
        $until = date('Y-m-d H:i:s', time() + $minutes * 60);
        $stmt = $this->db->prepare('UPDATE ' . $this->table . ' SET locked_until = ? WHERE id = ?');
        $stmt->execute([$until, $id]);
    }

    /**
     * @param array<string, mixed> $user
     */
    public function isLocked(array $user): bool
    {
        $until = $user['locked_until'] ?? null;
        if ($until === null || $until === '') {
            return false;
        }
        $t = strtotime((string) $until);
        return $t !== false && $t > time();
    }

    public function updatePassword(int $id, string $newHash): bool
    {
        $stmt = $this->db->prepare('UPDATE ' . $this->table . ' SET password_hash = ? WHERE id = ?');
        return $stmt->execute([$newHash, $id]);
    }
}
