<?php

declare(strict_types=1);

final class LandListingModel extends BaseModel
{
    protected string $table = 'land_listings';

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

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getByCategory(string $category): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM ' . $this->table . ' WHERE category = ? AND is_active = 1 ORDER BY sort_order ASC, id ASC'
        );
        $stmt->execute([$category]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): int
    {
        $cols = ['title', 'category', 'description', 'location', 'size_sqm', 'price', 'features', 'image_path', 'is_active', 'sort_order'];
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
            throw new \InvalidArgumentException('No data for land listing create');
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
        $allowed = ['title', 'category', 'description', 'location', 'size_sqm', 'price', 'features', 'image_path', 'is_active', 'sort_order'];
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
        $row = $this->findById($id);
        if ($row === null) {
            return false;
        }
        $imagePath = (string) ($row['image_path'] ?? '');
        if ($imagePath !== '') {
            $full = ROOT_PATH . '/public/assets/uploads/' . ltrim(str_replace(['\\', '..'], '/', $imagePath), '/');
            if (is_file($full)) {
                @unlink($full);
            }
        }
        return parent::delete($id);
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
     * @param array<string, mixed> $listing
     * @return array<int, mixed>
     */
    public function decodeFeatures(array $listing): array
    {
        $raw = $listing['features'] ?? '[]';
        if (!is_string($raw) || $raw === '') {
            return [];
        }
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }
}
