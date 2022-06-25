<?php

namespace App\Services\Audience;

use App\Models\Equipment\Audience;
use App\Services\BaseService;
use Illuminate\Support\Arr;

class UpdateAudienceService extends BaseService
{
    public function execute(array $data): Audience
    {
        $audience = Audience::findOrFail($data['id']);
        $audience->update(Arr::only(
            $data,
            ['building', 'number', 'letter', 'audience_type_id']
        ));

        if (Arr::has($data, ['equipment'])) {
            $audience->equipment()->sync($data['equipment']);
        }

        return $audience;
    }
}
