<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbTestVariables extends Model
{
    use HasFactory;

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $table = 'abTestVariables';

    /**
     * @return BelongsTo<AbTests, AbTestVariables>
     */
    public function abTests(): BelongsTo
    {
        return $this->belongsTo(AbTests::class, 'abTestId', 'id');
    }
}
