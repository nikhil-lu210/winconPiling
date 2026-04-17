<?php

declare(strict_types=1);

final class MessageModel extends BaseModel
{
    protected string $table = 'messages';

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO ' . $this->table . ' (full_name, email, subject, service_interest, message, ip_address, is_read, is_starred, created_at)
             VALUES (?, ?, ?, ?, ?, ?, 0, 0, CURRENT_TIMESTAMP)'
        );
        $stmt->execute([
            $data['full_name'] ?? '',
            $data['email'] ?? '',
            $data['subject'] ?? null,
            $data['service_interest'] ?? null,
            $data['message'] ?? '',
            $data['ip_address'] ?? null,
        ]);
        return (int) $this->db->lastInsertId();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAll(): array
    {
        return $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC')->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getUnread(): array
    {
        return $this->db->query('SELECT * FROM ' . $this->table . ' WHERE is_read = 0 ORDER BY created_at DESC')->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getStarred(): array
    {
        return $this->db->query('SELECT * FROM ' . $this->table . ' WHERE is_starred = 1 ORDER BY created_at DESC')->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getFiltered(string $filter): array
    {
        return match ($filter) {
            'unread' => $this->getUnread(),
            'starred' => $this->getStarred(),
            default => $this->getAll(),
        };
    }

    public function getById(int $id): ?array
    {
        return $this->findById($id);
    }

    public function markRead(int $id): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE ' . $this->table . ' SET is_read = 1, read_at = CURRENT_TIMESTAMP WHERE id = ?'
        );
        return $stmt->execute([$id]);
    }

    /**
     * @param array<int, int> $ids
     */
    public function markReadMultiple(array $ids): bool
    {
        if ($ids === []) {
            return true;
        }
        $ids = array_map('intval', $ids);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare(
            'UPDATE ' . $this->table . ' SET is_read = 1, read_at = CURRENT_TIMESTAMP WHERE id IN (' . $placeholders . ')'
        );
        return $stmt->execute($ids);
    }

    public function toggleStar(int $id): bool
    {
        $row = $this->findById($id);
        if ($row === null) {
            return false;
        }
        $next = ((int) ($row['is_starred'] ?? 0)) === 1 ? 0 : 1;
        $stmt = $this->db->prepare('UPDATE ' . $this->table . ' SET is_starred = ? WHERE id = ?');
        return $stmt->execute([$next, $id]);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
    }

    /**
     * @param array<int, int> $ids
     */
    public function deleteMultiple(array $ids): bool
    {
        if ($ids === []) {
            return true;
        }
        $ids = array_map('intval', $ids);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare('DELETE FROM ' . $this->table . ' WHERE id IN (' . $placeholders . ')');
        return $stmt->execute($ids);
    }

    public function countUnread(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM ' . $this->table . ' WHERE is_read = 0')->fetchColumn();
    }

    public function countStarred(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM ' . $this->table . ' WHERE is_starred = 1')->fetchColumn();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRecent(int $limit = 5): array
    {
        $lim = max(1, min(100, $limit));
        $stmt = $this->db->query(
            'SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC LIMIT ' . $lim
        );
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
