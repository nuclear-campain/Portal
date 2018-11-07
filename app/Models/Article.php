<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Article
 *  
 * @todo Implemen spatie/sluggable 
 * @todo Implement filter scopes 
 * 
 * @package App\Models
 */
class Article extends Model
{
    use SoftDeletes; 

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

    }
}
