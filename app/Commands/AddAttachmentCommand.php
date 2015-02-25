<?php namespace App\Commands;

use App\Commands\Command;
use App\Attachment;
use Input;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\Blob\Models\CreateBlobOptions;

class AddAttachmentCommand extends Command implements SelfHandling, ShouldBeQueued {

	use InteractsWithQueue, SerializesModels;

	public $filename;
	public $filetype;
	public $extension;
	public $issue;
    public $author_id;
    public $connectionString;
    public $blobRestProxy;

    /**
     * Create a new command instance.
     *
     * @param  array $file
     * @param  int $issue
     * @param  int $author_id
     */
	public function __construct($file, $issue, $author_id)
	{
		$this->filename  = $file['filename'];
		$this->filetype	 = $file['filetype'];
		$this->extension = $file['extension'];
		$this->issue     = $issue;
        $this->author_id = $author_id;

        $this->connectionString = "DefaultEndpointsProtocol=https;AccountName=".env('AZURE_ACCOUNT_NAME').";AccountKey=".env('AZURE_STORAGE_KEY');
        // Create blob REST proxy.
        $this->blobRestProxy = ServicesBuilder::getInstance()->createBlobService($this->connectionString);
    }

    /**
     * Execute the command.
     *
     * @return void
    */
    public function handle()
    {

        $filename = preg_replace('/[^\w-.]/', '', $this->filename);

        // make a random file prefix
        $unique = false;
        while(!$unique) {
            $prefix = base_convert(rand(1,100000000),10,36);
            $exists = Attachment::where('filename','=',$prefix.'-'.$filename)->first();
            if(!$exists) $unique = true;
        }

        $filename = $prefix.'-'.$filename;
        $content = fopen('uploads/tmp/'.$this->filename, 'r');

        try {
            // Set some file options (content type)
            $options = new CreateBlobOptions();
            $options->setBlobContentType($this->filetype);
            // Create and upload blob to Azure
            $this->blobRestProxy->createBlockBlob("attachments", $filename, $content, $options);
            // Add an attachment entry to the database, assign it our issue id
            $attachment = new Attachment();
            $attachment->issue_id = $this->issue;
            $attachment->author_id = $this->author_id;
            $attachment->filename = $filename;
            $attachment->extension = $this->extension;
            $attachment->save();
			// Delete the temporary uploaded file
			fclose($content);
			unlink('uploads/tmp/'.$this->filename);
        }
        catch(ServiceException $e){
            // Handle exception based on error codes and messages.
            // Error codes and messages are here:
            // http://msdn.microsoft.com/en-us/library/windowsazure/dd179439.aspx
            $code = $e->getCode();
            $error_message = $e->getMessage();
            \Log::error($code.": ".$error_message);
        }
    }

}
