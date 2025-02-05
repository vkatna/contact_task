<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Contact;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class ContactImportJob implements ShouldQueue
{
    protected $xmlFile;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($xmlFile)
    {
        $this->xmlFile = $xmlFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $xmlContent = Storage::get($this->xmlFile);
        $xml = new SimpleXMLElement($xmlContent);
        foreach ($xml->contact as $contactData) {
            Contact::create([
                'first_name' => (string) $contactData->name,
                'last_name' => (string) $contactData->lastName,
                'phone' => (string) $contactData->phone,
            ]);
        }
    }
}
