<?php

namespace App\Services\Work;

use App\Helpers\MorphHelper;
use App\Models\Equipment\Work;
use App\Services\BaseService;
use Illuminate\Support\Arr;

class CreateWorkService extends BaseService
{
    public function execute(array $data): Work
    {
        $data['workable_type'] = MorphHelper::getMorphType($data['workable_type']);

        $work = Work::create(Arr::only($data, [
            'workable_id',
            'workable_type',
            'work_type_id',
            'work_status_id',
            'started_at',
            'employee_id'
        ]));

        return $work;
    }
}
