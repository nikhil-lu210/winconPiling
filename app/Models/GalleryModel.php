<?php

declare(strict_types=1);

final class GalleryModel extends BaseModel
{
    protected string $table = 'gallery_items';

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
     * @return array<int, array<string, mixed>>
     */
    public function getFeatured(int $limit = 3): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM ' . $this->table . ' WHERE is_featured = 1 AND is_active = 1 ORDER BY sort_order ASC, id ASC LIMIT ' . (int) $limit
        );
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array
    {
        return $this->findById($id);
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): int
    {
        $cols = ['title', 'description', 'category', 'image_path', 'alt_text', 'sort_order', 'is_featured', 'is_active'];
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
            throw new \InvalidArgumentException('No data for gallery create');
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
        $allowed = ['title', 'description', 'category', 'image_path', 'alt_text', 'sort_order', 'is_featured', 'is_active'];
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
        self::deleteStoredImage($imagePath);
        return parent::delete($id);
    }

    public static function deleteStoredImage(string $relativePath): void
    {
        if ($relativePath === '') {
            return;
        }
        if (str_starts_with($relativePath, 'http://') || str_starts_with($relativePath, 'https://')) {
            return;
        }
        $full = ROOT_PATH . '/public/assets/uploads/' . ltrim(str_replace(['\\', '..'], '/', $relativePath), '/');
        if (is_file($full)) {
            @unlink($full);
        }
    }

    /**
     * @param array<int, array{id: int, sort: int}>|array<int, array<string, int>> $order
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
     * @return array<int, string>
     */
    public function getCategories(): array
    {
        $stmt = $this->db->query('SELECT DISTINCT category FROM ' . $this->table . ' ORDER BY category ASC');
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
}
