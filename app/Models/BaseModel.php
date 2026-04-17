<?php

declare(strict_types=1);

abstract class BaseModel
{
    protected \PDO $db;
    protected string $table;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    protected function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM ' . $this->table . ' WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row !== false ? $row : null;
    }

    protected function findAll(string $orderBy = 'id ASC'): array
    {
        if (!preg_match('/^[a-zA-Z0-9_, ]+$/', $orderBy)) {
            $orderBy = 'id ASC';
        }
        return $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY ' . $orderBy)->fetchAll(\PDO::FETCH_ASSOC);
    }

    protected function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM ' . $this->table . ' WHERE id = ?');
        return $stmt->execute([$id]);
    }

    protected function updateTimestamp(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE ' . $this->table . ' SET updated_at = CURRENT_TIMESTAMP WHERE id = ?');
        $stmt->execute([$id]);
    }

    public function countAll(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM ' . $this->table)->fetchColumn();
    }
}
