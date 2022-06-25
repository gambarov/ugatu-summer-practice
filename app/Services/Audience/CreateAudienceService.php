<?php

namespace App\Services\Audience;

use App\Models\Equipment\Audience;
use App\Services\BaseService;
use Illuminate\Support\Arr;

class CreateAudienceService extends BaseService
{
    public function execute(array $data): Audience
    {
        $audience = Audience::create(Arr::only(
            $data,
            ['building', 'number', 'letter', 'audience_type_id']
        ));

        if (Arr::has($data, ['equipment'])) {
            $audience->equipment()->attach($data['equipment']);
        }

        return $audience;
    }
}
