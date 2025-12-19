<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'ai_summary',
        'summary_generated_at',
        'summary_model_used',
        'summary_tokens_used',
        'image',
        'category',
        'author',
        'is_published',
        'published_at',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'approved_at' => 'datetime',
        'summary_generated_at' => 'datetime',
        'is_published' => 'boolean',
        'summary_tokens_used' => 'integer'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_published', false);
    }

    public function scopeNeedsSummary($query)
    {
        return $query->whereNull('ai_summary')
            ->orWhere('summary_generated_at', '<', now()->subDays(30));
    }

    public function scopeRecentlySummarized($query)
    {
        return $query->whereNotNull('ai_summary')
            ->where('summary_generated_at', '>=', now()->subDays(7));
    }

    // Accessors & Mutators
    public function getSafeContentAttribute()
    {
        return strip_tags($this->content);
    }

    public function getSummaryAgeAttribute()
    {
        if (!$this->summary_generated_at) {
            return null;
        }
        return $this->summary_generated_at->diffForHumans();
    }

    public function getSummaryStatusAttribute()
    {
        if (!$this->ai_summary) {
            return 'not_generated';
        }

        if ($this->summary_generated_at < now()->subDays(30)) {
            return 'stale';
        }

        return 'fresh';
    }

    public function getTruncatedContentAttribute()
    {
        if (strlen($this->content) > 8000) {
            return mb_substr($this->content, 0, 8000) . '...';
        }
        return $this->content;
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = self::generateUniqueSlugStatic($article->title);
            }
        });

        static::saving(function ($article) {
            if (empty($article->excerpt)) {
                $article->excerpt = Str::limit(strip_tags($article->content), 150);
            }
        });
    }


    private static function generateUniqueSlugStatic($title)
    {
        $slug = Str::slug($title);
        $count = 1;
        $originalSlug = $slug;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
