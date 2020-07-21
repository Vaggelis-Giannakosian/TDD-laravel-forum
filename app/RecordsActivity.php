<?php


namespace App;


trait RecordsActivity
{

    protected static function bootRecordsActivity()
    {
        if(auth()->guest()) return;

        foreach (static::getActivitesToRecord() as $event)
        {
            static::$event(fn($model)=>$model->recordActivity($event,$model));
        }

        static::deleted(fn($model)=>$model->activity()->delete());
    }

    protected static function getActivitesToRecord()
    {
        return ['created'];
    }

    protected function recordActivity($event,$model)
    {
        $model->activity()->create([
            'type' => $this->getActivityType($event),
            'user_id'=>auth()->id()
        ]);

    }


    public function activity()
    {
        return $this->morphMany(Activity::class,'subject');
    }

    /**
     * @param $event
     * @return string
     * @throws \ReflectionException
     */
    protected function getActivityType($event): string
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }

}
