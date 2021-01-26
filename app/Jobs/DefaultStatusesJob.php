<?php

namespace App\Jobs;

use App\Status;
use App\StatusNext;
use App\StatusType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DefaultStatusesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $flowID;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($flowID)
    {
        $this->flowID = $flowID;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (count($types = StatusType::all()) == 3)
        {
            foreach ($types as $type)
            {
                $status = new Status;
                $status->name_en = $type->name;
                $status->name_ar = $type->name;
                $status->x = RAND(-1,-800);
                $status->y = RAND(1,80);
                $status->status_flow = $this->flowID;
                $status->status_type = $type->id;
                $status->save();
            }

        }
        foreach (Status::where('status_flow', $this->flowID)->get() as $row){
            if (Status::where('statusID', '>', $row->statusID)->min('statusID') != null) {
                $next = new StatusNext;
                $next->FromStatus = $row->statusID;
                $next->ToStatus = Status::where('statusID', '>', $row->statusID)->min('statusID');
                $next->save();
            }
        }
    }
}
