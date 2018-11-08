<?php

namespace App\Models;

use App\User;
use CyrildeWit\EloquentViewable\Viewable;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Article
 *
 * @package App\Models
 */
class Article extends Model
{
    use SoftDeletes, Viewable;

    /**
     * Mass-assign fields for the storage table.
     *
     * @var array
     */
    protected $fillable = ['title', 'content'];

    /**
     * Relation for the author data that is attached to the article.
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault(['name' => 'unknown user']);
    }
}