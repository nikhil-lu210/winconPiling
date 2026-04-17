<?php

declare(strict_types=1);

final class SiteSettingModel extends BaseModel
{
    protected string $table = 'site_settings';

    /**
     * @return array<string, string|null>
     */
    public function getAll(): array
    {
        $stmt = $this->db->query('SELECT setting_key, setting_value FROM ' . $this->table);
        $out = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $out[(string) $row['setting_key']] = $row['setting_value'] !== null ? (string) $row['setting_value'] : null;
        }
        return $out;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAllRows(): array
    {
        return $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY setting_key ASC')->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $stmt = $this->db->prepare('SELECT setting_value FROM ' . $this->table . ' WHERE setting_key = ?');
        $stmt->execute([$key]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($row === false) {
            return $default;
        }
        return $row['setting_value'] ?? $default;
    }

    public function set(string $key, mixed $value): bool
    {
        $val = $value === null ? null : (string) $value;
        $stmt = $this->db->prepare('SELECT id FROM ' . $this->table . ' WHERE setting_key = ?');
        $stmt->execute([$key]);
        if ($stmt->fetch() !== false) {
            $u = $this->db->prepare(
                'UPDATE ' . $this->table . ' SET setting_value = ?, updated_at = CURRENT_TIMESTAMP WHERE setting_key = ?'
            );
            return $u->execute([$val, $key]);
        }
        $i = $this->db->prepare(
            'INSERT INTO ' . $this->table . ' (setting_key, setting_value, updated_at) VALUES (?, ?, CURRENT_TIMESTAMP)'
        );
        return $i->execute([$key, $val]);
    }

    /**
     * @param array<string, mixed> $settings
     */
    public function updateMultiple(array $settings): void
    {
        foreach ($settings as $key => $value) {
            $this->set((string) $key, $value);
        }
    }
}
