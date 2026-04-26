<?php

namespace Database\Seeders;

use App\Models\Site;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tools = config('specialized_tools', []);

        foreach ($tools as $siteKey => $tool) {
            $site = Site::updateOrCreate(
                ['site_key' => $siteKey],
                [
                    'name' => $tool['name'] ?? Str::title(str_replace('-', ' ', $siteKey)),
                    'url' => $tool['url'] ?? '',
                    'description' => $tool['description'] ?? null,
                    'admin_email' => $this->defaultAdminEmail($tool['url'] ?? ''),
                    'is_active' => true,
                ]
            );

            $hasToken = $site->tokens()->where('name', $siteKey)->exists();

            if (! $hasToken) {
                $token = $site->createToken($siteKey)->plainTextToken;

                if ($this->command !== null) {
                    $this->command->warn("Site key [$siteKey] token (shown once): $token");
                }
            }
        }
    }

    private function defaultAdminEmail(string $url): string
    {
        $host = parse_url($url, PHP_URL_HOST);

        if (! is_string($host) || $host === '') {
            return 'admin@yourlaraveldomain.com';
        }

        return 'admin@'.$host;
    }
}
