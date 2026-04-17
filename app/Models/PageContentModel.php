<?php

declare(strict_types=1);

final class PageContentModel extends BaseModel
{
    protected string $table = 'page_contents';

    /**
     * @return array<string, string|null>
     */
    public function getByPage(string $page): array
    {
        $stmt = $this->db->prepare('SELECT section_key, value FROM ' . $this->table . ' WHERE page = ?');
        $stmt->execute([$page]);
        $out = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $out[(string) $row['section_key']] = $row['value'] !== null ? (string) $row['value'] : null;
        }
        return $out;
    }

    public function getById(int $id): ?array
    {
        return $this->findById($id);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAll(): array
    {
        $stmt = $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY page ASC, section_key ASC');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function update(int $id, string $value): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE ' . $this->table . ' SET value = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?'
        );
        return $stmt->execute([$value, $id]);
    }

    public function updateByKey(string $page, string $key, string $value): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE ' . $this->table . ' SET value = ?, updated_at = CURRENT_TIMESTAMP WHERE page = ? AND section_key = ?'
        );
        return $stmt->execute([$value, $page, $key]);
    }
}
