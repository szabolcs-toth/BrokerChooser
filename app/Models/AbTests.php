<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AbTests extends Model
{
    use HasFactory;

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $table = 'abTests';

    /**
     * @return HasMany<AbTestVariables>
     */
    public function abTestVariable(): HasMany
    {
        return $this->hasMany(AbTestVariables::class, 'abTestId', 'id');
    }
}
