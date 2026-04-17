<?php

declare(strict_types=1);

final class ServiceModel extends BaseModel
{
    protected string $table = 'services';

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAll(bool $activeOnly = true): array
    {
        $sql = 'SELECT * FROM ' . $this->table;
        if ($activeOnly) {
            $sql .= ' WHERE is_active = 1';
        }
        $sql .= ' ORDER BY sort_order ASC, id ASC';
        return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array
    {
        return $this->findById($id);
    }

    public function getBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM ' . $this->table . ' WHERE slug = ? AND is_active = 1');
        $stmt->execute([$slug]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row !== false ? $row : null;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): int
    {
        $cols = ['title', 'slug', 'short_description', 'full_description', 'icon_class', 'sub_items', 'detail_page_slug', 'sort_order', 'is_active'];
        $fields = [];
        $placeholders = [];
        $values = [];
        foreach ($cols as $c) {
            if (array_key_exists($c, $data)) {
                $fields[] = $c;
                $placeholders[] = '?';
                $values[] = $data[$c];
            }
        }
        if ($fields === []) {
            throw new \InvalidArgumentException('No data for service create');
        }
        $sql = 'INSERT INTO ' . $this->table . ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $placeholders) . ')';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
        return (int) $this->db->lastInsertId();
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(int $id, array $data): bool
    {
        $allowed = ['title', 'slug', 'short_description', 'full_description', 'icon_class', 'sub_items', 'detail_page_slug', 'sort_order', 'is_active'];
        $sets = [];
        $values = [];
        foreach ($allowed as $c) {
            if (array_key_exists($c, $data)) {
                $sets[] = $c . ' = ?';
                $values[] = $data[$c];
            }
        }
        if ($sets === []) {
            return false;
        }
        $sets[] = 'updated_at = CURRENT_TIMESTAMP';
        $values[] = $id;
        $sql = 'UPDATE ' . $this->table . ' SET ' . implode(', ', $sets) . ' WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
    }

    public function slugExists(string $slug, ?int $exceptId = null): bool
    {
        if ($exceptId === null) {
            $stmt = $this->db->prepare('SELECT id FROM ' . $this->table . ' WHERE slug = ? LIMIT 1');
            $stmt->execute([$slug]);
        } else {
            $stmt = $this->db->prepare('SELECT id FROM ' . $this->table . ' WHERE slug = ? AND id != ? LIMIT 1');
            $stmt->execute([$slug, $exceptId]);
        }
        return $stmt->fetch() !== false;
    }

    /**
     * @param array<int, array{id: int, sort: int}|array<string, int>> $order
     */
    public function updateSortOrder(array $order): void
    {
        $this->db->beginTransaction();
        try {
            foreach ($order as $row) {
                $id = (int) ($row['id'] ?? 0);
                $sort = (int) ($row['sort'] ?? $row['sort_order'] ?? 0);
                if ($id <= 0) {
                    continue;
                }
                $stmt = $this->db->prepare('UPDATE ' . $this->table . ' SET sort_order = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?');
                $stmt->execute([$sort, $id]);
            }
            $this->db->commit();
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /**
     * @param array<string, mixed> $service
     * @return array<int, mixed>
     */
    public function decodeSubItems(array $service): array
    {
        $raw = $service['sub_items'] ?? '[]';
        if (!is_string($raw) || $raw === '') {
            return [];
        }
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }
}
