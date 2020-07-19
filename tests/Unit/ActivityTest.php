<?php

namespace Tests\Unit;


use App\Activity;
use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();
        $thread = create(Thread::class);

        $this->assertDatabaseHas('activities',[
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => Thread::class
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id,$thread->id);
    }

    public function test_it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();
        $reply = create(Reply::class);

        $this->assertDatabaseHas('activities',[
            'type' => 'created_reply',
            'user_id' => auth()->id(),
            'subject_id' => $reply->id,
            'subject_type' => Reply::class
        ]);


        $activity = Activity::where(['type'=>'created_reply','subject_id'=>$reply->id,'subject_type'=>Reply::class])->first();

        $this->assertCount(2,Activity::all());
        $this->assertEquals($activity->subject->id,$reply->id);
    }


}
