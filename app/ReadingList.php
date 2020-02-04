<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class ReadingList
 * @package App
 */
class ReadingList extends Model
{
    protected $fillable = ['name', 'user_id'];
    protected $softDelete = true;

    /**
     * @return BelongsTo
     */
    public function User(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Return Books on this Reading List
     *
     * @return BelongsToMany
     */
    public function Books(): BelongsToMany {
        return $this->belongsToMany(Book::class, 'reading_list_books')->withPivot('order');
    }
}
