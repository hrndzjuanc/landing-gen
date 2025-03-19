<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
class Landing extends Model
{
    protected $fillable = [
        'landing_name',
        'subdomain',
        'subdomain_id',
        'header_type',
        'links',
        // 'body_json',
        'body',
        'footer_type',
        'footer_text',
    ];

    protected $casts = [
        'links' => 'array',
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($landing) {
            if ($landing->subdomain_id) {
                $response = Http::withToken(env('CLOUDFLARE_API_TOKEN'))
                    ->delete("https://api.cloudflare.com/client/v4/zones/" . env('CLOUDFLARE_ZONE_ID') . "/dns_records/{$landing->subdomain_id}");
            }
        });
    }
}
