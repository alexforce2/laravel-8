<?php

namespace Tests\Feature;

use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    public function testCreateEmptySchedule()
    {
        $data = [];

        $response = $this->json('post', route('schedule.store'), $data, [
            'Content-Type' => 'application/json'
        ]);

        $response->assertJsonValidationErrors(['title', 'start_at', 'end_at']);
    }

    public function testCreateScheduleWithWrongTitle()
    {
        $data = [
            'title' => Str::random(256),
            'start_at' => '2019-02-19',
            'end_at' => '2019-02-22'
        ];

        $response = $this->json('post', route('schedule.store'), $data, [
            'Content-Type' => 'application/json'
        ]);

        $response->assertJsonValidationErrors(['title']);

        $data = [
            'title' => [],
            'start_at' => '2019-02-19',
            'end_at' => '2019-02-22'
        ];

        $response = $this->json('post', route('schedule.store'), $data, [
            'Content-Type' => 'application/json'
        ]);

        $response->assertJsonValidationErrors(['title']);
    }

    public function testCreateScheduleWithWrongDateFormats()
    {
        $data = [
            'title' => 'Ромео и Джульетта',
            'start_at' => '19-02-2019',
            'end_at' => '21-03-2019'
        ];

        $response = $this->json('post', route('schedule.store'), $data, [
            'Content-Type' => 'application/json'
        ]);

        $response->assertJsonValidationErrors(['start_at', 'end_at']);
    }

    public function testCreateScheduleWithEndDateEarlierThenStartDate()
    {
        $data = [
            'title' => 'Ромео и Джульетта',
            'start_at' => '2019-02-19',
            'end_at' => '2019-02-15'
        ];

        $response = $this->json('post', route('schedule.store'), $data, [
            'Content-Type' => 'application/json'
        ]);

        $response->assertJsonValidationErrors(['end_at']);
    }

    public function testCreateScheduleWithBusyDate()
    {
        Schedule::create([
            'title' => 'Ромео и Джульетта',
            'start_at' => '2019-02-19',
            'end_at' => '2019-02-24'
        ]);

        $data = [
            'title' => 'Спартак',
            'start_at' => '2019-02-22',
            'end_at' => '2019-02-28'
        ];

        $response = $this->json('post', route('schedule.store'), $data, [
            'Content-Type' => 'application/json'
        ]);

        $response->assertJsonValidationErrors(['start_at']);

        $data = [
            'title' => 'Спартак',
            'start_at' => '2019-02-24',
            'end_at' => '2019-02-28'
        ];

        $response = $this->json('post', route('schedule.store'), $data, [
            'Content-Type' => 'application/json'
        ]);

        $response->assertJsonValidationErrors(['start_at']);

        $data = [
            'title' => 'Спартак',
            'start_at' => '2019-02-15',
            'end_at' => '2019-02-28'
        ];

        $response = $this->json('post', route('schedule.store'), $data, [
            'Content-Type' => 'application/json'
        ]);

        $response->assertJsonValidationErrors(['start_at']);
    }

    public function testSuccessCreateSchedule()
    {
        $data = [
            'title' => 'Ромео и Джульетта',
            'start_at' => '2019-02-19',
            'end_at' => '2019-02-22'
        ];

        $response = $this->json('post', route('schedule.store'), $data, [
            'Content-Type' => 'application/json'
        ]);

        $response->assertJsonFragment($data);

        $this->assertDatabaseHas('schedules', $data);
    }

    public function testDeleteSchedule()
    {
        $schedule = Schedule::factory()->create();

        $this->json('delete', route('schedule.destroy', [$schedule->id]));

        $this->assertDatabaseMissing('schedules', [
            'id' => $schedule->id
        ]);
    }

    public function testFetchSchedules()
    {
        $schedule = Schedule::factory()->create();

        $response = $this->json('get', route('schedule.index'));

        $response->assertJsonFragment([
            (new ScheduleResource($schedule))->toArray()
        ]);
    }
}
